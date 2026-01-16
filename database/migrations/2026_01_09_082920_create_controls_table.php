<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('controls', function (Blueprint $table) {
            // pk เป็น Primary Key
            $table->id('pk');

            // รหัสต่างๆ (ใช้ String เพื่อเก็บเลข 0 นำหน้าได้ เช่น '01')
            $table->string('NO', 5);

            // ID 15 หลัก (ห้ามซ้ำ)
            $table->string('ID', 15)->unique();

            // ที่ตั้งภูมิศาสตร์ (Geography)
            $table->string('REG', 1);
            $table->string('CWT', 2);
            $table->string('PROVINCE');
            $table->string('AMP', 2);
            $table->string('DISTRICT');
            $table->string('TAM', 2);
            $table->string('SUB_DIST');
            $table->string('MUN', 1);
            $table->string('VIL', 2);
            $table->string('EA', 4);

            $table->string('YR', 2);

            // ที่อยู่ (Address)
            $table->string('STREET')->nullable();
            $table->string('SOI')->nullable();
            $table->string('BUILDING')->nullable();
            $table->string('ADD_NO')->nullable();

            // ข้อมูลสถานประกอบการ
            $table->string('ECON_ACT')->nullable();
            $table->string('TYPE')->nullable();
            $table->string('INVEST')->nullable();

            // การติดต่อ
            $table->string('E_MAIL')->nullable();
            $table->string('TEL_NO')->nullable();
            $table->string('FAX_NO')->nullable();
            $table->string('WEB_SITE')->nullable();

            // รหัสมาตรฐาน
            $table->string('TSIC_CODE', 5);
            $table->string('SIZE12', 2);

            // ชื่อบุคคล / ชื่อสถานประกอบการ
            $table->string('TITLE')->nullable();
            $table->string('FIRSTNAME')->nullable();
            $table->string('LASTNAME')->nullable();
            $table->string('EST_NAME')->nullable();

            $table->string('ADD_NO_2')->nullable();
            $table->string('EST_TITLE_2')->nullable();
            $table->string('FIRSTNAME_2')->nullable();
            $table->string('LASTNAME_2')->nullable();
            $table->string('EST_NAME_2')->nullable();
            $table->string('STREET_2')->nullable();
            $table->string('BLK_2')->nullable();
            $table->string('BUILDING_2')->nullable();
            $table->string('SUB_DIST_2')->nullable();
            $table->string('DISTRICT_2')->nullable();
            $table->string('PROVINCE_2')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controls');
    }
};
