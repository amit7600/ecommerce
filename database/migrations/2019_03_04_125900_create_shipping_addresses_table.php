<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('pincode')->nullable();
            $table->string('address')->nullable();
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->enum('address_type',['home','office'])->default('home')->comment('home = Home , office = Office/Commercial');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('shipping_address_id')->unsigned()->nullable()->after('transaction_id');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_shipping_address_id_foreign');
            $table->dropColumn('shipping_address_id');
        });
        Schema::dropIfExists('shipping_addresses');
    }
}
