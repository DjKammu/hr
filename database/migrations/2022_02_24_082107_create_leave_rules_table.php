<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_rules', function (Blueprint $table) {
            $table->id();
             $table->string('name')->reuired();
            $table->unsignedBigInteger('company_id')->reuired();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');

            $table->integer('accrues_every_quarter')->nullable();
            $table->integer('accrues_every_year')->nullable();
            $table->tinyInteger('carry_over_year')->nullable();
            $table->integer('max_period')->nullable();
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
        Schema::dropIfExists('leave_rules');
    }
}
