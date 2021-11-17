<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'attendance',
        'date',
    ];

    /**
     * Get the user that owns the Attendance
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
        $attendances = Attendance::when( $this->date, function () {

        } )->get();
        return $this->belongsTo( Course::class );
    }
}
