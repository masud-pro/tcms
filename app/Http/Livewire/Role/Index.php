<?php

namespace App\Http\Livewire\Role;

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
        
        $roles = Role::where( 'name', 'like', "%" . $this->search . "%" )->latest()->paginate( 20 );
        return view('livewire.role.index', compact( 'roles' ) );
    }
}
