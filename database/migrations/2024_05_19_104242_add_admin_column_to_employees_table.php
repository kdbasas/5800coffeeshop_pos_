<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminColumnToEmployeesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('employees', 'admin')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->boolean('admin')->default(false)->after('email');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('employees', 'admin')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('admin');
            });
        }
    }
}

