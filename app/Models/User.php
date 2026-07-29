<?php

namespace App\Models;

use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Support\Facades\Password;

class User extends Authenticatable implements FilamentUser, HasEmailAuthentication
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'has_email_authentication',
        'status',
        'device_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'device_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'has_email_authentication' => 'boolean'
        ];
    }

    protected function rules(): array
    {
        return [
            'current_password' => ['required_with:new_password', 'current_password'],
            'new_password' => ['nullable', Password::defaults(), 'confirmed'],
        ];
    }

    // Relasi ke UserData
    public function userData()
    {
        return $this->hasOne(UserData::class, 'user_id', 'id');
    }

    // TAMBAHKAN METHOD INI 
    public function canAccessPanel(Panel $panel): bool
    {
        // Untuk sementara, izinkan semua user yang login
        return true;
        
        // Nanti bisa diperketat, misal:
        // return $this->status === 'active'; // Hanya user dengan status active
        // return $this->email === 'admin@example.com'; // Hanya email tertentu
        // return $this->hasRole('admin'); // Jika pakai role
    }

    public function hasEmailAuthentication(): bool
    {
    // This method should return true if the user has enabled email authentication.
        return $this->has_email_authentication;
    }

    public function toggleEmailAuthentication(bool $condition): void
    {
    // This method should save whether or not the user has enabled email authentication.

        $this->has_email_authentication = $condition;
        $this->save();
    }
}