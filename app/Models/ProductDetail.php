<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pro_id',
        'detail',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'id');
    }
}
