<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('product_name')->nullable();
            $table->string('product_name_arabic')->nullable();
            $table->string('product_code')->nullable();
            $table->longText('product_description')->nullable();
            $table->longText('product_description_arabic')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            // $table->longText('product_attribute')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_image_arabic')->nullable();
            $table->longText('product_other_image')->nullable();
            $table->longText('product_other_image_arabic')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->double('sale_price', 8, 2)->nullable();
            $table->date('effective_from')->nullable();
            $table->date('effective_to')->nullable();
            $table->enum('status', [0, 1])->default(1)->nullable()->comment('0 = Inactive and 1 = Active');
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
        Schema::dropIfExists('products');
    }
}
