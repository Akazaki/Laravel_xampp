<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('acknowledge');
            $table->string('permission');
            $table->string('label_text');
            $table->string('detail_richtext');
            $table->string('main_file');
            $table->unsignedInteger('menulevel_radio');//メニュー階層
            $table->unsignedInteger('parentmenuid_check');//親階層のID
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
        Schema::dropIfExists('posts');
    }
}
