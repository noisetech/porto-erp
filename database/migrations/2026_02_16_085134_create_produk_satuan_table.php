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
        Schema::create('produk_satuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_id');
            $table->foreignId('satuan_produk_id')->nullable();
            $table->string('kode')->nullable();
            $table->string('nama');
            $table->integer('harga');
            $table->string('no_bpom')->nullable();
            $table->string('sku');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_produk_id')
                ->references('id')
                ->on('kategori_produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('satuan_produk_id')
                ->references('id')
                ->on('satuan_produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_satuan');
    }
};
