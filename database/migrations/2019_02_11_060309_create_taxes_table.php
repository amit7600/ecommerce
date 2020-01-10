<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tax_name')->nullable();
            $table->string('tax_name_arabic')->nullable();
            $table->string('tax_rate')->nullable();
            $table->string('tax_description')->nullable();
            $table->string('tax_description_arabic')->nullable();
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
        Schema::dropIfExists('taxes');
    }
}
