<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_produksi', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->unsignedBigInteger('user_id');
            $table->uuid('bahan_baku_id');
            $table->uuid('produk_id');

            $table->string('code')->unique();
            $table->text('keterangan')->nullable();
            $table->integer('qty')->default(0);
            $table->date('deadline');
            $table->text('lampiran');
            $table->enum('status', [0, 1, 2]);
            $table->boolean('cek_pesanan_khusus')->default(0);
            $table->uuid('pesanan_khusus_id')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('bahan_baku_id')
                ->references('id')
                ->on('bahan_baku')
                ->onDelete('cascade');

            $table->foreign('produk_id')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade');

            $table->foreign('pesanan_khusus_id')
                ->references('id')
                ->on('pesanan_khusus')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_produksi');
    }
};
