<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogisticAddress extends Migration
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
        Schema::connection($this->connection())->create('logistic_address', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('logistic_id');
            $table->string('address_tag');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();
            $table->timestamps();

            $table->foreign('logistic_id')->references('id')->on('logistics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection())->dropIfExists('logistic_address');
    }
}
