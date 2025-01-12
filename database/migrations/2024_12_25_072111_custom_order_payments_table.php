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
        Schema::create('pembayaran_pesanan_khusus', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->uuid('pesanan_khusus_id');

            $table->text('bukti_pembayaran')->nullable(); // Bukti Pembayaran
            $table->integer('total_dibayar')->default(0);
            $table->enum('status', [0,1,2])->default(0); // 0: Waiting, 1: Reject, 2: Valid
            $table->timestamps();

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
        Schema::dropIfExists('pembayaran_pesanan_khusus');
    }
};
