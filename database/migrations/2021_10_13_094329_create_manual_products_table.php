<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manual_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('manual_users')->onDelete('cascade');
            $table->string('title',150);
            $table->string('descri');
            $table->float('price');
            $table->unsignedInteger('count');
            $table->float('discount')->nullable();
            $table->unsignedInteger('total');
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
        Schema::dropIfExists('manual_products');
    }
}
