<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermission extends Component {

    /**
     * @var mixed
     */
    public $allRoles; // all roles
    /**
     * @var mixed
     */
    public $selectedRole; // selected role

    /**
     * @var mixed
     */
    public $allPermissions; // all permissions
    /**
     * @var string
     */
    public $selectedPermissions; // selected permissions

    /**
     * @var mixed
     */
    public $allChecked; // all checked permissions

    /**
     * @var array
     */
    protected $queryString = [
        'selectedRole' => ['except' => '', 'as' => 'role'],
    ];

    /**
     * @return mixed
     */
    public function mount() {
        $this->allRoles = Role::all();

        $this->populateFields();

        $this->allChecked = count( Permission::all() );
    }

    public function updatedSelectedRole() {
        $this->populateFields();
    }

    public function populateFields() {

        if ( $this->selectedRole == true ) {
            $role                      = $this->allRoles->where( 'id', $this->selectedRole )->first();
            $this->allPermissions      = $role->permissions->pluck( 'name' )->toArray();
            $this->selectedPermissions = $this->allPermissions;
        } else {
            $this->allPermissions      = [];
            $this->selectedPermissions = [];
        }

    }

    //
    public function submit() {

        $role = Role::find( $this->selectedRole );

        if ( $role->permissions == true ) {

            $role->syncPermissions( $this->selectedPermissions );

            session()->flash( 'updated', 'Role permission modified successfully.' );
        } else {
            $role->givePermissionTo( $this->selectedPermissions );
            session()->flash( 'created', 'Permission assigned successfully.' );
        }

    }

    /**
     * @return mixed
     */
    public function checkedAll() {

        // dd($this->selectedPermissions);

        // if ($this->selectedPermissions == true) {
        //     $this->selectedPermissions = Permission::pluck( 'name' );
        // }

        if ( $this->selectedPermissions == true ) {
            return $this->selectedPermissions = [];
        }

        if ( $this->selectedPermissions == false ) {

            $this->selectedPermissions = Permission::pluck( 'name' );
        }

    }


    public function render() {

        return view( 'livewire.role.role-permission' );

    }
}