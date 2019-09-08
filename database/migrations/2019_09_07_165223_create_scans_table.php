<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('card_number');
            $table->boolean('committee_member')->nullable();
            $table->string('department')->nullable();
            $table->string('study_type')->nullable();
            $table->string('programme_year')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->dateTime('scanned_at');
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
        Schema::dropIfExists('scans');
    }
}
