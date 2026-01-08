<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * {{-- konfigurasi activity log untuk role --}}
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('role-management') // log kategori/module
            ->logOnly(['name', 'guard_name', 'is_active']) // field yang dipantau
            ->logOnlyDirty()                               // hanya log jika berubah
            ->dontSubmitEmptyLogs();                       // skip jika tidak ada perubahan
    }

    protected $fillable = [
        'name',
        'guard_name',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * {{-- Boot model untuk otomatis created_by & updated_by --}}
     */
    protected static function boot()
    {
        parent::boot();

        // otomatis isi created_by
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        // otomatis isi updated_by (termasuk soft delete)
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
                $model->saveQuietly(); // simpan tanpa trigger infinite update log
            }
        });
    }

    /**
     * {{-- RELASI AUDIT TRAIL --}}
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}