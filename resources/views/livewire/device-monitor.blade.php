<div wire:poll="5s" style="max-width: 1100px; margin: 30px auto; font-family: system-ui, -apple-system, sans-serif; padding: 20px; direction: ltr; text-align: left; background-color: #f8fafc;">
    
    <!-- Dashboard Header -->
    <div style="background-color: #1e293b; color: #ffffff; padding: 24px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 0.5px; color: #ffffff;">NetPulse SaaS 🌐</h1>
            <p style="margin: 6px 0 0 0; color: #94a3b8; font-size: 13px;">Automated Infrastructure Monitoring & Live NOC Operations Terminal</p>
        </div>
        <div style="background-color: #334155; padding: 8px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; color: #cbd5e1;">
            Status: Active Monitoring
        </div>
    </div>

    <!-- System Success Notifications -->
    @if (session()->has('message'))
        <div style="padding: 14px; background-color: #f0fdf4; border-left: 4px solid #22c55e; color: #166534; border-radius: 6px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
            {{ session('message') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
        
        <!-- Add Device Form -->
        <div style="background-color: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <h3 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; color: #334155; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; font-weight: 700;">➕ Register New Infrastructure Asset</h3>
            
            <form wire:submit.prevent="addDevice" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; align-items: end;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px;">Device / Host Name</label>
                    <input type="text" wire:model="name" placeholder="e.g., Core Web Server" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; background-color: #ffffff;">
                    @error('name') <span style="color: #ef4444; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px;">IP Address Target</label>
                    <input type="text" wire:model="ip_address" placeholder="e.g., 127.0.0.1" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; box-sizing: border-box; font-family: monospace; background-color: #ffffff;">
                    @error('ip_address') <span style="color: #ef4444; font-size: 11px; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px;">Asset Type</label>
                    <select wire:model="type" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; background-color: #ffffff; box-sizing: border-box; height: 38px;">
                        <option value="server">Linux/Windows Server 🖥️</option>
                        <option value="router">Core Router 🎛️</option>
                        <option value="switch">Network Switch 🔌</option>
                    </select>
                </div>

                <div>
                    <button type="submit" style="width: 100%; background-color: #2563eb; color: white; border: none; padding: 11px; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; height: 38px; box-shadow: 0 2px 4px rgba(37,99,235,0.2);">
                        Activate Node Mgt 📡
                    </button>
                </div>
            </form>
        </div>
        <!-- Live Monitoring Grid -->
        <div style="background-color: #ffffff; padding: 24px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 16px; color: #334155; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; font-weight: 700;">🖥️ Real-time Network Topology Status (Live Stream)</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; background-color: #ffffff;">
                    <thead>
                        <tr style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; width: 20%;">Device / Host</th>
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; width: 15%;">IP Address</th>
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; width: 12%;">Hardware Type</th>
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; width: 18%;">Ping Status</th>
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; width: 20%;">Live Resource Metrics</th>
                            <th style="padding: 14px 12px; font-size: 13px; color: #64748b; font-weight: 600; text-align: center; width: 15%;">Operational Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr style="border-bottom: 1px solid #f1f5f9; background-color: #ffffff;">
                                <td style="padding: 16px 12px; font-weight: 600; color: #1e293b;">
                                    {{ $device->name }}
                                </td>
                                
                                <td style="padding: 16px 12px; font-family: monospace; color: #475569; font-size: 14px;">
                                    {{ $device->ip_address }}
                                </td>
                                
                                <td style="padding: 16px 12px; font-size: 13px;">
                                    <span style="background-color: #f1f5f9; padding: 4px 8px; border-radius: 4px; color: #475569; font-weight: 600; font-size: 11px;">{{ strtoupper($device->type) }}</span>
                                </td>
                                
                                <td style="padding: 16px 12px; vertical-align: middle;">
                                    <div style="display: block; margin-bottom: 4px;">
                                        @if($device->status == 'online')
                                            <span style="background-color: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;">● Online</span>
                                        @else
                                            <span style="background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block;">● Offline</span>
                                        @endif
                                    </div>
                                    @if(session()->has('device_msg_' . $device->id))
                                        <span style="font-size: 11px; color: #2563eb; display: block; font-weight: 500;">{{ session('device_msg_' . $device->id) }}</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 12px; vertical-align: middle;">
                                    @if($device->status == 'online' && $device->metrics->isNotEmpty())
                                        @php $latestMetric = $device->metrics->first(); @endphp
                                        <div style="display: flex; gap: 8px;">
                                            <span style="color: {{ $latestMetric->cpu_usage > 80 ? '#ef4444' : '#1e293b' }}; background: #f8fafc; padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 12px; font-weight: 600; font-family: monospace;">
                                                CPU: {{ $latestMetric->cpu_usage }}%
                                            </span>
                                            <span style="color: {{ $latestMetric->ram_usage > 85 ? '#ef4444' : '#1e293b' }}; background: #f8fafc; padding: 6px 10px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 12px; font-weight: 600; font-family: monospace;">
                                                RAM: {{ $latestMetric->ram_usage }}%
                                            </span>
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-size: 12px; font-style: italic;">No active data streams</span>
                                    @endif
                                </td>
                                
                                <!-- قفل الأزرار أفقياً ومحاذاتها بشكل احترافي متوازي -->
                                <td style="padding: 16px 12px; text-align: center; vertical-align: middle;">
                                    <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                                        <button wire:click="checkDevice({{ $device->id }})" style="background-color: #10b981; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; white-space: nowrap; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            Ping ⏱️
                                        </button>
                                        <button wire:click="deleteDevice({{ $device->id }})" style="background-color: #ef4444; color: white; border: none; padding: 8px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.2s; white-space: nowrap; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            Delete 🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8; font-style: italic; font-size: 14px; background-color: #ffffff;">
                                    Infrastructure pool is currently empty. Register your first production node above! 📡
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
