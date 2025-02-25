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
        // Schema::create('products', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('category_id')->constrained()->onDelete('cascade');
        //     $table->string('name');
        //     $table->decimal('price', 10, 2);
        //     $table->integer('stock');
        //     $table->string('photo')->nullable();
        //     $table->text('description')->nullable();
        //     $table->timestamps();
        // });

        // Create products table
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            // $table->bigInteger('category_id')->unsigned();
            $table->string('photo', 255)->nullable();
            $table->text('description')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
