<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationReceivedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $eventTitle = $this->registration->event->title;

        return (new MailMessage)
                    ->subject("Application Received: {$eventTitle}")
                    ->greeting("Hello, {$notifiable->name}!")
                    ->line("![University Logo](https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef.png)")
                    ->line("We have successfully received your application to participate in \"{$eventTitle}\".")
                    ->line("Our administration team is currently reviewing your request. You will be notified as soon as a decision is made.")
                    ->action('View My Applications', url('/my-applications'))
                    ->line('Thank you for choosing the University of El Oued!')
                    ->salutation('Official Event Management System');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'registration_id' => $this->registration->id,
            'event_title' => $this->registration->event->title,
            'status' => 'pending',
            'message' => "Your application for \"{$this->registration->event->title}\" has been received and is under review.",
            'icon' => 'bi-hourglass-split',
            'type' => 'warning',
        ];
    }
}
