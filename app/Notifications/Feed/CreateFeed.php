<?php

namespace App\Notifications\Feed;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateFeed extends Notification implements ShouldQueue {
    use Queueable;

    public $feed;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $feed ) {
        $this->feed = $feed;
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
            ->subject( 'New post added to ' . $this->feed['courseName'] )
            ->line( 'New post added to ' . $this->feed['courseName'] )
            ->action( 'Check post', url( $this->feed['url'] ) )
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
