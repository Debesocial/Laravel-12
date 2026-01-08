<?php

namespace App\Http\Controllers\SystemSettings;

use Illuminate\Routing\Controller;
use App\Services\Monitoring\SystemMonitoringService;

class ResourceMonitoringController extends Controller
{
    public function __construct()
{
    $this->middleware('permission:view resource monitoring');
}

    public function index(SystemMonitoringService $monitor)
    {
        // Ambil data dari service
        $data = $monitor->getAll();

        // Susun data untuk tabel resource
        $resources = [
            [
                'name'      => 'CPU Load',
                'category'  => 'Performance',
                'usage'     => $data['cpu'] . '%',
                'limit'     => '100%',
                'time'      => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'RAM Usage',
                'category'  => 'Performance',
                'usage'     => $data['ram'] . '%',
                'limit'     => 'Physical Installed Memory',
                'time'      => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'Disk Usage',
                'category'  => 'System',
                'usage'     => $data['disk'] . '%',
                'limit'     => 'Total Storage Capacity',
                'time'      => now()->format('Y-m-d H:i:s'),
            ],
            [
                'name'      => 'Active Users',
                'category'  => 'Users',
                'usage'     => $data['users'],
                'limit'     => 'No Limit',
                'time'      => now()->format('Y-m-d H:i:s'),
            ],
        ];

        // Kirim data ke view
        return view('pages.system_settings.resource-monitoring', [
            'cpu'       => $data['cpu'],
            'ram'       => $data['ram'],
            'disk'      => $data['disk'],
            'users'     => $data['users'],
            'resources' => $resources,
        ]);
    }
}