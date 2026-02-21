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
        Schema::create('gambar_produk_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_paket_id');
            $table->string('pull_path');
            $table->string('nama_file');
            $table->string('jenis_file');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('produk_paket_id')
                ->references('id')
                ->on('produk_paket')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_produk_paket');
    }
};
