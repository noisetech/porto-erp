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
        Schema::create('aset_kantor', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aset_kantor');
            $table->string('nama_aset_kantor');
            $table->foreignId('kategori_aset_kantor_id');
            $table->enum('status_kondisi_barang', ['rusak', 'hilang', 'maintenance']);
            $table->enum('status_ketersediaan', ['tersedia', 'di pinjam']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_aset_kantor_id')
                ->references('id')
                ->on('kategori_aset_kantor')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_kantor');
    }
};
