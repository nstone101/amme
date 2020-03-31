<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('portfolio_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title')->nullable();
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->text('experience')->nullable();
            $table->string('client')->nullable();
            $table->date('date')->nullable();
            $table->string('demo')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
}
