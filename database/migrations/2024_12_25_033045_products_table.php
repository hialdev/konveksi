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
        Schema::create('produk', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->unsignedBigInteger('produk_kategori_id');
            $table->text('image')->nullable();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('keterangan')->nullable();
            $table->integer('harga')->default(0);
            $table->timestamps();

            $table->foreign('produk_kategori_id')
                ->references('id')
                ->on('produk_kategori')
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
        Schema::dropIfExists('produk');
    }
};
