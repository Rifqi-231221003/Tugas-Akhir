<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table='payment_method';

    protected $primaryKey = 'pm_code';
    public $incrementing = false;     
    protected $keyType = 'string';    
    public $timestamps = false;

    protected $fillable = [
        'pm_code',
        'product_name',
        'pm_blockchain',
        'type',
        'destination',
        'name',
    ];//
}
