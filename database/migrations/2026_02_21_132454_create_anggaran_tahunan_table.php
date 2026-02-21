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
        Schema::create('anggaran_tahunan', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_anggaran');
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])->default('draft');
            $table->foreignId('disetujui_oleh_id');
            $table->timestamp('disetujui_pada')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('disetujui_oleh_id')
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
        Schema::dropIfExists('anggaran_tahunan');
    }
};
