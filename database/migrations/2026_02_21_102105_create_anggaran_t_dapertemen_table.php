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
        Schema::create('anggaran_t_dapertemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_dapertemen_id');
            $table->foreignId('kategori_anggaran_id');
            $table->foreignId('sub_kategori_anggran_id');
            $table->string('tahub');
            $table->integer('anggaran');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('anggaran_dapertemen_id')
                ->references('id')
                ->on('anggaran_dapertemen')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('kategori_anggaran_id')
                ->references('id')
                ->on('kategori_anggaran')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('sub_kategori_anggran_id')
                ->references('id')
                ->on('sub_kategori_anggran')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_t_dapertemen');
    }
};
