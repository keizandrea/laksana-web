<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // 🌟 1. PASTIKAN IMPORT INI ADA

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // 🌟 2. PASTIKAN TRAIT INI DIPAKAI

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}