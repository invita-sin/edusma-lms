<?php

namespace App\Notifications;

use App\Models\AssignmentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionGradedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public AssignmentSubmission $submission,
    ) {
        $this->submission->load('assignment');
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Tugas Telah Dinilai')
            ->greeting('Halo ' . $notifiable->name)
            ->line('Tugas "' . $this->submission->assignment->title . '" telah dinilai.')
            ->line('Nilai: ' . ($this->submission->score ?? '-'))
            ->action('Lihat Detail', url('/student/assignments/' . $this->submission->assignment_id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'assignment_id' => $this->submission->assignment_id,
            'title' => $this->submission->assignment->title,
            'score' => $this->submission->score,
        ];
    }
}
