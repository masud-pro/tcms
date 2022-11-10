<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AdministratorStoreRequest;

class AdministratorController extends Controller {
    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request ) {
        $administrators = User::where( 'role', 'Admin' )->get();

        // return $administrators;

        return view('ms.administrator.index', compact( 'administrators' ) );
    }

    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request ) {
        $user = User::find( $id );

        return view( 'ms.administrator.create', compact( 'user' ) );
    }

    /**
     * @param  \App\Http\Requests\AdministratorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdministratorStoreRequest $request ) {
        $user = User::create( $request->validated() );

        return redirect()->route( 'administrator.show', ['administrator' => $administrator] );
    }
}