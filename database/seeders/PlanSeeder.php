<?php

namespace Database\Seeders;

use App\Models\Subscription;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // free plan for all trial users
        Subscription::truncate();

        $plan = [

            'id'               => 1,
            'name'             => 'Free Trial',
            'price'            => 0.00,
            'selected_feature' => 'accounts.course_update,accounts.individual_student,accounts.overall_user_account,accounts.update,attendance.course_students,attendance.individual_students,courses.archived,courses.authorization_panel,courses.authorize_users,courses.create,courses.destroy,courses.edit,courses.index,exam_question.assigned_course,exam_question.create,exam_question.destroy,exam_question.edit,exam_question.index,feed.create,feed.create_link,feed.destroy,feed.edit,feed.edit_link,feed.index,file_manager.individual_teacher,settings.individual_teacher,student.create,student.destroy,student.edit,student.index,transactions.user_online_transactions',
            'months'           => 1,

        ];

        Subscription::create( $plan );
    }
}
