<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddressBuyerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_address_buyer', function (Blueprint $table) {
            $table->id();
            $table->string('phone',12)->unique();
            $table->string('address', 100)->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('cascade');
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
        Schema::dropIfExists('order_address_buyer');
    }
}
