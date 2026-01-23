<?php

namespace App\Models;

use App\Enums\UserRole;

use App\Casts\MySecretEncrypt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * ฟิลด์ที่อนุญาตให้เพิ่มข้อมูลได้ (Mass Assignment)
     */
    protected $fillable = [
        'username',
        'password',
        'firstname',
        'lastname',
        'province_code',
        'role',
    ];

    /**
     * ฟิลด์ที่จะไม่แสดงเวลาดึงข้อมูล (ซ่อนรหัสผ่าน)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * การแปลงค่าข้อมูล (Casts)
     * สำคัญ: 'hashed' จะทำให้ Laravel เข้ารหัส password อัตโนมัติด้วย Bcrypt ตอนบันทึก
     */
    protected $casts = [
        'password' => 'hashed', 
        'role' => UserRole::class,
    ];
}