<?php

namespace App\Jobs\Message;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\SMSController;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sms;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $sms ) {
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        logger($this->sms['number']);
        SMSController::send_sms( $this->sms['number'], $this->sms['message'] );
    }
}