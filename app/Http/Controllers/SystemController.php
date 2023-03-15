<?php

namespace App\Http\Controllers;

use App\Models\TeacherInfo;
use Illuminate\Support\Facades\Auth;

class SystemController extends Controller {

    public function dashboard() {
        $authUser = Auth::user();
        $appName  = env( 'APP_NAME' );

        if ( $authUser->hasRole( ['Super Admin'] ) ) {

            $emoji = getTeacherSetting( 'emoji_visibility' )->value;
            return view( 'dashboard', ["emoji" => $emoji, "appName" => $appName] );

        } elseif ( $authUser->hasRole( ['Teacher'] ) ) {

            $emoji = getTeacherSetting( 'emoji_visibility' )->value;
            return view( 'dashboard', ["emoji" => $emoji, "appName" => $appName] );

        } else {
            $teacherBusinessInstituteName = TeacherInfo::where( 'user_id', $authUser->teacher_id )->first()->business_institute_name;
            $emoji                        = getTeacherSetting( 'emoji_visibility' )->value;
            return view( 'dashboard', ["emoji" => $emoji, 'teacherBusinessInstituteName' => $teacherBusinessInstituteName, "appName" => $appName] );
        }

    }

    public function teacherRegister() {
        return view( 'ms.register.subscriber-register' );
    }

}