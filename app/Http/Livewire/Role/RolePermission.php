<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermission extends Component {

    public function render() {
        $roles      = Role::all();
        $permission = Role::find( 2 );

        $b = $permission->permissions->pluck('name')->toArray();
        
        // dd($roles2);

        $g = in_array( 'courses.index', $b );

        // dd( $g );

        return view( 'livewire.role.role-permission', compact( 'roles', 'b' ) );
    }
}