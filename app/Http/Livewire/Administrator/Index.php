<?php

namespace App\Http\Livewire\Administrator;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use App\Notifications\User\UserStatusUpdateNotification;

class Index extends Component {
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;

    protected $queryString = [
        "search"    => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function change_status( User $user, $user_status ) {
        if( $user_status == 1 ){
            $user->update([
                'is_active' => 0,
            ]);

            $user->notify(new UserStatusUpdateNotification(0));
        }else{
            $user->update([
                'is_active' => 1,
            ]);

            $user->notify(new UserStatusUpdateNotification(1));
        }

        session()->flash('status','Status Changed Successfully');
    }


    public function render() {
        $roles = Role::WhereNotIn( 'name', ['Student'] )->pluck( 'name' )->toArray();

        $administrators = User::role( $roles )->filter($this->search)->latest()->paginate( 20 );

        // return $administrators;
        return view( 'livewire.administrator.index', compact( 'administrators') );

    }
}