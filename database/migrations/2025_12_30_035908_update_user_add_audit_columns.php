<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /**
         * Update table users
         * - created_by, updated_by, is_active
         */
        Schema::table('users', function (Blueprint $table) {

            // audit: siapa yang membuat user
            if (!Schema::hasColumn('users', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('created_at');
            }

            // audit: siapa yang terakhir mengubah user
            if (!Schema::hasColumn('users', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('updated_at');
            }

            // status aktif/nonaktif
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('updated_by');
            }
        });
    }

    public function down(): void
    {
        /**
         * Rollback table users
         */
        Schema::table('users', function (Blueprint $table) {

            // rollback created_by
            if (Schema::hasColumn('users', 'created_by')) {
                $table->dropColumn('created_by');
            }

            // rollback updated_by
            if (Schema::hasColumn('users', 'updated_by')) {
                $table->dropColumn('updated_by');
            }

            // rollback status
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};