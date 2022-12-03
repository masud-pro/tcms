<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolePermission extends Component {

    /**
     * @var mixed
     */
    public $role;
    /**
     * @var string
     */
    public $permissions = [];

    /**
     * @var array
     */
    protected $queryString = [
        "role" => ["except" => ""],
    ];

    // public function updatedRole() {

    //     // dd($this->role);

    //     $permission = Role::find( $this->role );

    //     $b = $permission->permissions->pluck( 'name' )->toArray();

    //     // dd($roles2);

    //     $g = in_array( 'courses.index', $b );

    //     // dd( $g );
    // }

    /**
     * @return mixed
     */
    public function checkedAll() {

        if ( $this->permissions == true ) {
            return $this->permissions = [];
        }

        if ( $this->permissions == false ) {

            $this->permissions = ['courses.index'];
        }

        // dd( $this->permissions[0] == 'courses.index' );
    }

    public function submit() {
        // $this->validate();

        dd( $this->permissions );

        // $permissions = array($this->courses);

        // // dd($permissions);

        // // Execution doesn't reach here if validation fails.

        // foreach ( $permissions as $permission ) {

        //     dd($permission);
        //     Permission::create( [
        //         'name' => $this->courses.$permission,
        //     ] );
        // }

        // dd($this->courses);
    }

    public function mount() {
        # code...
    }

    public function render() {

        $roles = Role::all();

        $userId = $this->role;

        // dd($roles2);

        // $g = in_array( 'courses.index', $b );

        // dd( $g );

        if ( !$userId ) {
            $permission = [''];
            return view( 'livewire.role.role-permission', compact( 'roles', 'permission' ) );

        } else {

            $allPermission = Role::find( $this->role );

            $permission = $allPermission->permissions->pluck( 'name' )->toArray();

            return view( 'livewire.role.role-permission', compact( 'roles', 'permission' ) );
        }

    }
}