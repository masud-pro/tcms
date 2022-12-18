<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TeacherInfo;
use App\Jobs\DefaultSetting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Traits\DefaultSettingTraits;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministratorStoreRequest;

class AdministratorController extends Controller {

    use DefaultSettingTraits;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        return view('ms.administrator.index' );
    }

    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $roles = $this->roleName();

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

        // dd($user->id);
        // This job for create a new default setting;
        // dispatch( new DefaultSetting( $user->id ) );

        $this->defaultSetting( $user->id );

        return redirect()->route( 'administrator.index' );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User            $user
     * @return \Illuminate\Http\Response
     */
    public function edit( User $administrator ) {

        $roles = $this->roleName();

        if ( $administrator->hasRole( 'Super Admin' ) ) {

            return view( 'ms.administrator.super-admin-edit', compact( 'administrator', 'roles' ) );
        }

        $teacherInfo = TeacherInfo::where( 'user_id', $administrator->id )->get();

        // dd( $teacherInfo );

        return view( 'ms.administrator.edit', compact( 'administrator', 'teacherInfo', 'roles' ) );
    }

    public function roleName() {
        return Role::WhereNotIn( 'name', ['Student'] )->get();
    }

}
