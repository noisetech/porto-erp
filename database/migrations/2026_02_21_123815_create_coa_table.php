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
            $table->string('kode_akun');
            $table->string('nama_akun');
            $table->string('slug')->nullable();
            $table->enum('jenis_akun', ['aset', 'kewajiban', 'modal', 'pendapatan', 'beban']);
            $table->string('kelompok_akun')->nullable();
            $table->foreignId('akun_induk_id')->nullable()->constrained('coa')->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('boleh_posting')->default(true);
            $table->boolean('aktif')->default(true);
            $table->text('keterangan')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
