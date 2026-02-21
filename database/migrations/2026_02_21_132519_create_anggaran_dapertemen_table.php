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
        Schema::create('anggaran_dapertemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_tahunan_id');
            $table->foreignId('dapertemen_id');
            $table->foreignId('sub_kategori_anggaran_id');
            $table->decimal('total_anggaran', 15, 2);
            $table->enum('status', ['draf', 'diajukan', 'disetujui', 'ditolak'])->default('draf');
            $table->foreignId('disetujui_oleh_id')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->text('catatan')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('anggaran_tahunan_id')
                ->references('id')
                ->on('anggaran_tahunan')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('dapertemen_id')
                ->references('id')
                ->on('dapertemen')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sub_kategori_anggaran_id')
                ->references('id')
                ->on('sub_kategori_anggaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_dapertemen');
    }
};
