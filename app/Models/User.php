<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'no_hp',
        'foto',
        'is_active',
        'last_login',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
{
    if ($panel->getId() === 'admin') {
        return $this->hasRole('admin') && $this->is_active;
    }
    
    if ($panel->getId() === 'panitia') {
        return $this->hasAnyRole(['admin', 'panitia']) && $this->is_active;
    }
    if ($panel->getId() === 'user') {
            return $this->hasRole('user') && $this->is_active;
        }
    
    return false;
}

    public function pendaftaran()
    {
        return $this->hasOne(Pendaftaran::class);
    }
}