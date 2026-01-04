<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends SpatiePermission
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * Konfigurasi Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('permission-management')
            ->logOnly(['name', 'guard_name', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Kolom yang boleh diisi (WAJIB untuk toggle)
     */
    protected $fillable = [
        'name',
        'guard_name',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Casting
     */
    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Boot model untuk audit trail
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

        // otomatis isi updated_by
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        // saat soft delete
        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
                $model->saveQuietly();
            }
        });
    }

    /**
     * Relasi audit trail
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