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
        'selected_feature',
        'months',
    ];

    public function scopeFilter( $query, $search ) {
        $query->when( $search, function ( $filter, $search ) {
            $filter->where( 'name', 'like', "%" . $search . "%" )
                   ->orWhere( 'id', 'like', "%" . $search . "%" );
        } );
    }
}