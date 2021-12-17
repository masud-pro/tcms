<?php

namespace App\Jobs\Result;

use App\Http\Controllers\SMSController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResultSMS implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $result;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $result ) {
        $this->result = $result;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        SMSController::send_sms( $this->result['number'], $this->result['message'] );
    }
}
