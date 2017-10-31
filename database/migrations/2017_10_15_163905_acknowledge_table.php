<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AcknowledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acknowledge', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('acknowledge');
            $table->unsignedInteger('user_select');
            $table->unsignedInteger('permission');
            $table->string('label_text');
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
        Schema::dropIfExists('acknowledge');
    }
}
