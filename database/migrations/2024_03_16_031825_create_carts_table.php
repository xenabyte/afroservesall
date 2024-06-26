<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('description')->nullable();
            $table->string('feature_id')->nullable();
            $table->string('quantity')->default(1);
            $table->decimal('price')->nullable();
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->string('order_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
