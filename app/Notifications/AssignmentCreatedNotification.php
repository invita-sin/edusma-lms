<?php

namespace App\Notifications;

use App\Models\Assignment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Assignment $assignment,
    ) {
        $this->assignment->load('course');
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tugas Baru: ' . $this->assignment->title)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Tugas baru telah dibuat: "' . $this->assignment->title . '".')
            ->line('Batas pengumpulan: ' . $this->assignment->due_date->format('d M Y H:i'))
            ->action('Lihat Tugas', url('/student/assignments/' . $this->assignment->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'assignment_id' => $this->assignment->id,
            'title' => $this->assignment->title,
            'course' => $this->assignment->course->name,
            'due_date' => $this->assignment->due_date->toDateTimeString(),
        ];
    }
}
