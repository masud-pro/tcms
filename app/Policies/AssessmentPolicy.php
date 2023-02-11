<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AssessmentPolicy {
    use HandlesAuthorization;

    public function before( User $user ) {

        if ( $user->role == "Admin" ) {
            return true;
        }

    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny( User $user ) {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view( User $user, Assessment $assessment ) {
        return true;
        // return in_array( $user->id, $assessment
        //         ->user()
        //         ->with( 'assessment' )
        //         ->get()
        //         ->pluck( 'id' )
        //         ->toArray() );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create( User $user ) {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update( User $user, Assessment $assessment ) {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete( User $user, Assessment $assessment ) {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore( User $user, Assessment $assessment ) {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Assessment  $assessment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete( User $user, Assessment $assessment ) {
        //
    }

}
