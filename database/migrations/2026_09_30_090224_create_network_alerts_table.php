<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::create('network_alerts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('device_id')->constrained()->onDelete('cascade');
        $table->string('message'); // نص التنبيه (مثال: تجاوز استهلاك الذاكرة 92%)
        $table->boolean('is_resolved')->default(false); // هل قام فريق الصيانة بحل المشكلة؟
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('network_alerts');
    }
};
