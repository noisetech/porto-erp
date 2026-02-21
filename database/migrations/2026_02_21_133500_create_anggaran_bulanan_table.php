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
        Schema::create('anggaran_bulanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggaran_dapertemen_id');
            $table->integer('bulan');
            $table->decimal('jumlah_anggaran', 15, 2);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('anggaran_dapertemen_id')
            ->references('id')
            ->on('anggaran_dapertemen')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_bulanan');
    }
};
