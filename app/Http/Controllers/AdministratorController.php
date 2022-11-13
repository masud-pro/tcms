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

        return view('ms.administrator.index' );
    }

    /**
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function create( ) {

        return view('ms.administrator.create' );
    }

    /**
     * @param  \App\Http\Requests\AdministratorStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store( AdministratorStoreRequest $request ) {
        $user = User::create( $request->validated() );

        // return redirect()->route( 'administrator.show', ['administrator' => $administrator] );
    }
}