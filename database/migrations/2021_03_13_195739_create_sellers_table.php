<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone',12)->unique();
            $table->string('country', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->unsignedInteger('pincode')->nullable();
            $table->string('address', 100)->nullable();
            $table->boolean('active')->default(0);
            $table->boolean('verified')->default(0);
            $table->boolean('login')->default(0);
            $table->boolean('carousel_status')->default(0);
            $table->boolean('tag_status')->default(0);
            $table->boolean('meeting_status')->default(0);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->unsignedInteger('otp_email')->nullable();
            $table->unsignedInteger('otp_phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('image_name')->default('avatar.svg');
            $table->string('image_path')->default('images/default/avatar.svg');
            $table->text('descri')->nullable();
            $table->string('token')->nullable();
            $table->string('unique_id')->nullable();
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('sellers');
    }
}
