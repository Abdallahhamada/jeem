<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->string('title', 150);
            $table->string('subtitle');
            $table->text('descri');
            $table->float('price');
            $table->float('discount')->nullable();
            $table->UnsignedInteger('count');
            $table->UnsignedInteger('total');
            $table->integer('max_neg',false,true);
            $table->boolean('status')->default(0);
            $table->foreignId('tag_id')->nullable()->constrained('tags')->onDelete('cascade');
            $table->foreignId('carousel_id')->nullable()->constrained('carousels')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('product_sub_categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
