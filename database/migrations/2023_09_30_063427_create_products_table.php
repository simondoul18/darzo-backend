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
            $table->unsignedBigInteger('created_by');
            $table->uuid('uuid');
            $table->string('slug');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('sell_on_crm')->default(false);
            $table->boolean('sell_on_marketplace')->default(true);
            $table->unsignedDouble('price')->default(0.00);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->dateTime('scheduled_on')->nullable();
            $table->timestamps();
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
