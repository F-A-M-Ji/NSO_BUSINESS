<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case INTERVIEWER = 'INTERVIEWER';
    case SUPERVISOR = 'SUPERVISOR';
    case SUBJECT = 'SUBJECT';

    // (Optional) ฟังก์ชันสำหรับดึงชื่อมาแสดงผลสวยๆ (ถ้าต้องใช้)
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'ผู้ดูแลระบบ',
            self::INTERVIEWER => 'เจ้าหน้าที่บันทึกข้อมูล',
            self::SUPERVISOR => 'ผู้ตรวจ',
            self::SUBJECT => 'เจ้าของโครงการ',
        };
    }
}
