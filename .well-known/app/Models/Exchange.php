<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
