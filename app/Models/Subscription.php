<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'days',
    ];
}