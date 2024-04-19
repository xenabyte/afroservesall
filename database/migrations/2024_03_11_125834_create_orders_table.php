<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->text('additional_information')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->timestamp('booking_date')->nullable();
            $table->string('delivery_type')->nullable();
            $table->string('product_type')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
