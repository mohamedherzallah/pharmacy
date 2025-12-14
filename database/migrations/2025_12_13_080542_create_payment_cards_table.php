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
        Schema::create('payment_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_type'); // visa, mastercard, etc.
            $table->string('last_four'); // آخر 4 أرقام
            $table->string('cardholder_name');
            $table->string('expiry_month');
            $table->string('expiry_year');
            $table->string('token')->unique(); // الرمز المشفر من بوابة الدفع
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index('user_id');
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_cards');
    }
};
