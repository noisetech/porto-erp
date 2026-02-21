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
        Schema::create('peminjaman_aset_kantor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_kantor_id');
            $table->foreignId('user_id');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status_peminjaman', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->longText('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('aset_kantor_id')
                ->references('id')
                ->on('aset_kantor')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
        Schema::dropIfExists('peminjaman_aset_kantor');
    }
};
