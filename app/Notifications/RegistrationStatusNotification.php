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
        $qrCodeRaw = QrCode::format('svg')->size(200)->color(0, 0, 0)->generate(url('/admin/registrations?search=' . $this->registration->id));
        $qrCodeBase64 = base64_encode($qrCodeRaw);
        
        $mail = (new MailMessage)
                    ->subject("Registration Status Update: {$eventTitle}")
                    ->view('emails.registration-status', [
                        'user' => $notifiable,
                        'registration' => $this->registration,
                        'status' => $this->status,
                        'qrCode' => $qrCodeBase64
                    ]);

        if ($this->status === 'approved') {
            // Generate PDF Ticket for Attachment
            $pdf = Pdf::loadView('user.applications.ticket-pdf', [
                'registration' => $this->registration,
                'qrCode' => $qrCodeBase64
            ]);

            $mail->attachData($pdf->output(), "Official_Ticket_{$this->registration->id}.pdf", [
                'mime' => 'application/pdf',
            ]);
        }
             
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
