<?php

use App\Models\Option;
use Illuminate\Support\Facades\Auth;

// Start Functions
/**
 * only teacher can access those options from sidebar.
 * @param Type $var
 */
function hasCourseAccess() {
    return Auth::user()->can(
        ['courses.index',
            'courses.create',
            'courses.edit',
            'courses.destroy',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
        ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
    // auth()->user()->can('edit articles');
}


function getToBeSubdomain($username){
    return str_replace( '://', '://'. $username . '.', config('app.url') );
}

// 'courses.index',
// 'courses.archived',
// 'courses.authorization_panel',
// 'courses.authorize_users',
// 'courses.reauthorize_users',
// 'courses.create',
// 'courses.edit',
// 'courses.update',
// 'courses.destroy',
/**
 * only teacher can access those options from sidebar.
 */
function hasStudentAccess() {
    return Auth::user()->can( [
        'student.index',
        'student.create',
        'student.edit',
        'student.destroy',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasExamQuestionAccess() {
    return Auth::user()->can( [
        'exam_question.index',
        'exam_question.create',
        'exam_question.edit',
        'exam_question.destroy',
        'exam_question.assigned_course',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasAttendanceAccess() {
    return Auth::user()->can( [
        'attendance.course_students',
        'attendance.individual_students',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasAccountAccess() {
    return Auth::user()->can( [
        'accounts.update',
        'accounts.course_update',
        'accounts.overall_user_account',
        'accounts.individual_student',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasTransactionsAccess() {
    return Auth::user()->can( [
        'transactions.user_online_transactions',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasMassageAccess() {
    return Auth::user()->can( [
        'file_manager.individual_teacher',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options from sidebar.
 */
function hasFileManagerAccess() {
    return Auth::user()->can( [
        'file_manager.individual_teacher',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * only teacher can access those options with renew from sidebar.
 */
function hasSettingAccess() {
    return Auth::user()->can( [
        'settings.individual_teacher',
    ] ) && ( Auth::user()->hasRole( ['Teacher'] ) );
}

/**
 * @param $data
 */
function getSettingValue( $data ) {
    // dd( $data );

    $optionId = Option::where( "slug", $data )->first()['id'];

    return Auth::user()->load( 'settings.option' )->settings->where( "option_id", $optionId )->first();
}


function techno_bulk_sms($ap_key,$sender_id,$mobile_no,$message,$user_email){
    $url = 'https://24bulksms.com/24bulksms/api/api-sms-send';
    $data = array('api_key' => $ap_key,
     'sender_id' => $sender_id,
     'message' => $message,
     'mobile_no' =>$mobile_no,
     'user_email'=> $user_email		
     );

    // use key 'http' even if you send the request to https://...
     $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
    $output = curl_exec($curl);
    curl_close($curl);
    return $output; 
}

// End of Helper Functions
