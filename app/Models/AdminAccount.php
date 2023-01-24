<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminAccount extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'subscription_user_id',
        'total_price',
        'to_date',
        'from_date',
        'purpose',
        'status',
    ];

    /**
     * @param $query
     * @param $search
     */
    public function scopeFilter( $query, $search ) {
        $query->when( $search, function ( $query, $search ) {
            $query->whereHas( 'subscriptionUser.user', function ( $query ) use ( $search ) {
                $query->where( 'name', 'like', "%" . $search . "%" );
            } )->orWhereHas( 'subscriptionUser.subscription', function ( $query ) use ( $search ) {
                $query->where( 'name', 'like', "%" . $search . "%" );
            } );
        } );
    }

    /**
     * Get the assignment that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscriptionUser(): BelongsTo {
        return $this->belongsTo( SubscriptionUser::class );
    }
}