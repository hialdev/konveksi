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
        Schema::create('ulasan', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->uuid('pesanan_id')->nullable();
            $table->uuid('produk_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->uuid('pesanan_khusus_id')->nullable();

            $table->integer('rating');
            $table->text('keterangan')->nullable();
            $table->boolean('cek_pesanan_khusus')->nullable();
            
            $table->timestamps();

            $table->foreign('pesanan_id')
                ->references('id')
                ->on('pesanan')
                ->onDelete('cascade');

            $table->foreign('produk_id')
                ->references('id')
                ->on('produk')
                ->onDelete('cascade');
            
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
        Schema::dropIfExists('ulasan');
    }
};
