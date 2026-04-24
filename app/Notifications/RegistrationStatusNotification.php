<?php

namespace App\Notifications;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistrationStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $registration;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Registration $registration, string $status)
    {
        $this->registration = $registration;
        $this->status = $status;
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
        $statusText = $this->status === 'approved' ? 'ACCEPTED ✅' : 'REJECTED ❌';

        $mail = (new MailMessage)
                    ->subject("Registration Status Update: {$eventTitle}")
                    ->greeting("Hello, {$notifiable->name}!")
                    ->line("![University Logo](https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef.png)")
                    ->line("Your registration request for the event \"{$eventTitle}\" has been {$statusText}.");

        if ($this->status === 'approved') {
            $mail->line("Congratulations! Please find your official entry ticket attached to this email.")
                 ->line("You can also view your digital ticket anytime in your student dashboard.")
                 ->action('View My Dashboard', url('/dashboard'));

            // Generate PDF Ticket for Attachment
            $qrCode = base64_encode(QrCode::format('png')->size(200)->color(0, 0, 0)->generate(url('/admin/registrations?search=' . $this->registration->id)));
            
            $pdf = Pdf::loadView('user.applications.ticket-pdf', [
                'registration' => $this->registration,
                'qrCode' => $qrCode
            ]);

            $mail->attachData($pdf->output(), "Official_Ticket_{$this->registration->id}.pdf", [
                'mime' => 'application/pdf',
            ]);
        } else {
            $mail->line("We regret to inform you that we cannot accommodate your registration at this time.")
                 ->line("Feel free to explore other upcoming events on our platform.");
        }

        $mail->line('Thank you for choosing the University of El Oued!')
             ->salutation('Official Event Management System');
             
        return $mail;
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
            'status' => $this->status,
            'message' => "Your registration for \"{$this->registration->event->title}\" was {$this->status}.",
            'icon' => $this->status === 'approved' ? 'bi-check-circle-fill' : 'bi-x-circle-fill',
            'type' => $this->status === 'approved' ? 'success' : 'danger',
        ];
    }
}
