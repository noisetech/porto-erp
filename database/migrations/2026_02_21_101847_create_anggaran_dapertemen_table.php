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
        Schema::create('anggaran_dapertemen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dapertemen_id');
            $table->enum('status_anggaran', ['pending', 'menggun persetjuan']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapertemen_id')
                ->references('id')
                ->on('dapertemen')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggaran_dapertemen');
    }
};
