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
        Schema::create('kelompok_akun_coa', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelompok')->unique();
            $table->string('nama_kelompok');
            $table->text('keterangan')->nullable();
            $table->foreignId('akun_induk_id')
                ->nullable()
                ->constrained(
                    'kelompok_akun_coa'
                )->nullOnDelete()->cascadeOnUpdate();
            $table->boolean('aktif')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_akun_coa');
    }
};
