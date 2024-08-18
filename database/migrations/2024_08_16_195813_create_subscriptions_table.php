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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->foreignId('sport_id')->constrained('sports')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status',['active','unactive','suspend'])->default('unactive');
            $table->text('reason_of_suspension')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
