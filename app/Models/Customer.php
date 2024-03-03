<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'person_type',
        'cpf_cnpj',
        'email',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
