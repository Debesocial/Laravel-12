<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // Konten utama
            $table->string('title');
            $table->text('message');

            // Target penerima
            $table->enum('recipient', ['all', 'admin', 'user']);

            // Jenis notifikasi
            $table->enum('type', ['info', 'warning', 'system'])->default('info');

            // Status baca
            $table->timestamp('read_at')->nullable();

            // Pembuat notifikasi
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};