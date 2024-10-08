<?php

namespace App\Notifications\Assessment;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateAssessment extends Notification implements ShouldQueue {
    use Queueable;

    public $assessment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $assessment ) {
        $this->assessment = $assessment;
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
            ->subject( 'New assessmnet published on ' . $this->assessment['courseName'] )
            ->line( 'Assessmnet published on ' . $this->assessment['courseName'] )
            ->action( 'View Assessmnet', url( $this->assessment['url'] ) )
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
