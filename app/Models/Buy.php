<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
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
        'expire',
        'from_account',
        'from_no_account',
        'from_name_account',
        'to_account',
        'to_no_account',
        'to_name_account',
        'datetime_transection',
        'price',
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'cus_id', 'id');
    }
}
