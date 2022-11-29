<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolePermission extends Component {

    /**
     * @var mixed
     */
    public $checks = [];

    /**
     * @return mixed
     */
    public function updatedChecks() {
        // dump( $this->checks );

        // return $this->checks[2] = true;
    }

    public function selectAll() {
        // dd( $this->checks );
        // foreach ( $this->checks as $check ) {
        //     $this->checks[$check] = true;
        // }
    }

    public function render() {
        $roles = Role::all();
        return view( 'livewire.role.role-permission', compact( 'roles' ) );
    }
}