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
        Schema::table('master_periode_anggaran', function (Blueprint $table) {

            // drop FK dulu
            $table->dropForeign(['diaktifkan_oleh_id']);

            // ubah kolom jadi nullable
            $table->foreignId('diaktifkan_oleh_id')
                ->nullable()
                ->change();

            // pasang FK lagi
            $table->foreign('diaktifkan_oleh_id')
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
        Schema::table('master_periode_anggaran', function (Blueprint $table) {
            $table->dropForeign(['diaktifkan_oleh_id']);

            $table->foreignId('diaktifkan_oleh_id')
                ->nullable(false)
                ->change();

            $table->foreign('diaktifkan_oleh_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }
};
