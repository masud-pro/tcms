<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('ms.role.index' );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('ms.role.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request ) {
        $roleData = $request->validate( [
            'name'       => ['required', 'string', 'unique:roles'],
            'guard_name' => ['required'],
        ] );

        Role::create( $roleData );

        return redirect()->route( 'role.index' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id ) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $role ) {

        $role = Role::findOrFail( $role );

        return view( 'ms.role.edit', compact( 'role' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $role ) {

// return $request;
        
        $role = Role::findOrFail( $role );

        $roleData = $request->validate( [
            'name'        => ['required', 'unique:roles,name,'.$role->id],
            'guard_name' => ['required'],
        ] );

        $role->update($roleData);
        
        return redirect()->route( 'role.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id ) {
        //
    }

    public function rolePermission()
    {
     return view('ms.role.rolePermission');
    }
}