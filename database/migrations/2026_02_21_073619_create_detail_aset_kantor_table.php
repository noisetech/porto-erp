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
        Schema::create('detail_aset_kantor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_kantor_id');
            $table->longText('spesifikasi')->nullable();
            $table->integer('harga_beli');
            $table->text('vendor_lainya');
            $table->foreignId('vendor_aset_kantor_id')->nullable();
            $table->date('tanggal_pembelian');
            $table->timestamps();

            $table->foreign('aset_kantor_id')
                ->references('id')
                ->on('aset_kantor')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('vendor_aset_kantor_id')
                ->references('id')
                ->on('vendor_aset_kantor')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_aset_kantor');
    }
};
