<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OsanoMigration extends Migration
{
    public function connection()
    {
        return "osano"; // Menggunakan koneksi 'osano'
    }

    public function up()
    {
        Schema::connection($this->connection())->create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('npwp');
            $table->text('description')->nullable();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->timestamps();
        });

        Schema::connection($this->connection())->create('client_address', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('client_id');
            $table->string('address_tag');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });

        Schema::connection($this->connection())->create('principles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->text('description')->nullable();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->timestamps();
        });

        Schema::connection($this->connection())->create('principle_address', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('principle_id');
            $table->string('address_tag');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('telp')->nullable();
            $table->string('fax')->nullable();
            $table->timestamps();

            $table->foreign('principle_id')->references('id')->on('principles')->onDelete('cascade');
        });

        Schema::connection($this->connection())->create('logistics', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->text('description')->nullable();
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->timestamps();
        });

        Schema::connection($this->connection())->create('satuan_barang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->timestamps();
        });
        
        Schema::connection($this->connection())->create('satuan_packaging', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('capacity');
            $table->uuid('id_satuan_barang'); // id_satuan_barang
            $table->timestamps();
        
            $table->foreign('id_satuan_barang')->references('id')->on('satuan_barang')->onDelete('cascade');
        });
        
        Schema::connection($this->connection())->create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description');
            $table->uuid('id_satuan_barang'); // id_satuan_barang
            $table->timestamps();
        
            // Relasi ke satuan_barang
            $table->foreign('id_satuan_barang')->references('id')->on('satuan_barang')->onDelete('cascade');
        
        });
        
    }

    public function down()
    {
        Schema::connection($this->connection())->dropIfExists('products');
        Schema::connection($this->connection())->dropIfExists('satuan_packaging');
        Schema::connection($this->connection())->dropIfExists('satuan_barang');
        Schema::connection($this->connection())->dropIfExists('logistics');
        Schema::connection($this->connection())->dropIfExists('principle_address');
        Schema::connection($this->connection())->dropIfExists('principles');
        Schema::connection($this->connection())->dropIfExists('client_address');
        Schema::connection($this->connection())->dropIfExists('clients');
    }
}
