<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceMetric extends Model
{
    protected $fillable = ['device_id', 'cpu_usage', 'ram_usage'];

    // كل سجل أداء ينتمي إلى جهاز محدد حصرياً
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
