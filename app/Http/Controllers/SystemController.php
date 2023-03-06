<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller {

    public function dashboard() {
        $authUser = Auth::user();

        if ( $authUser->hasRole( ['Teacher', 'Super Admin'] ) ) {
            $emoji = getTeacherSetting( 'emoji_visibility' )->value;
            return view( 'dashboard', ["emoji" => $emoji] );
        } else {
            $emoji = getTeacherSetting( 'emoji_visibility' )->value;
            return view( 'dashboard', ["emoji" => $emoji] );
        }

    }

    public function teacherRegister() {
        return view( 'ms.register.subscriber-register' );
    }

}