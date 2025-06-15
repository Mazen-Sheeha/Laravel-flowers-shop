<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->decimal('price', 10, 2);
            $table->integer('offer')->nullable();
            $table->decimal('current_price', 10, 2)->storedAs('CASE WHEN offer IS NULL THEN price ELSE price - (price * offer / 100) END');
            $table->foreignId("category_id")->nullable()->constrained()->onDelete("set null");
            $table->timestamps();
        });
    }
};
