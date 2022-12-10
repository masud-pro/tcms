<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionUser extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'subscription_id',
        'expiry_date',
    ];
}