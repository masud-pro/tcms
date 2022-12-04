<?php

namespace App\Http\Livewire\Role;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolePermission extends Component {

    /**
     * @var mixed
     */
    public $roles; // all roles
    /**
     * @var mixed
     */
    public $permission; // permission from role

    /**
     * @var mixed
     */
    public $role; // role selected
    /**
     * @var string
     */
    public $permissions; // selected permissions

    /**
     * @var array
     */
    protected $queryString = [
        "role" => ["except" => ""],
    ];

    public function updatedRole() {
        dd( $this->permissions );
    }

    /**
     * @return mixed
     */
    public function checkedAll() {

        if ( $this->permissions == true ) {
            return $this->permissions = [];
        }

        if ( $this->permissions == false ) {

            $this->permissions = [
                'courses.index'               => true,
                'courses.create'              => true,
                'courses.edit'                => true,
                'courses.destroy'             => true,
                'courses.archived'            => true,
                'courses.authorization_panel' => true,
                'courses.authorize_users'     => true,

                'student.index',
                'student.create',
                'student.edit',
                'student.destroy',

                'feed.create',
                'feed.edit',
                'feed.destroy',
                'feed.create_link',
                'feed.edit_link',
                'feed.destroy_link',

                'exam_question.index',
                'exam_question.create',
                'exam_question.edit',
                'exam_question.destroy',
                'exam_question.assigned_course',

                'attendance.course_students',
                'attendance.individual_students',

                'accounts.update',
                'accounts.course_update',
                'accounts.overall_user_account',
                'accounts.individual_student',

                'transactions.user_online_transactions',

                'file_manager.individual_teacher',

                'settings.individual_teacher',
            ];
        }

        // dd( $this->permissions[0] == 'courses.index' );
    }

    public function submit() {

        dd( $this->permissions );
        // // dd($permissions);

    }

    public function mount() {
        $this->roles = Role::all();

        if ( !$this->role ) {
            $this->permission = [];

        } else {

            $role = Role::find( $this->role );

            $this->permission = $role->permissions->pluck( 'name' )->toArray();

        }
    }

    public function render() {

        return view( 'livewire.role.role-permission' );

    }
}
