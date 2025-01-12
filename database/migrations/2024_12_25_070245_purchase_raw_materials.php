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
        Schema::create('pembelian_bahan_baku', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(Str::uuid());
            $table->uuid('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->uuid('bahan_baku_id');

            $table->string('code')->unique();
            $table->date('tgl_pembelian')->default(now());
            $table->text('keterangan')->nullable();
            $table->text('file_bukti')->nullable();
            $table->integer('total_harga_beli')->default(0);

            $table->timestamps();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('bahan_baku_id')
                ->references('id')
                ->on('bahan_baku')
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
        Schema::dropIfExists('purchase_raw_materials');
    }
};
