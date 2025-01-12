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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->unsignedBigInteger('user_id');

            $table->string('code')->unique();
            $table->enum('status', [0,1,2,3,4,5])->default(0); // 0 Waiting, 1 Dibayar, 2 Diproses, 3 Tidak Valid, 4 Selesai, 5 Pengembalian
            $table->json('produk'); //[{'product_id', 'qty'}]
            $table->text('bukti_pembayaran')->nullable(); // Bukti Pembayaran
            $table->integer('total_harga')->default(0);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('pesanan');
    }
};
