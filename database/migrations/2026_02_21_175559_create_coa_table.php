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
        Schema::create('coa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_akun')->unique();
            $table->string('nama_akun');
            $table->enum('jenis_akun', ['aset', 'kewajiban', 'modal', 'pendapatan', 'beban']);
            $table->unsignedBigInteger('kelompok_akun_coa_id')->nullable();
            $table->unsignedBigInteger('akun_induk_id')->nullable();
            $table->boolean('boleh_posting')->default(true);
            $table->boolean('aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kelompok_akun_coa_id')
                ->references('id')
                ->on('kelompok_akun_coa')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('akun_induk_id')
                ->references('id')
                ->on('coa')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa');
    }
};
