<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Validation\Rule; // อย่าลืม use Rule

class UserController extends Controller
{
    public function create()
    {
        // return view('users.create', [
        //     'roles' => UserRole::cases(),
        //     'provinces' => config('provinces')
        // ]);

        $roles = collect(UserRole::cases())
            ->mapWithKeys(fn($role) => [$role->value => $role->label()])
            ->all();

        return view('users.create', [
            'roles' => $roles, // ส่งตัวแปรนี้ไปที่ View
            'provinces' => config('provinces') // (สมมติว่าคุณโหลดจังหวัดแบบนี้)
        ]);
    }

    // ✅ ฟังก์ชันบันทึกข้อมูล
    public function store(Request $request)
    {
        // 1. ตรวจสอบข้อมูล (Validation)
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:7', 'unique:users,username'], // ห้ามซ้ำ
            'password' => ['required', 'string', 'min:7'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'province_code' => ['required', 'string', 'size:2'], // ต้อง 2 หลักเป๊ะๆ
            'role' => ['required', Rule::enum(UserRole::class)], // ต้องตรงกับ Enum
        ], [
            // ข้อความแจ้งเตือนภาษาไทย (Custom Error Messages)
            'username.unique' => 'รหัสพนักงานนี้มีอยู่ในระบบแล้ว',
            'username.max' => 'รหัสพนักงานต้องไม่เกิน 7 ตัวอักษร',
            'province_code.size' => 'รหัสจังหวัดต้องมี 2 หลัก',
            'role.required' => 'กรุณาระบุสิทธิ์การใช้งาน',
        ]);

        // 2. บันทึกข้อมูล (Password จะถูก Hash อัตโนมัติจาก Model)
        User::create($validated);

        // 3. ส่งกลับหน้าเดิมพร้อมข้อความ Success
        return redirect()
            ->route('users.create')
            ->with('success', 'บันทึกข้อมูลผู้ใช้งานเรียบร้อยแล้ว');
    }
}
