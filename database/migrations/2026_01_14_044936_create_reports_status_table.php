<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports_status', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id('pk');
            $table->string('ID', 15)->unique();
            $table->string('REG', 1)->nullable();
            $table->string('CWT', 2)->nullable();
            $table->string('NO', 5)->nullable();
            $table->string('YR', 2)->nullable();
            $table->string('isSend', 1)->nullable()->default('0')->comment('สถานะส่งงาน (0=ยังไม่ส่ง, 1=ส่งแล้ว)');
            $table->string('isApprove', 1)->nullable()->default('0')->comment('สถานะอนุมัติ (0=รอตรวจ, 1=อนุมัติแล้ว)');
            $table->timestamp('send_time')->nullable();
            $table->timestamp('approve_time')->nullable();
            $table->string('isWrong', 1)->nullable()->default('0')->comment('สถานะความถูกต้อง (0=ถูกต้อง, 1=ไม่ถูกต้อง)');
            $table->string('messages')->nullable();
            // Timestamps (created_at, updated_at)
            // $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports_status');
    }
};
