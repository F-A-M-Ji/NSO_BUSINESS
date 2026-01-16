<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Control;
use App\Enums\UserRole;

class DashboardController extends Controller
{
    /**
     * แสดงหน้าติดตามงาน
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // ตรวจสอบสิทธิ์ (เฉพาะ INTERVIEWER และ SUPERVISOR)
        $allowedRoles = [UserRole::INTERVIEWER, UserRole::SUPERVISOR];

        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        $provinceCode = $user->province_code;

        // ---------------------------------------------------------
        // 1. คำนวณสถิติ (Stats) - ส่วนนี้ไม่เปลี่ยนตาม Filter (แสดงภาพรวมเสมอ)
        // ---------------------------------------------------------

        $total = Control::where('CWT', $provinceCode)->count();

        $statsQuery = Control::where('controls.CWT', $provinceCode)
            ->join('reports_status', 'controls.ID', '=', 'reports_status.ID')
            ->selectRaw("
                count(CASE WHEN isSend = '1' AND (isApprove = '0' OR isApprove IS NULL) THEN 1 END) as saved,
                count(CASE WHEN isSend = '1' AND isApprove = '1' THEN 1 END) as approved,
                count(CASE WHEN isSend = '1' THEN 1 END) as total_sent
            ")
            ->first();

        $saved = $statsQuery->saved ?? 0;
        $approved = $statsQuery->approved ?? 0;
        $notSaved = $total - ($statsQuery->total_sent ?? 0);

        // ---------------------------------------------------------
        // 2. ดึงข้อมูลตาราง (Table Data) พร้อม Filter
        // ---------------------------------------------------------
        $query = Control::where('controls.CWT', $provinceCode)
            ->leftJoin('reports_status', 'controls.ID', '=', 'reports_status.ID')
            ->leftJoin('reports', 'controls.ID', '=', 'reports.ID')
            ->leftJoin('users as u_rec', 'reports.H03', '=', 'u_rec.username')
            ->leftJoin('users as u_insp', 'reports.H04', '=', 'u_insp.username')
            ->select(
                'controls.pk',
                'controls.NO',
                'controls.ID',
                'reports_status.isSend',
                'reports_status.isApprove',
                'reports_status.isWrong',
                'reports_status.messages',
                'u_rec.firstname as rec_fname',
                'u_rec.lastname as rec_lname',
                'u_insp.firstname as insp_fname',
                'u_insp.lastname as insp_lname'
            );

        // เพิ่ม Logic Filter: ค้นหา (ID หรือ NO)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('controls.ID', 'like', "%{$search}%")
                    ->orWhere('controls.NO', 'like', "%{$search}%");
            });
        }

        // เพิ่ม Logic Filter: สถานะ
        if ($request->filled('filter_status')) {
            $status = $request->filter_status;
            if ($status === 'not_saved') {
                $query->where(function ($q) {
                    $q->whereNull('reports_status.isSend')
                        ->orWhere('reports_status.isSend', '!=', '1');
                });
            } elseif ($status === 'saved') {
                $query->where('reports_status.isSend', '1')
                    ->where(function ($q) {
                        $q->whereNull('reports_status.isApprove')
                            ->orWhere('reports_status.isApprove', '0');
                    });
            } elseif ($status === 'approved') {
                $query->where('reports_status.isSend', '1')
                    ->where('reports_status.isApprove', '1');
            } elseif ($status === 'wrong') { // เพิ่มกรองเฉพาะที่มีปัญหา
                $query->where('reports_status.isWrong', '1');
            }
        }

        $items = $query
            ->orderByRaw("CASE WHEN reports_status.isWrong = '1' THEN 1 ELSE 0 END DESC")
            ->orderBy('controls.NO', 'asc')
            ->paginate(20);

        // โหลดรายชื่อจังหวัดจาก Config
        $provinces = config('provinces');

        // ส่งตัวเลือกสำหรับ Dropdown Filter ไปด้วย
        $filterOptions = [
            'all' => 'ทั้งหมด',
            'not_saved' => 'ยังไม่บันทึก',
            'saved' => 'บันทึกแล้ว (รออนุมัติ)',
            'approved' => 'อนุมัติแล้ว',
            'wrong' => 'ข้อมูลผิดปกติ (แจ้งเตือน)',
        ];

        return view('survey.dashboard', compact('items', 'total', 'notSaved', 'saved', 'approved', 'filterOptions', 'provinces'));
    }
}
