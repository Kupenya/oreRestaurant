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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // Foreign key to users table
            $table->decimal('total_price', 8, 2); // Total price of the order
            $table->enum('status', ['pending', 'completed', 'cancelled']); // Status of the order
            $table->timestamp('order_time'); // Timestamp when the order was placed
            $table->timestamps(); // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};