<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cus_id',
        'name_api',
        'type_name_api',
        'days_api',
        'price_api',
        'status',
        'comment',
        'token',
        'expire',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'cus_id', 'id');
    }
}
