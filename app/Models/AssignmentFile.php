<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentFile extends Model {
    use HasFactory;

    protected $fillable = [
        'assessment_response_id',
        'assignment_id',
        'assessment_id',
        'name',
        'url',
    ];

    /**
     * Get the response that owns the AssignmentFile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function response(): BelongsTo {
        return $this->belongsTo( AssignmentResponse::class );
    }
}
