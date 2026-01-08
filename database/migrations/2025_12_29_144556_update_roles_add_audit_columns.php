<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {

            // created_by (audit)
            if (!Schema::hasColumn('roles', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('created_at');
            }

            // updated_by (audit)
            if (!Schema::hasColumn('roles', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('updated_at');
            }

            // is_active (status flag)
            if (!Schema::hasColumn('roles', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('updated_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {

            if (Schema::hasColumn('roles', 'created_by')) {
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('roles', 'updated_by')) {
                $table->dropColumn('updated_by');
            }

            if (Schema::hasColumn('roles', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};