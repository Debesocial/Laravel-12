<?php

namespace App\Services\Monitoring;

use Illuminate\Support\Facades\DB;

class SystemMonitoringService
{
    // ========================
    // CPU Usage
    // ========================
    public function getCpuUsage()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('wmic cpu get loadpercentage /value');
            if (!$output) {
                return 0;
            }

            preg_match('/LoadPercentage=(\d+)/', $output, $matches);
            return isset($matches[1]) ? (int) $matches[1] : 0;
        }

        // Linux / Unix
        $load  = sys_getloadavg()[0] ?? 0;
        $cores = (int) shell_exec('nproc') ?: 1;

        return (int) round(($load / $cores) * 100);
    }

    // ========================
    // RAM Usage
    // ========================
    public function getRamUsage()
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value');
            if (!$output) {
                return 0;
            }

            preg_match('/TotalVisibleMemorySize=(\d+)/', $output, $total);
            preg_match('/FreePhysicalMemory=(\d+)/', $output, $free);

            if (!isset($total[1], $free[1])) {
                return 0;
            }

            return (int) round((1 - ($free[1] / $total[1])) * 100);
        }

        // Linux
        $info = @file_get_contents('/proc/meminfo');
        if (!$info) {
            return 0;
        }

        preg_match('/MemTotal:\s+(\d+)/', $info, $total);
        preg_match('/MemAvailable:\s+(\d+)/', $info, $available);

        if (!isset($total[1], $available[1])) {
            return 0;
        }

        return (int) round((1 - ($available[1] / $total[1])) * 100);
    }

    // ========================
    // Disk Usage
    // ========================
    public function getDiskUsage()
    {
        $path = PHP_OS_FAMILY === 'Windows' ? 'C:' : '/';

        $total = @disk_total_space($path);
        $free  = @disk_free_space($path);

        if (!$total || !$free) {
            return 0;
        }

        return (int) round((1 - ($free / $total)) * 100);
    }

    // ========================
    // Active Users (Laravel Session)
    // ========================
    public function getActiveUsers()
    {
        if (!DB::getSchemaBuilder()->hasTable('sessions')) {
            return 0;
        }

        return DB::table('sessions')->count();
    }

    // ========================
    // Bundle All Metrics
    // ========================
    public function getAll()
    {
        return [
            'os'    => PHP_OS_FAMILY,
            'cpu'   => $this->getCpuUsage(),
            'ram'   => $this->getRamUsage(),
            'disk'  => $this->getDiskUsage(),
            'users' => $this->getActiveUsers(),
        ];
    }
}
