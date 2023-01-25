<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'teacher_id',
        'name',
        'email',
        'address',
        'phone',
        'card_type',
        'transaction_id',
        'amount',
        'account_id',
        'user_id',
        'status',
    ];

    /**
     * Get the account that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account(): BelongsTo {
        return $this->belongsTo( Account::class );
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }
    
    /**
     * Get the teacher that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo{
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
}
