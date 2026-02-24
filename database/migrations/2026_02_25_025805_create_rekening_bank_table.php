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
        Schema::create('rekening_bank', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_master_id');
            $table->foreignId('coa_id');
            $table->string('nama_rekening');
            $table->string('nomor_rekening');
            $table->string('nama_pemilik');
            $table->string('mata_uang')->nullable()->default('IDR');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('bank_master_id')
                ->references('id')
                ->on('bank_master')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('coa_id')
                ->references('id')
                ->on('coa')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekening_bank');
    }
};
