<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            // 1. id เป็น Primary Key (Laravel จัดการให้เป็น BigInt Auto Increment)
            $table->id();

            // 2. username ตัวอักษรไม่เกิน 7 หลัก และห้ามซ้ำ
            $table->string('username', 7)->unique();

            // 3. password (เก็บเป็น string ยาวๆ เพื่อรองรับ Hash)
            $table->string('password');

            // 4. ชื่อ-นามสกุล
            $table->string('firstname');
            $table->string('lastname');

            // 5. รหัสจังหวัด 2 หลัก (ใช้ char เพราะความยาวคงที่)
            $table->char('province_code', 2);

            // 6. Role (ใช้ enum เพื่อบังคับค่า หรือ string ก็ได้)
            // หมายเหตุ: SQL Server จะเก็บเป็น Varchar ปกติ แต่เรากำหนดไว้เพื่อสื่อความหมาย
            $table->string('role')->default('INTERVIEWER');
            // หรือถ้าอยากบังคับระดับ Database (อาจมีปัญหากับ SQL Server เก่าๆ บางตัว) ใช้:
            // $table->enum('role', ['ADMIN', 'INTERVIEWER', 'SUPERVISOR', 'SUBJECT']);

            $table->rememberToken(); // สำหรับระบบ Login "Remember Me"
            $table->timestamps();    // สร้าง created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
