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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama_lengkap');
            $table->string('no_telepon');
            $table->string('email_pribadi');
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->foreignId('dapertemen_id');
            $table->foreignId('jabatan_id');
            $table->foreignId('user_id');
            $table->longText('alamat')->nullable();
            $table->string('no_bank')->nullable();
            $table->string('bank')->nullable();
            $table->enum('status_karyawan', ['tetap', 'tidak tetap']);
            $table->enum('status', ['aktif', 'tidak akif']);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dapertemen_id')
                ->references('id')
                ->on('dapertemen')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('jabatan_id')
                ->references('id')
                ->on('jabatan')
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
        Schema::dropIfExists('karyawan');
    }
};
