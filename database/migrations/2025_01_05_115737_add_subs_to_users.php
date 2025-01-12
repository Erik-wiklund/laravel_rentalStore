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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id')->nullable(); // Add subscription_id column

            $table->foreign('subscription_id') // Create foreign key
                ->references('id') // References the id of the subscriptions table
                ->on('subscriptions') // On the subscriptions table
                ->onDelete('CASCADE'); // Delete users when their subscription is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
