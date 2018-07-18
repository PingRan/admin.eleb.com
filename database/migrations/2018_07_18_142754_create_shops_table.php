<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_category_id');
            $table->string('shop_name');
            $table->string('shop_img');
            $table->float('shop_rating',3,1);
            $table->boolean('brand');
            $table->boolean('on_time');
            $table->boolean('fengniao');
            $table->boolean('bao');
            $table->boolean('piao');
            $table->boolean('zhun');
            $table->decimal('start_send',4,2);
            $table->decimal('send_cost',4,2);
            $table->string('notice');
            $table->string('discount');
            $table->tinyInteger('status');
            $table->timestamps();
            $table->engine='InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
