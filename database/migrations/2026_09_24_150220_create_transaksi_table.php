<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('kategori_id');

            $table->date('tanggal');
            $table->text('keterangan');
            $table->decimal('jumlah', 15, 2);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('kategori_id')
                ->references('id')
                ->on('kategori_transaksi')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};