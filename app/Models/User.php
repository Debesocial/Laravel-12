<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // Field yang boleh diisi melalui mass-assignment (create/update)
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Field yang disembunyikan ketika model di-serialize (API / array)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data untuk kolom tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // hashing otomatis jika di-set
    ];
}