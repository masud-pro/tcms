<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Account;
use Illuminate\Console\Command;
use App\Http\Controllers\AccountController;

class GeneratePayments extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Payments for all courses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $courses = Course::all( ["id", "fee"] );

        foreach ( $courses as $course ) {
            $accountsCount = Account::whereMonth( "month", Carbon::today() )->where( "course_id", $course->id )->count();

            if($accountsCount === 0){
                generate_payments( $course );
            }
        }
    }
}
