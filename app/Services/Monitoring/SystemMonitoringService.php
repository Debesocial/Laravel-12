<?php

namespace App\Services\Monitoring;
use Illuminate\Support\Facades\DB;

class SystemMonitoringService
{
    // CPU Usage
    public function getCpuUsage()
    {
        $load = sys_getloadavg()[0]; // CPU load (1 minute)
        $cores = shell_exec("nproc") ?: 4; // jumlah core (fallback 4)
        return round(($load / $cores) * 100);
    }

    // RAM Usage
    public function getRamUsage()
    {
        $info = file_get_contents('/proc/meminfo');
        preg_match('/MemTotal:\s+(\d+)/', $info, $total);
        preg_match('/MemAvailable:\s+(\d+)/', $info, $available);

        $totalMB = $total[1] / 1024;
        $availMB = $available[1] / 1024;

        return round((($totalMB - $availMB) / $totalMB) * 100);
    }

    // Storage / Disk
    public function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free  = disk_free_space('/');
        return round((1 - ($free / $total)) * 100);
    }

    // Active Users (Laravel Session)
    public function getActiveUsers()
    {
        return DB::table('sessions')->count();
    }

    // Bundle semua
    public function getAll()
    {
        return [
            'cpu' => $this->getCpuUsage(),
            'ram' => $this->getRamUsage(),
            'disk' => $this->getDiskUsage(),
            'users' => $this->getActiveUsers(),
        ];
    }
}