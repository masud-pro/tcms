<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeacherInfo;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministratorStoreRequest;

class AdministratorController extends Controller {
    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {

        return view( 'ms.administrator.index' );
    }

    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $roles = Role::WhereNotIn( 'name', ['Student'] )->get();

        return view( 'ms.administrator.create', compact( 'roles' ) );
    }

    /**
     * @param  \App\Http\Requests\AdministratorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdministratorStoreRequest $request ) {

        // return $request->all();

        $user = User::query();

        $userData['name']     = $request->name;
        $userData['email']    = $request->email;
        $userData['phone_no'] = $request->phone_no;
        $userData['dob']      = $request->dob;
        $userData['gender']   = $request->gender;
        $userData['address']  = $request->address;
        $userData['password'] = Hash::make( $request->password );

        $user = $user->create( $userData );

        $teacherData['curriculum']     = $request->curriculum;
        $teacherData['institute']      = $request->institute;
        $teacherData['teaching_level'] = $request->teaching_level;
        $teacherData['user_id']        = $user->id;

        TeacherInfo::create( $teacherData );

        $user->assignRole( $request->user_role );

        return redirect()->route( 'administrator.index' );
    }
}
