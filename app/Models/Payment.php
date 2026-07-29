<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'transaction';
    
    protected $primaryKey = 'trx_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'trx_id',
        'client_name',
        'client_email',
        'client_phonenumber',
        'trx_status',
        'trx_date',
        'product1',
        'product2',
        'blockchain1',
        'blockchain2',
        'product1_amount',
        'product2_amount',
        'fee',
        'product1_dest',
        'product2_dest',
        'product1_payment_proof',
        'product2_payment_proof'
    ];
}