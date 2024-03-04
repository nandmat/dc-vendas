<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Seller;
use App\Models\Customer;

class Sale extends Model
{
    use HasFactory;


    protected $fillable = [
        'seller_id',
        'customer_id',
        'value',
        'parts'
    ];


    protected $casts = [
        'part' => 'array',
        'created_at' => 'datetime'
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
