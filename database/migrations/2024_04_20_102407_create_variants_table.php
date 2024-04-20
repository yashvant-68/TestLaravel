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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->integer('color')->nullable()->default(null);
            $table->integer('size')->nullable()->default(null);
            $table->integer('quantity')->nullable()->default(null);
            $table->double('price')->nullable()->default(null);
            $table->double('selling_price')->nullable()->default(null);
            $table->double('discount_amount')->nullable()->default(null);
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
        Schema::dropIfExists('variants');
    }
};
