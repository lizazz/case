<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('word_id');
            $table->enum('case_id',[0, 1, 2, 3, 4, 5]);
            $table->string('case', 255);
            $table->timestamps();

            $table->foreign('word_id')->references('id')->on('words')
                ->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->index('case');
            $table->index('case_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cases');
    }
}
