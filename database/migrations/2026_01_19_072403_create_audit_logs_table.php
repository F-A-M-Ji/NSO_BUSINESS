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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('username', 50)->nullable()->index();
            $table->string('method', 10);
            $table->string('path', 2048);
            $table->string('route_name', 191)->nullable()->index();
            $table->string('route_action', 191)->nullable();
            $table->unsignedSmallInteger('status_code');
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->unsignedInteger('duration_ms')->nullable();
            $table->text('request_data')->nullable();
            $table->text('route_params')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
