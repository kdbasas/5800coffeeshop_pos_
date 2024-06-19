<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id('employee_id');
            $table->string('employee_image')->nullable();
            $table->string('first_name', 55);
            $table->string('middle_name', 55)->nullable();
            $table->string('last_name', 55);
            $table->string('suffix_name', 55)->default('');
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('gender_id');
            $table->string('role')->default('employee'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}