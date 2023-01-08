<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model {
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'option_id',
        'value',
    ];

    /**
     * The Setting that belong to the Option
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option(): BelongsTo {
        return $this->belongsTo( Option::class, );
    }

    /**
     * The Setting that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(): BelongsTo {
        return $this->belongsTo( User::class );
    }
}