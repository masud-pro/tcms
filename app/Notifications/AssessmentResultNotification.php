<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssessmentResultNotification extends Notification implements ShouldQueue {
    use Queueable;

    public $result;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($result) {
        $this->result = $result;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via( $notifiable ) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail( $notifiable ) {
        return ( new MailMessage )
            ->subject( 'Aseessment has ' . $this->result['name'] . ' been graded' )
            ->line( 'Aseessment has ' . $this->result['name'] . ' been graded' )
            ->line( 'Your Result is ' . $this->result['marks'] . ' out of ' . $this->result['fullmarks'] )
            ->action( 'Check Result', url( $this->result['url'] ) )
            ->line( 'Thank you!' );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray( $notifiable ) {
        return [
            //
        ];
    }
}
