<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name');
            $table->string('vendor_phone');
            $table->string('vendor_email')->nullable();
            $table->string('vendor_address_1')->nullable();
            $table->string('vendor_address_2')->nullable();
            $table->string('vendor_city')->nullable();
            $table->string('vendor_state')->nullable();
            $table->string('vendor_zip')->nullable();
            $table->string('is_active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
