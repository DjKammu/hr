<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id')->reuired();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

             $table->unsignedBigInteger('employee_id')->reuired();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaves');
    }
}
