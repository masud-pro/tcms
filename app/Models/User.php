<?php

namespace App\Models;

use App\Models\Assessment;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable {
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'course_id',
        'role',
        'dob',
        'gender',
        'reg_no',
        'roll',
        'class',
        'waiver',
        'phone_no',
        'fathers_name',
        'fathers_phone_no',
        'mothers_name',
        'mothers_phone_no',
        'address',
        'is_active',
        'teacher_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The course that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function course(): BelongsToMany {
        return $this->belongsToMany( Course::class )->withPivot( "is_active" );
    }

    /**
     * Get all of the all of the course for the
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addedCourses(): HasMany {
        return $this->hasMany( Course::class, 'teacher_id' );
    }

    /**
     * Get all of the payment for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment(): HasMany {
        return $this->hasMany( Account::class );
    }

    /**
     * Get all of the attendance for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendance(): HasMany {
        return $this->hasMany( Attendance::class );
    }

    /**
     * The assessment that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assessment(): BelongsToMany {
        return $this->belongsToMany( Assessment::class );
    }

    // Account filter methods for super admin endpoint
    /**
     * @param $query
     */
    public function scopeFilter( $query, $search ) {
        $query->when( $search, function ( $filter, $search ) {
            $filter->where( 'name', 'like', "%" . $search . "%" )
                   ->orWhere( 'id', 'like', "%" . $search . "%" );
        } );
    }

    /**
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany {
        return $this->hasMany( User::class, 'teacher_id', 'id' );
    }

    /**
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teacher(): BelongsTo {
        return $this->belongsTo( User::class, 'id', 'teacher_id' );
    }

    /**
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings(): HasMany {
        return $this->hasMany( Setting::class );
    }

    /**
     * Get the assignment that owns the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription() {
        return $this->hasOne( SubscriptionUser::class );
    }

    /**
     * Get the info associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function teacherInfo(): HasOne{
        return $this->hasOne(TeacherInfo::class);
    }

}
