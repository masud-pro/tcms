<?php

namespace App\Models;

use App\Models\Assessment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'question',
        'type',
        'marks',
    ];

    /**
     * Get all of the response for the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function response(): HasMany {
        return $this->hasMany( AssignmentResponse::class );
    }

    /**
     * Get the assessment that owns the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment(): HasMany {
        return $this->hasMany( Assessment::class );
    }

    /**
     * Get all of the files for the Assignment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany {
        return $this->hasMany( AssignmentFile::class, 'assignment_id' );
    }
}
