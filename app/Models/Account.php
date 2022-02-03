<?php

namespace App\Models;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'paid_amount',
        'status',
        'month',
        'name',
        'description',
    ];

    /**
     * Get the user that owns the Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }

    /**
     * Get the course that owns the Account
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo {
        return $this->belongsTo( Course::class );
    }
}
