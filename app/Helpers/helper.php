<?php

use Illuminate\Support\Facades\Auth;

// Start Functions
/**
 * @param Type $var
 */
function hasCourseAccess() {
    return Auth::user()->can(
        [   'courses.index',
            'courses.archived',
            'courses.authorization_panel',
            'courses.authorize_users',
            'courses.reauthorize_users',
            'courses.create',
            'courses.edit',
            'courses.update',
            'courses.destroy',
    ] ) || ( Auth::user()->hasRole( ['Teacher' ,'Super Admin'] ) );
    // auth()->user()->can('edit articles');
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

// End of Helper Functions