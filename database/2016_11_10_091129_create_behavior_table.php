<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBehaviorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behaviors', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('client_ip')->default(0);
            $table->text('model');
            $table->string('url');
            $table->string('method',15);
            $table->string('agent',50);
            $table->unsignedInteger('user_id')->default(0);
            $table->string('user_type',40);

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
        Schema::dropIfExists('behaviors');
    }
}
