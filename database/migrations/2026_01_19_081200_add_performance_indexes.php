<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('controls', function (Blueprint $table) {
            $table->index(['CWT', 'NO'], 'controls_cwt_no_index');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->index(['CWT', 'NO'], 'reports_cwt_no_index');
        });

        Schema::table('reports_status', function (Blueprint $table) {
            $table->index(['isSend', 'isApprove', 'isWrong', 'ID'], 'reports_status_flags_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('reports_status', function (Blueprint $table) {
            $table->dropIndex('reports_status_flags_id_index');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropIndex('reports_cwt_no_index');
        });

        Schema::table('controls', function (Blueprint $table) {
            $table->dropIndex('controls_cwt_no_index');
        });
    }
};
