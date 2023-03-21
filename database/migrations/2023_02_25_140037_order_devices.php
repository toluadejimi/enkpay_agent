<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname', 200);
            $table->string('address', 200);
            $table->string('state', 200);
            $table->string('lga', 200);
            $table->string('phone_no', 200);
            $table->string('user_id', 200);
            $table->string('order_id', 200);
            $table->string('status', 1);
            $table->string('order_amount');
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('links');
    }
};
