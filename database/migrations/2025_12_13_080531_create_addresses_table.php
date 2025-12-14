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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable(); // مثل: البيت، العمل
            $table->string('area'); // المنطقة
            $table->string('street'); // الشارع
            $table->string('building_number')->nullable(); // رقم المبنى
            $table->string('floor')->nullable(); // الدور
            $table->string('apartment')->nullable(); // الشقة
            $table->text('additional_info')->nullable(); // معلومات إضافية
            $table->boolean('is_default')->default(false); // العنوان الافتراضي
            $table->decimal('latitude', 10, 8)->nullable(); // خط العرض للخريطة
            $table->decimal('longitude', 11, 8)->nullable(); // خط الطول للخريطة
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
