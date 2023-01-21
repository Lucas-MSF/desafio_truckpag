<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string("code");
            $table->enum("status",["draft", "trash", "published"]);
            $table->string("imported_t");
            $table->string("url")->nullable();
            $table->string("creator")->nullable();
            $table->integer("created_t")->nullable();
            $table->integer("last_modified_t")->nullable();
            $table->string("product_name")->nullable();
            $table->string("quantity")->nullable();
            $table->string("brands")->nullable();
            $table->string("categories")->nullable();
            $table->string("labels")->nullable();
            $table->string("cities")->nullable();
            $table->string("purchase_places")->nullable();
            $table->string("stores")->nullable();
            $table->string("ingredients_text")->nullable();
            $table->string("traces")->nullable();
            $table->string("serving_size")->nullable();
            $table->double("serving_quantity")->nullable();
            $table->integer("nutriscore_score")->nullable();
            $table->string("nutriscore_grade")->nullable();
            $table->string("main_category")->nullable();
            $table->string("image_url")->nullable();
            
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
};
