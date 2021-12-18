<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignmentResponse extends Model {
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'assignment_id',
        'user_id',
        'answer',
        'marks',
        'is_marks_published',
        'submitted_at',
    ];

    /**
     * Get the assignment that owns the AssignmentResponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignment(): BelongsTo {
        return $this->belongsTo( Assignment::class );
    }

    /**
     * Get the user that owns the AssignmentResponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo( User::class );
    }

    /**
     * Get the assessment that owns the AssignmentResponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment(): BelongsTo {
        return $this->belongsTo( Assessment::class );
    }

    /**
     * Get all of the files for the AssignmentResponse
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany {
        return $this->hasMany( AssignmentFile::class, 'assignment_response_id' );
    }
}
