<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation: ตรวจสอบข้อมูลเบื้องต้น
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Authentication: ตรวจสอบกับฐานข้อมูล (SQL Server)
        // Auth::attempt จะจัดการเรื่อง Hash และ SQL Injection ให้ปลอดภัย 100%
        if (Auth::attempt($credentials, $request->filled('remember'))) {

            // 3. Security: สร้าง Session ID ใหม่ทันทีเมื่อล็อกอินสำเร็จ
            // เพื่อป้องกัน Session Fixation Attack
            $request->session()->regenerate();

            // ล็อกอินผ่าน: ส่งไปหน้า Survey (หรือหน้า Dashboard ตามต้องการ)
            return redirect()->intended('/');
        }

        // 4. ล็อกอินไม่ผ่าน: ดีดกลับไปหน้าเดิม พร้อมส่ง Error (แต่ไม่มี Alert เด้งแล้ว ตามที่ขอ)
        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // ล้างข้อมูล Session ทั้งหมดเพื่อความปลอดภัย
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
