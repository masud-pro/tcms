<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SMS extends Model {
    use HasFactory;

    protected $fillable = [
        'for',
        'count',
        'message',
        'course_id',
    ];

    /**
     * Get all of the course for the SMS
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course(): BelongsTo {
        return $this->belongsTo( Course::class );
    }
}
