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
            $table->string('kode_sub_kategori'); // UTIL, ATK, SEWA
            $table->string('nama_sub_kategori'); //Utilitas, ATK, Sewa Kantor
            $table->foreignId('coa_id');
            $table->string('slug')->nullable();
            $table->boolean('aktif')->default(true);
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kategori_anggaran_id')
                ->references('id')
                ->on('kategori_anggaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreign('coa_id')
                ->references('id')
                ->on('coa')
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
