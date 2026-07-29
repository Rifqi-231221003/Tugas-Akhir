<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    protected $table='blockchain';

    protected $primaryKey = 'blockchain_code';
    public $incrementing = false;     
    protected $keyType = 'string';    
    public $timestamps = false;

    protected $fillable = [
        'blockchain_code',
        'product_name',
        'blockchain',
        'blockchain_fee',
        'blockchain_img',
    ];//
}
