<?php

namespace App\Http\Livewire\Students;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Notifications\User\UserStatusUpdateNotification;

class AllStudents extends Component {

    use WithPagination;
    
    protected $queryString = [
        "q"    => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $q;

    public function change_status( User $user, $user_status ) {
        if ( $user_status == 1 ) {
            $user->update( [
                'is_active' => 0,
            ] );

            $user->notify( new UserStatusUpdateNotification( 0 ) );
        } else {
            $user->update( [
                'is_active' => 1,
            ] );

            $user->notify( new UserStatusUpdateNotification( 1 ) );
        }

        session()->flash( 'status', 'Status Changed Successfully' );
    }

    public function render() {

        $users = Auth::user()->students()->whereHas( 'roles', function ( $query ) {
                                    $query->where( 'name', 'Student' );
                                } )
                             ->with( 'course' )
                             ->filter( $this->q )
                             ->latest()
                             ->paginate( 20 );

        return view( 'livewire.students.all-students', compact( 'users' ) );
    }
}
