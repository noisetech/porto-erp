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
        Schema::create('mapping_sub_kategori_coa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_kategori_anggaran_id');
            $table->foreignId('coa_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('sub_kategori_anggaran_id')
                ->references('id')
                ->on('sub_kategori_anggaran')
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
        Schema::dropIfExists('mapping_sub_kategori_coa');
    }
};
