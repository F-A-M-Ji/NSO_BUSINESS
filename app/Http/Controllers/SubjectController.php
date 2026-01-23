<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Enums\UserRole;
use App\Models\ReportStatus;

class SubjectController extends Controller
{
    private function ensureSubject(): void
    {
        $user = Auth::user();
        if (!$user || $user->role !== UserRole::SUBJECT) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }
    }

    public function index(Request $request)
    {
        $this->ensureSubject();

        // 2. รายชื่อคอลัมน์ที่จะแสดง (ตามที่คุณระบุ)
        $columns = [
            'ID',
            'REG',
            'CWT',
            'AMP',
            'TAM',
            'MUN',
            'EA',
            'VIL',
            'TSIC_R',
            'TSIC_L',
            'SIZE_R',
            'SIZE_L',
            'YR',
            'ENU',
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
            'D01',
            'D02',
            'Remarks_04',
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
            'H01',
            'H02',
            'H03',
            'H04'
        ];

        // 3. Query ข้อมูล
        $query = Report::query()
            ->join('reports_status', 'reports.ID', '=', 'reports_status.ID')
            // ✅ เงื่อนไข: ส่งแล้ว และ อนุมัติแล้ว
            ->where('reports_status.isSend', '1')
            ->where('reports_status.isApprove', '1')
            ->select('reports.*'); // เลือกข้อมูลจากตาราง reports ทั้งหมด

        // --- Filter Logic ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reports.ID', 'like', "%{$search}%")
                    ->orWhere('reports.NO', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cwt')) {
            $query->where('reports.CWT', $request->cwt);
        }

        // ✅ เรียงตาม CWT ก่อน แล้วค่อย NO
        $items = $query->orderBy('reports.CWT', 'asc')
            ->orderBy('reports.NO', 'asc')
            ->paginate(10); // ข้อมูลเยอะ แสดงทีละ 50 แถว

        // ข้อมูลประกอบ Filter
        $provinces = config('provinces');

        return view('subject.report_list', compact('items', 'columns', 'provinces'));
    }

    public function reportWrong(Request $request)
    {
        $this->ensureSubject();

        // Validate ข้อมูล
        $request->validate([
            'id' => ['required', 'digits:15', 'exists:reports,ID'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        $id = $request->input('id');
        $message = $request->input('message');

        // อัปเดตตาราง reports_status
        ReportStatus::updateOrCreate(
            ['ID' => $id], // เงื่อนไขค้นหา
            [
                'messages' => $message,
                'isWrong' => '1',    // แจ้งว่าผิดปกติ
                'isApprove' => '0',  // ยกเลิกการอนุมัติ (เพื่อให้ Supervisor หรือ Interviewer แก้ไข)
            ]
        );

        return redirect()->back()->with('success', "บันทึกหมายเหตุสำหรับ ID $id เรียบร้อยแล้ว");
    }
}
