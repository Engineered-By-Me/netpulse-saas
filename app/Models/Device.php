<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = ['name', 'ip_address', 'type', 'status', 'last_ping_at'];

    // الجهاز الواحد يمتلك العديد من سجلات الأداء الدورية
    public function metrics(): HasMany
    {
        return $this->hasMany(DeviceMetric::class);
    }

    // الجهاز الواحد يمتلك العديد من التنبيهات المسجلة
    public function alerts(): HasMany
    {
        return $this->hasMany(NetworkAlert::class);
    }
}
