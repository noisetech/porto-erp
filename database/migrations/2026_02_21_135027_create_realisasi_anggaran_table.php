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
        Schema::create('realisasi_anggaran', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('anggaran_departemen_id');
            $table->foreignId('sub_kategori_anggaran_id');
            // Nilai realisasi
            $table->decimal('nilai', 15, 2);

            // Info pendukung
            $table->string('vendor')->nullable();
            $table->string('nomor_dokumen')->nullable(); // invoice / nota
            $table->text('keterangan')->nullable();


            // Status approval
            $table->enum('status', [
                'draft',
                'diajukan',
                'disetujui',
                'ditolak'
            ])->default('draft');

            $table->foreignId('diajukan_oleh');
            $table->foreignId('disetujui_oleh')->nullable();
            $table->timestamp('disetujui_pada')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('anggaran_departemen_id')
                ->references('id')
                ->on('anggaran_dapertemen')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sub_kategori_anggaran_id')
                ->references('id')
                ->on('sub_kategori_anggaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('diajukan_oleh')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('disetujui_oleh')
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
        Schema::dropIfExists('realisasi_anggaran');
    }
};
