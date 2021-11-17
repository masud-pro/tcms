<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feed extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'link',
        'post_to',
        'type',
        'course_id',
        'exam_id',
        'mcq_id',
    ];

    /**
     * Get the course that owns the Feed
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): BelongsTo {
        return $this->belongsTo( Course::class );
    }


}
