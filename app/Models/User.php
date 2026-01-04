<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Auth\Notifications\ResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, LogsActivity;

    /**
     * Konfigurasi logging untuk Spatie Activitylog
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('user-management')
            ->logOnly(['name', 'email', 'is_active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',     // ✅ PENTING
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * Hidden fields
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast tipe data
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    /**
     * ==========================================
     * DISABLE RESET PASSWORD UNTUK GOOGLE USER
     * ==========================================
     */
    public function sendPasswordResetNotification($token)
    {
        // ❌ Google OAuth user → BLOCK reset password
        if ($this->google_id) {
            return;
        }

        // ✅ User manual → normal
        $this->notify(new ResetPassword($token));
    }

    /**
     * Helper (opsional tapi rapi)
     */
    public function isGoogleUser(): bool
    {
        return !is_null($this->google_id);
    }

    /**
     * RELASI AUDIT TRAIL
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


// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions; 

// class User extends Authenticatable
// {
//     use HasFactory, Notifiable, HasRoles, SoftDeletes, LogsActivity;

//     /**
//      * Konfigurasi logging untuk Spatie Activitylog
//      */
//     public function getActivitylogOptions(): LogOptions
//     {
//         return LogOptions::defaults()
//             ->useLogName('user-management')                // nama module di log
//             ->logOnly(['name', 'email', 'is_active'])      // field yang dilog
//             ->logOnlyDirty()                               // hanya catat jika berubah
//             ->dontSubmitEmptyLogs();                       // abaikan jika tidak ada perubahan
//     }

//     /**
//      * Kolom yang boleh diisi (Mass Assignment)
//      */
//     protected $fillable = [
//         'name',
//         'email',
//         'password',
//         'is_active',
//         'created_by',
//         'updated_by',
//     ];

//     /**
//      * Hidden fields
//      */
//     protected $hidden = [
//         'password',
//         'remember_token',
//     ];

//     /**
//      * Cast tipe data
//      */
//     protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password'          => 'hashed',
//         'is_active'         => 'boolean',
//     ];

//     /**
//      * {{-- RELASI AUDIT TRAIL --}}
//      */
//     public function creator()
//     {
//         return $this->belongsTo(User::class, 'created_by');
//     }

//     public function updater()
//     {
//         return $this->belongsTo(User::class, 'updated_by');
//     }
// }