<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWowmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wowmenu', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('acknowledge');
            $table->string('permission');
            $table->string('label_text');
            $table->string('menuname_text');
            $table->unsignedInteger('menulevel_radio');//メニュー階層
            $table->unsignedInteger('parentmenuid_select');//親階層のID
            $table->string('iconclass_text');//icon
            $table->unsignedInteger('queue');
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
        Schema::dropIfExists('wowmenu');
    }
}
