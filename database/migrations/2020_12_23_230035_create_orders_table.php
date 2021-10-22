<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(0);
            $table->string('recipient_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('shipping_address')->nullable();
            $table->integer('shipping_price')->nullable();
            $table->string('order_code')->nullable();
            $table->string('track_code')->default(0);
            $table->string('courier_name')->nullable();
            $table->string('unique_code');
            $table->integer('total_price');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
