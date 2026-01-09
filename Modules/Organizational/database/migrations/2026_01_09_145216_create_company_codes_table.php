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
Schema::create('company_codes', function (Blueprint $table) {
    $table->id();
    $table->string('code', 6)->unique(); // CCD001
    $table->string('name');

    $table->timestamps();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->softDeletes();
    $table->boolean('is_active')->default(true);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_codes');
    }
};
