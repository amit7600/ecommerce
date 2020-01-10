<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('transaction_id')->nullable();
            $table->string('order_number')->nullable();
            $table->enum('status', ['ordered', 'in_progress', 'shipped', 'completed', 'cancelled'])->default('ordered')->nullable();
            $table->integer('payment_method')->default(1)->nullable()->comment('1 = Cash, 2 = Card');
            $table->dateTime('ordered_at')->nullable();
            
            $table->dateTime('in_progress_at')->nullable();

            $table->dateTime('shipped_at')->nullable();

            $table->dateTime('completed_at')->nullable();

            $table->string('cancel_reason')->nullable();

            $table->integer('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();

            $table->string('sub_total')->nullable();
            $table->string('discount')->nullable();
            $table->string('offer')->nullable();
            $table->string('tax_collected')->nullable();
            $table->string('grand_total')->nullable();

            $table->string('ip')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
