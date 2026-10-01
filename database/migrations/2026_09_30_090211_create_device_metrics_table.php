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
    Schema::create('device_metrics', function (Blueprint $table) {
        $table->id();
        // ربط السجل بالجهاز المعني (إذا حُذف الجهاز تُحذف سجلاته تلقائياً)
        $table->foreignId('device_id')->constrained()->onDelete('cascade');
        $table->integer('cpu_usage')->nullable(); // نسبة ضغط المعالج %
        $table->integer('ram_usage')->nullable(); // نسبة ضغط الذاكرة RAM %
        $table->timestamps(); // الحقل المعتمد لرسم المنحنيات البيانية وتوقيت القراءة
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_metrics');
    }
};
