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
    Schema::create('devices', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // اسم الجهاز (مثال: سـيرفر قاعدة البيانات)
        $table->string('ip_address'); // عنوان الـ IP الخاص بالجهاز
        $table->enum('type', ['server', 'router', 'switch'])->default('server'); // نوع الجهاز
        $table->enum('status', ['online', 'offline', 'warning'])->default('offline'); // حالة الاتصال
        $table->timestamp('last_ping_at')->nullable(); // تاريخ آخر فحص ناجح
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
