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
        Schema::create('karirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained();
            $table->string('email');
            $table->string('slug')->unique();
            $table->string('profesi',50);
            $table->string('bidang')->nullable();
            $table->enum('jenis_karir', ['Bekerja', 'Wiraswasta', 'Belum ada', 'Lanjut studi']);
            $table->text('nama_tempat')->nullable();
            $table->string('foto_tempat')->nullable();
            $table->text('alamat_karir');
            $table->char('no_telp', 20);
            $table->text('pendapatan');
            $table->text('tempat_tinggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karirs');
    }
};
