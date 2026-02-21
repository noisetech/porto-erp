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
        Schema::create('log_coa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coa_id');
            $table->foreignId('user_id');
            $table->text('keterangan');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('coa_id')
                ->references('id')
                ->on('coa')
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
        Schema::dropIfExists('log_coa');
    }
};
