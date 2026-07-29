<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserData extends Model
{
    protected $table = 'user_data';
    
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'name',
        'phone_code',
        'phone_number',
        'country',
        'province',
        'city',
        'address'
    ];
    
    protected $casts = [
        'phone_number' => 'integer',
    ];
    
    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    // Helper untuk mendapatkan nomor telepon lengkap
    public function getFullPhoneAttribute(): string
    {
        return $this->phone_code . $this->phone_number;
    }
}