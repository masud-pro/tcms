<?php

namespace App\Http\Livewire\Administrator;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Index extends Component {
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;

    protected $queryString = [
        "search"    => ['except' => ''],
        'page' => ['except' => 1],
    ];


    public function render() {
        $roles = Role::WhereNotIn( 'name', ['Student'] )->pluck( 'name' )->toArray();

        $administrators = User::role( $roles )->filter($this->search)->latest()->paginate( 20 );

        // return $administrators;
        return view( 'livewire.administrator.index', compact( 'administrators' ) );

    }
}