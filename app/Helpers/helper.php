<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Option;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

// Start Functions
/**
 * only teacher can access those options from sidebar.
 * @param Type $var
 */
function hasCourseAccess()
{
    return Auth::user()->can([
        'courses.index',
        'courses.create',
        'courses.edit',
        'courses.destroy',
        'courses.archived',
        'courses.authorization_panel',
        'courses.authorize_users',
    ]) && (Auth::user()->hasRole(['Teacher']));
    // auth()->user()->can('edit articles');
}

/**
 * @param $username
 */
function getToBeSubdomain($username)
{
    return str_replace('://', '://' . $username . '.', config('app.url'));
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
function hasStudentAccess()
{
    return Auth::user()->can([
        'student.index',
        'student.create',
        'student.edit',
        'student.destroy',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasExamQuestionAccess()
{
    return Auth::user()->can([
        'exam_question.index',
        'exam_question.create',
        'exam_question.edit',
        'exam_question.destroy',
        'exam_question.assigned_course',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasAttendanceAccess()
{
    return Auth::user()->can([
        'attendance.course_students',
        'attendance.individual_students',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasAccountAccess()
{
    return Auth::user()->can([
        'accounts.update',
        'accounts.course_update',
        'accounts.overall_user_account',
        'accounts.individual_student',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasTransactionsAccess()
{
    return Auth::user()->can([
        'transactions.user_online_transactions',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasMassageAccess()
{
    return Auth::user()->can([
        'file_manager.individual_teacher',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * only teacher can access those options from sidebar.
 */
function hasFileManagerAccess()
{
    return Auth::user()->can(['file_manager.individual_teacher']);
}

function isSuperAdmin()
{
    return Auth::user()->hasRole(['Super Admin']);
}

/**
 * only teacher can access those options with renew from sidebar.
 */
function hasSettingAccess()
{
    return Auth::user()->can([
        'settings.individual_teacher',
    ]) && (Auth::user()->hasRole(['Teacher']));
}

/**
 * @param $data
 */
function getTeacherSetting($settingSlug, $user = null)
{

    $optionId = Option::where("slug", $settingSlug)->first()->id;

    if (!$user) {
        if (auth()->user()->hasRole(['Teacher'])) {
            $user = auth()->user();
        } elseif (auth()->user()->hasRole(['Student'])) {
            $user = auth()->user()->teacher;
        } else {
            $user = auth()->user();
        }
    }

    return $user->load('settings.option')->settings->where("option_id", $optionId)->first();
}

/**
 * @param $settingSlug
 * @param $teacherId
 */
function setTeacherSetting($settingSlug, $teacherId)
{
    $optionId = Option::where("slug", $settingSlug)->first()->id;

    $user = User::find($teacherId);

    return Setting::where('user_id', $user->id)->where('option_id', $optionId)->update([
        'value' => 0,
    ]);
}

/**
 * @param  $ap_key
 * @param  $sender_id
 * @param  $mobile_no
 * @param  $message
 * @param  $user_email
 * @return mixed
 */
function techno_bulk_sms($ap_key, $sender_id, $mobile_no, $message, $user_email)
{
    $url  = 'https://24bulksms.com/24bulksms/api/api-sms-send';
    $data = [
        'api_key' => $ap_key,
        'sender_id'        => $sender_id,
        'message'          => $message,
        'mobile_no'        => $mobile_no,
        'user_email'       => $user_email,
    ];

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

/**
 * @return mixed
 */
function getSubdomain()
{
    $subdomain = explode('.', $_SERVER['HTTP_HOST'])[0];
    return $subdomain;
}

/**
 * @param $course
 */
function generate_payments($course)
{

    if ($course->should_generate_payments === 0) {
        return false;
    }

    $students   = $course->user;
    $newAccount = [];

    foreach ($students as $student) {

        if ($student->is_active == 1) {

            $newAccount[] = [
                'user_id'     => $student->id,
                'course_id'   => $course->id,
                'paid_amount' => $student->waiver ? $course->fee - $student->waiver : $course->fee,
                'status'      => "Unpaid",
                'month'       => Carbon::today(),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
        }
    }

    Account::insert($newAccount);

    return true;
}

function getSubdomainUser()
{
    return User::whereHas('teacherInfo', function ($query) {
        $query->where('username', getSubdomain());
    })->first();
}

/**
 * @return mixed
 */
function getUserFileManagerFolder()
{
    $user = auth()->user();
    if ($user->hasRole('Teacher')) {
        return $user->teacherInfo->username;
    } else {
        return $user->id;
    }
}

/**
 * Get username of the teacher the user is associated with
 */
function getUsername()
{
    $user = auth()->user();
    if ($user->hasRole('Teacher')) {
        return $user->teacherInfo->username;
    } else {
        return $user->teacher->teacherInfo->username;
    }
}

// End of Helper Functions