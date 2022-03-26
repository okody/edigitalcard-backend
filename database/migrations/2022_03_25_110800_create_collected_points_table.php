<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectedPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collected_points', function (Blueprint $table) {
            $table->id();
            $table->string("action")->nullable();
            $table->double("points");
            $table->string("service")->nullable();
            $table->dateTime("collectionDate");
            $table->foreignId('student_id')->constrained();
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
        Schema::dropIfExists('collected_points');
    }
}
