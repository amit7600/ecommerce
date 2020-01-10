<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('product_child_id')->unsigned()->nullable();
            $table->foreign('product_child_id')->references('id')->on('child_products')->onDelete('cascade');

            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->integer('quantity')->nullable();

            $table->integer('removed_by')->nullable();

            $table->string('remove_reason')->nullable();

            $table->string('sub_total')->nullable();

            $table->string('discount')->nullable();

            $table->string('offer')->nullable();

            $table->string('tax_collected')->nullable();

            $table->string('grand_total')->nullable();

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
        Schema::dropIfExists('order_details');
    }
}
