<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermission extends Component {

    /**
     * @var mixed
     */
    public $checkedAll, $allRoles, $selectedRole, $allPermissions; // all permissions
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
    public $tempSelected = []; // temporary data for select all

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
            $this->tempSelected = [];
            session()->flash( 'updated', 'Role permission modified successfully.' );
        } else {
            $role->givePermissionTo( $this->selectedPermissions );
            $this->tempSelected = [];
            session()->flash( 'created', 'Permission assigned successfully.' );
        }

    }

    public function clearSelected() {
        $this->selectedPermissions = [];
        $this->checkedAll          = false;
    }

    /**
     * @return mixed
     */
    public function updatedCheckedAll() {

        if ( $this->checkedAll ) {
            $this->tempSelected        = $this->selectedPermissions;
            $this->selectedPermissions = Permission::pluck( 'name' )->toArray();
        } else {
            $this->selectedPermissions = $this->tempSelected;
            $this->tempSelected        = [];
        }

    }

    public function render() {

        return view( 'livewire.role.role-permission' );

    }
}