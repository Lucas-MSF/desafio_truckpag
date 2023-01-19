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
            $table->integer("code");
            $table->enum("status",["draft", "trash", "published"]);
            $table->date("imported_t");
            $table->string("url");
            $table->string("creator");
            $table->timestamp("created_t");
            $table->integer("last_modified_t");
            $table->string("product_name");
            $table->string("quantity");
            $table->string("brands");
            $table->string("categories");
            $table->string("labels");
            $table->string("cities")->nullable();
            $table->string("purchase_places");
            $table->string("stores");
            $table->string("ingredients_text");
            $table->string("traces");
            $table->string("serving_size");
            $table->double("serving_quantity");
            $table->integer("nutriscore_score");
            $table->string("nutriscore_grade");
            $table->string("main_category");
            $table->string("image_url");
            
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
