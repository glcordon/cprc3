<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Jobs', function (Blueprint $table) {
            
            $table->string('job_name', 100)->nullable();
            $table->string('job_address', 300)->nullable();
            $table->string('job_city', 300)->nullable();
            $table->string('job_zip', 300)->nullable();
            $table->bigInteger('client_id')->nullable();
            $table->string('salary', 30)->nullable();
            
            $table->date('start_date')->nullable();
            
            $table->string('job_phone', 20)->nullable()->default('text');
            
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
       Schema::drop('Jobs');
       
    }
}
