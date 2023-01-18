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

// End of Helper Functions
