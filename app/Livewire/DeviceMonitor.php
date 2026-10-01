<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Device;
use App\Models\DeviceMetric;

class DeviceMonitor extends Component
{
    // متغيرات استمارة إضافة جهاز جديد
    public $name;
    public $ip_address;
    public $type = 'server';

    // شروط التحقق الصارمة لحماية المدخلات
    protected $rules = [
        'name' => 'required|string|min:3|max:50',
        'ip_address' => 'required|ip', // التحقق من أن المدخل هو عنوان IP صحيح
        'type' => 'required|in:server,router,switch',
    ];
    protected $messages = [
        'name.required' => 'Device or server name is required.',
        'ip_address.required' => 'IP Address is required.',
        'ip_address.ip' => 'Please enter a valid IP address (e.g., 192.168.1.1).',
    ];


    /**
     * دالة إضافة جهاز جديد إلى نظام المراقبة
     */
    public function addDevice()
    {
        $this->validate();

        // إنشاء الجهاز وحفظه بحالة أولية منقطعة
        Device::create([
            'name' => $this->name,
            'ip_address' => $this->ip_address,
            'type' => $this->type,
            'status' => 'offline',
        ]);

        $this->reset(['name', 'ip_address']);
        session()->flash('message', 'Device successfully added to monitoring grid! 🚀');
    }

    /**
     * الدالة السحرية: محرك فحص الشبكة (The Live Pinger)
     * تقوم بفحص حالة الجهاز عبر الـ IP وتوليد قراءات الأداء دورياً
     */
    public function checkDevice($id)
    {
        $device = Device::findOrFail($id);
        
        // --- 🌐 كود الـ Ping الهندسي الحقيقي ---
        // في الويندوز نستخدم -n 1 لإرسال حزمة واحدة، وفي لينكس نستخدم -c 1
        $str = substr(php_uname(), 0, 7);
        if ($str == "Windows") {
            exec("ping -n 1 " . $device->ip_address, $output, $result);
        } else {
            exec("ping -c 1 " . $device->ip_address, $output, $result);
        }

        // إذا كانت النتيجة صفر ($result == 0) فهذا يعني أن الجهاز رد على الإشارة وهو متصلOnline
        if ($result == 0) {
            $status = 'online';
            
            // توليد قراءات أداء ذكية ومحاكاتها للسيرفر المتصل
            $cpu = rand(15, 85); // ضغط معالج عشوائي بين 15% و 85%
            $ram = rand(30, 90); // ضغط ذاكرة عشوائي بين 30% و 90%

            DeviceMetric::create([
                'device_id' => $device->id,
                'cpu_usage' => $cpu,
                'ram_usage' => $ram,
            ]);
        } else {
            $status = 'offline';
        }

        // تحديث حالة الجهاز وتوقيت الفحص فوراً في قاعدة البيانات
        $device->update([
            'status' => $status,
            'last_ping_at' => now(),
        ]);

        session()->flash('device_msg_' . $id, 'Device health checked successfully! ⏱️');    }

    /**
     * دالة حذف جهاز من المنظومة
     */
    public function deleteDevice($id)
    {
        Device::destroy($id);
        session()->flash('message', 'Device removed from monitoring dashboard.');
    }

    public function render()
    {
        // جلب الأجهزة مع آخر سجل أداء مرتبطة بها بضربة واحدة سريعة لتقليل الضغط (Eager Loading)
        $devices = Device::with(['metrics' => function($query) {
            $query->latest()->limit(1);
        }])->get();

        return view('livewire.device-monitor', compact('devices'));
    }
}
