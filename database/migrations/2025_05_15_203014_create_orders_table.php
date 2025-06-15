<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('zip_code');
            $table->decimal('total', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->enum('status', ['pending', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }
};
