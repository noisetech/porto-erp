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
        Schema::create('master_periode_anggaran', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->enum('status', ['draf', 'aktif', 'ditutup'])->default('draf');
            $table->date('tanggal_mulai')->nullable(); // biasa nya 1 januari
            $table->date('tanggal_selesai')->nullable(); // biasa nya 31 januari

            // approval
            $table->time('tanggal_aktif')->nullable();
            $table->foreignId('diaktifkan_oleh_id');
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('diaktifkan_oleh_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_periode_anggaran');
    }
};
