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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('starting_bid',15,2);
            $table->decimal('current_bid',15,2)->nullable();
            $table->decimal('bid_increment', 15, 2)->default(1000);
            $table->foreignId('highest_bidder_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status',['PENDING','ACTIVE','CLOSED'])->default('PENDING');
            $table->foreignid('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('final_price',15,2)->nullable();
            $table->string('image_path');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};
