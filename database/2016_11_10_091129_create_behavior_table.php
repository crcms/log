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
        Schema::create('behavior_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedBigInteger('client_ip')->default(0);
            $table->mediumText('model');
            $table->string('url',1024)->default('');
            $table->string('method',15)->default('');
            $table->string('agent',512)->default('');
            $table->string('remark',255)->default('');
            $table->unsignedInteger('user_id')->default(0);
            $table->string('user_type',50)->default('');
            $table->string('type',100)->default('');
            $table->unsignedInteger('type_id')->default(0);
            //$table->timestamp('log_time')->nullable();
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
        Schema::dropIfExists('behavior_logs');
    }
}
