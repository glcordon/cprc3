<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.7.0)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 255)->default('first_name');
            $table->string('last_name', 255)->default('last_name');
            $table->string('address_1', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->integer('zip')->nullable()->default(55555);
            $table->string('email_address', 100)->nullable();
            $table->string('primary_phone', 25)->nullable();
            $table->string('secondary_phone', 25)->nullable();
            $table->integer('is_active')->nullable()->default(1);
            $table->nullableTimestamps();
            $table->softDeletes();
            $table->string('case_worker', 100)->nullable();
            $table->string('assigned_to', 10)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('address_2', 50)->nullable();
            $table->string('sex', 20)->nullable();
            $table->date('release_date')->nullable();
            $table->string('status', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('full_name', 200)->nullable();
            $table->string('citizenship', 100)->nullable();
            $table->string('form_of_id', 200)->nullable();
            $table->string('ncdps_id', 100)->nullable();
            $table->string('maritial_status', 20)->nullable();
            $table->string('race', 20)->nullable();
            $table->string('ethnicity', 20)->nullable();
            $table->string('education', 20)->nullable();
            $table->date('dob')->nullable();
            $table->string('supervisors_name', 100)->nullable();
            $table->string('supervisors_phone', 100)->nullable();
            $table->string('supervisors_email', 100)->nullable();
            $table->string('supervisors_end_date', 100)->nullable();
            $table->string('supervision_level', 20)->nullable();
            $table->string('sex_offender', 100)->nullable();
            $table->string('county_registered', 30)->nullable();
            $table->string('released_from', 100)->nullable();
            $table->string('under_supervision', 20)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('suffix', 12)->nullable();
            $table->string('charge', 50)->nullable();
            $table->string('risk_level', 30)->nullable();
            $table->integer('first_offence_age')->nullable();
            $table->integer('number_of_priors')->nullable();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
