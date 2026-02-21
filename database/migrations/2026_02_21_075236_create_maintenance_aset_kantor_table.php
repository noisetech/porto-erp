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
        Schema::create('maintenance_aset_kantor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aset_kantor_id');
            $table->date('tanggal_maintenance');
            $table->text('keterangan');
            $table->integer('biaya_maintenance')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('aset_kantor_id')
                ->references('id')
                ->on('aset_kantor')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_aset_kantor');
    }
};
