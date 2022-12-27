<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'status',
    ];

    
    /**
     * @param $query
     * @param $search
     */
    public function scopeFilter( $query, $search ) {
        $query->when( $search, function ( $filter, $search ) {
            $filter->where( 'name', 'like', "%" . $search . "%" )
                   ->orWhere( 'id', 'like', "%" . $search . "%" );
        } );
    }


    /**
     * Get the assignment that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }

    
    /**
     * Get the assignment that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo {
        return $this->belongsTo( Subscription::class );
    }

    
}