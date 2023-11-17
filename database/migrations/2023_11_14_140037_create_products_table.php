<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->float('price');
            $table->float('exchange_price');
            $table->enum('unit', ['piece', 'kg']);
            $table->unsignedBigInteger('related_product_id')->nullable();
            $table->foreign('related_product_id')->references('id')->on('products');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table){
            $table->dropSoftDeletes();
        });
    }
};
