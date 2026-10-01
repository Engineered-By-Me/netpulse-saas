<?php

use Illuminate\Support\Facades\Schedule;
use App\Models\Device;
use App\Models\DeviceMetric;

/**
 * محرك الأتمتة وجدولة المهام لـ NetPulse
 * هذا الكود يعمل في الخلفية كل دقيقة ليفحص كافة الأجهزة تلقائياً
 */
Schedule::call(function () {
    // 1. جلب كافة الأجهزة المسجلة في النظام
    $devices = Device::all();

    foreach ($devices as $device) {
        // 2. إطلاق إشارة الـ Ping الحركية بناءً على نظام التشغيل
        $str = substr(php_uname(), 0, 7);
        if ($str == "Windows") {
            exec("ping -n 1 " . $device->ip_address, $output, $result);
        } else {
            exec("ping -c 1 " . $device->ip_address, $output, $result);
        }

        // 3. تحليل النتيجة وتحديث قاعدة البيانات
        if ($result == 0) {
            $status = 'online';

            // محاكاة وتوليد قراءات أداء متجددة دورياً للسيرفر المتصل
            DeviceMetric::create([
                'device_id' => $device->id,
                'cpu_usage' => rand(10, 90),
                'ram_usage' => rand(25, 95),
            ]);
        } else {
            $status = 'offline';
        }

        // 4. قفل السجل بالوقت والحالة المحدثة فوراً
        $device->update([
            'status' => $status,
            'last_ping_at' => now(),
        ]);
    }
})->everyMinute(); // تفعيل الفحص الدوري الإجباري كل دقيقة واحدة!
