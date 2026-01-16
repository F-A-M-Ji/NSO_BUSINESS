<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Control;
use App\Models\Report;
use App\Models\ReportStatus;
use App\Models\EditReport;
use App\Enums\UserRole;

class SurveyController extends Controller
{

    private function getSurveyData($id)
    {
        $report = Report::where('ID', $id)->first();
        if ($report) {
            return $report;
        }
        return Control::where('ID', $id)->firstOrFail();
    }

    private function checkAuthorization($data)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $restrictedRoles = [
                UserRole::INTERVIEWER->value,
                UserRole::SUPERVISOR->value,
                UserRole::SUBJECT->value,
            ];

            if (in_array($user->role->value, $restrictedRoles)) {
                $dataCwt = (string)$data->CWT;
                $userProvince = (string)$user->province_code;

                if ($dataCwt !== $userProvince) {
                    abort(403, "คุณไม่มีสิทธิ์เข้าถึงข้อมูลของจังหวัดอื่น (CWT: $dataCwt)");
                }
            }
        }
    }

    public function search()
    {
        return view('survey.search');
    }

    public function check(Request $request)
    {
        $request->validate([
            'establishment_id' => 'required|digits:15',
        ], [
            'establishment_id.required' => 'กรุณากรอกรหัส ID',
            'establishment_id.digits' => 'รหัสต้องมี 15 หลัก',
        ]);
        $control = Control::where('ID', $request->establishment_id)->first();

        if (!$control) {
            return back()
                ->withInput()
                ->withErrors(['establishment_id' => 'ไม่พบข้อมูลรหัส ID นี้ในระบบ']);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $restrictedRoles = [
                UserRole::INTERVIEWER->value,
                UserRole::SUPERVISOR->value,
                UserRole::SUBJECT->value,
            ];
            if (in_array($user->role->value, $restrictedRoles)) {
                $controlCwt = (string)$control->CWT;
                $userProvince = (string)$user->province_code;
                if ($controlCwt !== $userProvince) {
                    return back()
                        ->withInput()
                        ->withErrors(['establishment_id' => "คุณไม่มีสิทธิ์เข้าถึงข้อมูลของจังหวัดอื่น (CWT: $controlCwt)"]);
                }
            }
        }
        return redirect()->route('survey.form', ['id' => $control->ID]);
    }

    // ---------------------------------------------------------------------------

    private function updateWorkFlowStatus($id)
    {
        $user = Auth::user();
        if (!$user) return;

        $now = now();

        // แนะนำใช้ transaction เพื่อให้สองตารางอัปเดตพร้อมกัน
        DB::transaction(function () use ($id, $user, $now) {

            // กรณี: INTERVIEWER (ส่งงาน)
            if ($user->role->value === UserRole::INTERVIEWER->value) {

                ReportStatus::where('ID', $id)->update([
                    'isSend'    => 1,
                    'isApprove' => 0,
                    'send_time' => $now,
                    'isWrong'   => 0,
                    'messages'  => null,
                ]);

                // อัปเดต reports.H04 เป็น NULL
                Report::where('ID', $id)->update([
                    'H04' => null,
                ]);
            }

            // กรณี: SUPERVISOR (อนุมัติงาน)
            elseif ($user->role->value === UserRole::SUPERVISOR->value) {

                ReportStatus::where('ID', $id)->update([
                    'isApprove'    => 1,
                    'approve_time' => $now,
                    'isWrong'      => 0,
                    'messages'     => null,
                ]);

                $report = Report::where('ID', $id)->first();
                if ($report) {
                    $this->copyReportToEditTable($report);
                }
            }
        });
    }

    private function copyReportToEditTable($report)
    {
        $data = $report->toArray();

        unset($data['pk']);
        unset($data['created_at']);
        unset($data['updated_at']);

        EditReport::updateOrCreate(
            ['ID' => $report->ID], // เงื่อนไขค้นหา
            $data                  // ข้อมูลที่จะบันทึก
        );
    }

    // ---------------------------------------------------------------------------

    private function saveToSession($id, $data)
    {
        $currentData = Session::get("survey_data_{$id}", []);

        // กัน null ไปทับของเดิม/ของ control
        $data = array_filter($data, fn($v) => $v !== null);

        Session::put("survey_data_{$id}", array_merge($currentData, $data));
    }

    private function saveReportToDB($id)
    {
        $allData = Session::get("survey_data_{$id}", []);
        $allData = array_filter($allData, fn($v) => $v !== null);

        $exists = Report::where('ID', $id)->exists();

        if (!$exists) {
            $control = Control::where('ID', $id)->first();
            if ($control) {
                $baseData = [
                    'REG' => $control->REG,
                    'CWT' => $control->CWT,
                    'AMP' => $control->AMP,
                    'TAM' => $control->TAM,
                    'MUN' => $control->MUN,
                    'EA'  => $control->EA,
                    'VIL' => $control->VIL,
                    'TSIC_R' => $control->TSIC_CODE,
                    'TSIC_L' => null,
                    'SIZE_R' => $control->SIZE12,
                    'SIZE_L' => null,
                    'NO' => $control->NO,
                    'YR' => $control->YR,
                ];
                $allData = array_merge($baseData, $allData);
            }
        }

        Report::updateOrCreate(['ID' => $id], $allData);
        Session::forget("survey_data_{$id}");
    }



    private function prepareDataForView($id)
    {
        // 1. ดึงข้อมูลพื้นฐาน (จาก Reports หรือ Controls)
        $control = $this->getSurveyData($id);
        $this->checkAuthorization($control);

        // 2. ดึงข้อมูลจาก Session (ถ้ามี) มาทับ
        // เพื่อให้ User เห็นค่าล่าสุดที่เพิ่งกรอกไป (แม้จะยังไม่ได้บันทึกลง DB)
        $sessionData = Session::get("survey_data_{$id}", []);
        foreach ($sessionData as $key => $value) {
            $control->$key = $value;
        }

        return $control;
    }

    // ฟอร์ม 1 --------------------------------------------------------------------

    public function form($id)
    {
        // ใช้ Helper ที่สร้างใหม่ เพื่อความสั้นและ Clean
        $control = $this->prepareDataForView($id);

        return view('survey.form_part0', compact('control'));
    }

    public function storePart0(Request $request)
    {
        $id = $request->input('id');
        $data = [
            'REG' => $request->input('reg'),
            'CWT' => $request->input('cwt'),
            'AMP' => $request->input('amp'),
            'TAM' => $request->input('tam'),
            'MUN' => $request->input('est_area') == 'in' ? 1 : ($request->input('est_area') == 'out' ? 2 : $request->input('mun')),
            'EA'  => $request->input('ea'),
            'VIL' => $request->input('vil'),
            'TSIC_R' => $request->input('tsic_r'),
            'TSIC_L' => $request->input('tsic_l'),
            'SIZE_R' => $request->input('size_r'),
            'SIZE_L' => $request->input('size_l'),
            'NO'  => $request->input('no'),
            'YR'  => $request->input('yr'),
            'ENU'    => $request->input('enu'),
            'TITLE',
            'RANK',
            'FIRSTNAME',
            'LASTNAME',
            'EST_TITLE',
            'EST_NAME',
            'ANSWER',
            'ADD_NO',
            'BUILDING',
            'ROOM',
            'STREET',
            'BLK',
            'SOI',
            'SUB_DIST',
            'DISTRICT',
            'PROVINCE',
            'POST_CODE',
            'TEL_NO',
            'E_MAIL',
            'WEB_SITE',
            'SOCIAL',
            'TYPE',
            'ADD_NO_1',
            'BUILDING_1',
            'ROOM_1',
            'STREET_1',
            'BLK_1',
            'SOI_1',
            'SUB_DIST_1',
            'DISTRICT_1',
            'PROVINCE_1',
            'POST_CODE_1',
            'TEL_NO_1',
            'E_MAIL_1',
            'WEB_SITE_1',
            'SOCIAL_1',
        ];

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part1', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    public function part1($id)
    {
        $control = $this->prepareDataForView($id); // ดึงข้อมูลล่าสุด
        return view('survey.form_part1', compact('control'));
    }

    public function storePart1(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'A01',
            'A02',
            'A03',
            'A04',
            'A05',
            'A06',
            'TITLE_2',
            'RANK_2',
            'FIRSTNAME_2',
            'LASTNAME_2',
            'EST_TITLE_2',
            'EST_NAME_2',
            'ADD_NO_2',
            'BUILDING_2',
            'ROOM_2',
            'STREET_2',
            'BLK_2',
            'SOI_2',
            'SUB_DIST_2',
            'DISTRICT_2',
            'PROVINCE_2',
            'POST_CODE_2',
            'TEL_NO_2',
            'E_MAIL_2',
            'WEB_SITE_2',
            'SOCIAL_2',
            'A061',
            'A07',
            'A08',
            'A081',
            'A09',
            'A10',
            'A11',
            'A12',
            'A13',
            'A14',
            'A15',
            'A16',
            'A17',
            'A18',
            'Remarks_01',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part2', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    // 2. แสดงหน้า Part 2
    public function part2($id)
    {
        $control = Control::where('ID', $id)->firstOrFail();
        return view('survey.form_part2', compact('control'));
    }

    // 3. รับค่าจาก Part 2 -> ไป Part 3 (หรือหน้าถัดไป)
    public function storePart2(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'B01',
            'B02',
            'B03',
            'B04',
            'B05',
            'B06',
            'B07',
            'B08',
            'B09',
            'B10',
            'B11',
            'B12',
            'B13',
            'B14',
            'B15',
            'B16',
            'B17',
            'B18',
            'B19',
            'B20',
            'B21',
            'B22',
            'B23',
            'B24',
            'B25',
            'Remarks_02',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part3', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    // 2. แสดงหน้า Part 3
    public function part3($id)
    {
        $control = $this->prepareDataForView($id);
        return view('survey.form_part3', compact('control'));
    }

    // 3. รับค่าจาก Part 3 -> ไปหน้าถัดไป (หรือหน้าจบ)
    public function storePart3(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'C01',
            'C02',
            'C03',
            'C04',
            'C05',
            'C06',
            'C07',
            'C08',
            'C09',
            'C10',
            'C11',
            'C12',
            'C13',
            'C14',
            'C15',
            'C16',
            'C17',
            'C18',
            'C19',
            'C20',
            'C21',
            'C211',
            'C22',
            'Remarks_03',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part4', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    // 2. แสดงหน้า Part 4
    public function part4($id)
    {
        $control = $this->prepareDataForView($id);
        return view('survey.form_part4', compact('control'));
    }

    // 3. บันทึกข้อมูล Part 4 (และจบการทำงาน หรือไปหน้าถัดไป)
    public function storePart4(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'D01',
            'D02',
            'Remarks_04',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part5', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    // 2. แสดงหน้า Part 5
    public function part5($id)
    {
        $control = $this->prepareDataForView($id);
        return view('survey.form_part5', compact('control'));
    }

    // 3. บันทึกข้อมูล Part 5 -> ส่งไป Part 6
    public function storePart5(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'E01',
            'E02',
            'E03',
            'E04',
            'E05',
            'E06',
            'E07',
            'E08',
            'E09',
            'E10',
            'E11',
            'E12',
            'E121',
            'E13',
            'Remarks_05',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part6', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    public function part6($id)
    {
        $control = $this->prepareDataForView($id);
        return view('survey.form_part6', compact('control'));
    }

    // 3. บันทึกข้อมูล Part 6 -> ส่งไป Part 7 (ตอนจบ)
    public function storePart6(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'F01',
            'F02',
            'F03',
            'F04',
            'F05',
            'F06',
            'F07',
            'F08',
            'F09',
            'F10',
            'F11',
            'F12',
            'F13',
            'F131',
            'F14',
            'F15',
            'F16',
            'F17',
            'Remarks_06',
        ]);

        $this->saveToSession($id, $data);
        return redirect()->route('survey.part7', ['id' => $id]);
    }

    // --------------------------------------------------------------------

    public function part7($id)
    {
        $control = $this->prepareDataForView($id);
        return view('survey.form_part7', compact('control'));
    }

    // 3. บันทึกข้อมูล Part 7 และ **จบการทำงาน**
    public function storePart7(Request $request)
    {
        $id = $request->input('id');
        $data = $request->only([
            'G01',
            'G02',
            'G03',
            'G04',
            'G05',
            'G06',
            'G07',
            'G08',
            'G09',
            'G10',
            'G11',
            'G12',
            'G13',
            'G14',
            'G141',
            'G15',
            'G16',
            'G17',
            'G18',
            'G19',
            'G20',
            'G21',
            'G22',
            'G23',
            'G24',
            'G25',
            'G26',
            'G27',
            'G271',
            'Remarks_07',
        ]);

        $staffData = [
            'H01' => $request->input('staff_collector'), // ผู้เก็บรวบรวม
            'H02' => $request->input('staff_editor'),    // บรรณาธิกร
            'H03' => $request->input('staff_recorder'),  // ผู้บันทึก
            'H04' => $request->input('staff_inspector'), // ผู้ตรวจ
        ];

        $finalData = array_merge($data, $staffData);

        $this->saveToSession($id, $finalData);
        $this->saveReportToDB($id);
        $this->updateWorkFlowStatus($id);
        return redirect()->route('survey.thankYou');
    }

    // --------------------------------------------------------------------

    public function thankYou()
    {
        return view('survey.thank_you');
    }

    // --------------------------------------------------------------------

    public function approve($id)
    {
        $user = Auth::user();

        if ($user->role->value !== UserRole::SUPERVISOR->value) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $now = now();

        Report::where('ID', $id)->update([
            'H04' => $user->username
        ]);

        ReportStatus::updateOrCreate(
            ['ID' => $id],
            [
                'isApprove' => '1',
                'approve_time' => $now
            ]
        );

        $report = Report::where('ID', $id)->first();
        if ($report) {
            $this->copyReportToEditTable($report);
        }

        return response()->json([
            'success' => true,
            'inspector_name' => $user->firstname . ' ' . $user->lastname
        ]);
    }
}
