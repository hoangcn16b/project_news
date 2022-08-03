<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id')->autoIncrement();
            $table->string('name', 100);
            $table->integer('category_id');
            $table->text('content')->nullable();
            $table->string('thumb')->nullable();
            $table->string('status', 100);
            $table->dateTime('publish_at');
            $table->string('type', 100)->nullable();
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamps();
            // $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
