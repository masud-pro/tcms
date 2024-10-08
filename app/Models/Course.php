<?php

namespace App\Models;

use App\Models\Feed;
use App\Models\Account;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model {
    use HasFactory, SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        "teacher_id",
        "name",
        "description",
        "class_link",
        "fee",
        "type",
        "time",
        "capacity",
        "section",
        "subject",
        "room",
        "address",
        "image",
        "should_generate_payments",
    ];

    /**
     * The usser that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany {
        return $this->belongsToMany( User::class )->withPivot( "is_active" );
    }

    /**
     * Get the teacher that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id', 'id');
    }
    
    /**
     * The user that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instructors() {
        return $this->belongsTo( User::class );
    }

    /**
     * Get all of the feeds for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds(): HasMany {
        return $this->hasMany( Feed::class );
    }

    /**
     * Get all of the attendance for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance(): HasMany {
        return $this->hasMany( Attendance::class );
    }

    /**
     * Get all of the account for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account(): HasMany {
        return $this->hasMany( Account::class );
    }

    /**
     * Get all of the assessment for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessment(): HasMany {
        return $this->hasMany( Assessment::class );
    }

}
