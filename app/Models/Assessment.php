<?php

namespace App\Models;

use App\Http\Controllers\AssignmentController;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'start_time',
        'deadline',
        'is_accepting_submission',
        // 'submit_count',
        'course_id',
        'assignment_id',
    ];

    /**
     * The user that belong to the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany {
        return $this->belongsToMany( User::class );
    }

    /**
     * Get the assignment that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignment(): BelongsTo {
        return $this->belongsTo( Assignment::class );
    }

    /**
     * Get the course that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo {
        return $this->belongsTo( Course::class );
    }

    /**
     * Get all of the responses for the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses(): HasMany {
        return $this->hasMany( AssignmentResponse::class );
    }

    /**
     * Get all of the files for the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany {
        return $this->hasMany( AssignmentFile::class );
    }

}
