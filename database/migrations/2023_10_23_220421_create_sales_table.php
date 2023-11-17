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
        Schema::create('sales', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('total',12,2);
            $table->integer('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->integer('truck_id')->unsigned()->nullable();
            $table->foreign('truck_id')->references('id')->on('names')->onDelete('cascade');
            $table->integer('buyer_id')->unsigned()->index();
            $table->foreign('buyer_id')->references('id')->on('names')->onDelete('cascade');
            $table->integer('trip_id')->unsigned()->index();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->boolean('is_sold')->default(0);
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
        Schema::dropIfExists('sales');
    }
};
