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
        Schema::create('produk_satuan_di_produk_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_paket_id');
            $table->foreignId('produk_satuan_id');
            $table->integer('qty');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('produk_paket_id')
                ->references('id')
                ->on('produk_paket')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('produk_satuan_id')
                ->references('id')
                ->on('produk_satuan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_satuan_di_produk_paket');
    }
};
