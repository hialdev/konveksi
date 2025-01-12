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
        Schema::create('pesanan_khusus', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->string('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->uuid('bahan_baku_id')->nullable();
            $table->uuid('produk_id')->nullable();

            $table->boolean('cek_bahan_dari_pelanggan')->default(0);
            $table->text('lampiran_bahan')->nullable(); // Lampiran Bahan Baku
            $table->string('nama_bahan')->nullable(); // Nama Bahan baku
            $table->text('keterangan_bahan')->nullable(); // Penjelasan Bahan Baku
            
            $table->text('lampiran')->nullable();
            $table->text('keterangan'); // Penjelasan Pesanan Khususnya
            $table->date('deadline');
            $table->integer('qty')->default(0);
            $table->bigInteger('total_harga')->nullable();
            $table->enum('status', [0, 1, 2, 3, 4, 5])->default(0); //0 : Waiting Price, 1: Harga ditetapkan, 2: Nego, 3: Reject, 4: Approve, 5: Selesai
            $table->enum('status_pembayaran', [0, 1, 2])->default(0); //0 : menunggu, 1: sedang dibayar, 2: lunas
            $table->text('keterangan_konveksi')->nullable(); // Description dari konveksi saat action
            $table->text('keterangan_pelanggan')->nullable(); // Description dari customer saat action

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

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan_khusus');
    }
};
