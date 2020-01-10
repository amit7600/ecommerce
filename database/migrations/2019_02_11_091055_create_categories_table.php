<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_category')->nullable()->default(0);
            $table->string('category_name')->nullable();
            $table->string('category_name_arabic')->nullable();
            $table->string('category_image')->nullable();
            $table->integer('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
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
        Schema::dropIfExists('categories');
    }
}
