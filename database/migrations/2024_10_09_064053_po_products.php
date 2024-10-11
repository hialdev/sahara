<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PoProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function connection()
    {
        return "osano"; // Menggunakan koneksi 'osano'
    }

    public function up()
    {
        Schema::connection($this->connection())->create('purchase_order_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_id');
            $table->uuid('product_id');
            $table->uuid('packaging_id');
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('packaging_id')->references('id')->on('satuan_packaging')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection())->dropIfExists('purchase_order_products');
    }
}
