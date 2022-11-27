<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component {

    
    public function render() {
        
        $roles = Role::all();
        return view('livewire.permission.index', compact( 'roles' ) );
    }
}