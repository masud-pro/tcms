<?php

namespace App\Http\Livewire\Students;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AllStudents extends Component {

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        "q"    => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $q;

    public function change_status( User $user, $user_status ) {
        if( $user_status == 1 ){
            $user->update([
                'is_active' => 0,
            ]);
        }else{
            $user->update([
                'is_active' => 1,
            ]);
        }

        session()->flash('success','Status Changed Successfully');
    }

    public function render() {
        return view( 'livewire.students.all-students', [
            "users" => User::with( 'course' )->where( "role", "student" )->when( $this->q, function ( $query, $q ) {
                return $query->where( 'name', 'like', "%" . $q . "%" );
            } )->latest()->paginate( 15 ),
        ] );
    }
}
