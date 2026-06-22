<?php

namespace App\Notifications;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuizAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Quiz $quiz,
    ) {
        $this->quiz->load('course');
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Quiz Baru: ' . $this->quiz->title)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Quiz "' . $this->quiz->title . '" telah tersedia.')
            ->when($this->quiz->time_limit, fn($msg) => $msg->line('Batas waktu: ' . $this->quiz->time_limit . ' menit'))
            ->action('Kerjakan Quiz', url('/student/quizzes/' . $this->quiz->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quiz_id' => $this->quiz->id,
            'title' => $this->quiz->title,
            'course' => $this->quiz->course->name,
        ];
    }
}
