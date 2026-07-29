<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    // Nama tabel (sesuai migration)
    protected $table = 'transaction';
    
    // Primary key (bukan auto-increment, string)
    protected $primaryKey = 'trx_id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    // Disable timestamps karena menggunakan trx_date manual
    public $timestamps = false;
    
    // Fillable fields
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
    
    // Casting tipe data
    protected $casts = [
        'trx_date' => 'datetime',
        'product1_amount' => 'decimal:2',
        'product2_amount' => 'decimal:2',
        'fee' => 'decimal:2'
    ];
    
    // ============================================= //
    // RELATIONS (jika perlu)                         //
    // ============================================= //
    
    /**
     * Relasi ke Product (product1)
     */
    public function productFrom()
    {
        return $this->belongsTo(Product::class, 'product1', 'product_code');
    }
    
    /**
     * Relasi ke Product (product2)
     */
    public function productTo()
    {
        return $this->belongsTo(Product::class, 'product2', 'product_code');
    }
    
    /**
     * Relasi ke Blockchain (blockchain1)
     */
    public function blockchainFrom()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain1', 'blockchain');
    }
    
    /**
     * Relasi ke Blockchain (blockchain2)
     */
    public function blockchainTo()
    {
        return $this->belongsTo(Blockchain::class, 'blockchain2', 'blockchain');
    }
    
    // ============================================= //
    // SCOPES (filter query)                          //
    // ============================================= //
    
    /**
     * Scope untuk transaksi pending
     */
    public function scopePending($query)
    {
        return $query->where('trx_status', 'pending');
    }
    
    /**
     * Scope untuk transaksi completed
     */
    public function scopeCompleted($query)
    {
        return $query->where('trx_status', 'completed');
    }
    
    /**
     * Scope untuk transaksi failed
     */
    public function scopeFailed($query)
    {
        return $query->where('trx_status', 'failed');
    }
    
    /**
     * Scope berdasarkan tanggal
     */
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('trx_date', [$startDate, $endDate]);
    }
    
    // ============================================= //
    // ACCESSORS & MUTATORS                           //
    // ============================================= //
    
    /**
     * Get status badge HTML
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'completed' => 'success',
            'failed' => 'danger',
            'processing' => 'info'
        ];
        
        $color = $colors[$this->trx_status] ?? 'secondary';
        
        return "<span class='px-2 py-1 text-xs rounded-full bg-{$color}-100 text-{$color}-800'>
                    {$this->trx_status}
                </span>";
    }
    
    /**
     * Format tanggal Indonesia
     */
    public function getFormattedDateAttribute()
    {
        return $this->trx_date->format('d/m/Y H:i:s');
    }
    
    // ============================================= //
    // HELPER METHODS                                 //
    // ============================================= //
    
    /**
     * Generate unique transaction ID
     */
    public static function generateTrxId()
    {
        $prefix = 'TRX';
        $date = date('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        $trxId = $prefix . $date . $random;
        
        // Ensure unique
        while (self::where('trx_id', $trxId)->exists()) {
            $random = strtoupper(substr(uniqid(), -6));
            $trxId = $prefix . $date . $random;
        }
        
        return $trxId;
    }
}