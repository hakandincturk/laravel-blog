<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('categoryId')->unsigned();
            $table->string('title');
            $table->string('image');
            $table->longText('content');
            $table->string('slug');
            $table->integer('hit')->default(0);
            $table->integer('status')->default(0)->content('0:pasif, 1:aktif');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('categoryId')
                    ->references('id')
                    ->on('categories');
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
