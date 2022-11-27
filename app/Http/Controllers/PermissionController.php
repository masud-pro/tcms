<?php

namespace App\Http\Controllers;

class PermissionController extends Controller {
    
    public function index() {
        return view( 'ms.permission.index' );
    }

    //
    public function create() {
        return view('ms.permission.create' );
    }
}
