<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_employee', function (Blueprint $table) {
             $table->date('date_of_joining')->nullable();
             $table->date('termination_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_employee', function (Blueprint $table) {
           $table->dropColumn('date_of_joining');
           $table->dropColumn('termination_date');
        });
    }
}
