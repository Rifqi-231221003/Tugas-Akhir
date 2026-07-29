<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Exchange extends Model
{
    protected $table='exchange';

    protected $primaryKey = 'exc_code';
    public $incrementing = false;     
    protected $keyType = 'string';    
    public $timestamps = false;

    protected $fillable = [
        'exc_code',
        'product1',
        'product2',
        'rate',
        'fee_type',
        'fee',
        'min',
    ];
    
    // Clear sitemap cache saat data disimpan, diupdate, atau dihapus
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('sitemap');
        });
        
        static::deleted(function () {
            Cache::forget('sitemap');
        });
    }
}
