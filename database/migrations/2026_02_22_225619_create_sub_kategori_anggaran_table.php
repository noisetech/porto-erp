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
        Schema::create('sub_kategori_anggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_anggaran_id');
            $table->string('kode_sub_kategori');
            $table->string('nama_sub_kategori');
            $table->text('keterangan');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_anggaran_id')
                ->references('id')
                ->on('kategori_anggaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_anggaran');
    }
};
