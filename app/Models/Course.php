<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Attendance;
use App\Models\Feed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
    ];

    /**
     * The usser that belong to the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user(): BelongsToMany {
        return $this->belongsToMany( User::class )->withPivot("is_active");
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

}
