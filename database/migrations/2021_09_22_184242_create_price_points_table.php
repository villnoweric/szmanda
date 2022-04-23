<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_points', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('productSku');
            $table->integer('storeNumber');
            $table->float('listPrice');
            $table->boolean('onSale');
            $table->boolean('onClearance');
            $table->float('salePrice')->nullable();
            $table->dateTime('saleStart')->nullable();
            $table->dateTime('saleEnd')->nullable();
            $table->boolean('isRebate');
            $table->float('totalRebate')->nullable();
            $table->json('rebates')->nullable();
            $table->integer('inventory');
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
        Schema::dropIfExists('price_points');
    }
}
