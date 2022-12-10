<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubAccount extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'sub_user_id',
        'total_price',
        'to_date',
        'from_date',
        'status',
    ];
}