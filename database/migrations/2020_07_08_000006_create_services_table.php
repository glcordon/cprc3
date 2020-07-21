<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name');
            $table->string('service_code')->nullable();
            $table->boolean('is_billable')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
