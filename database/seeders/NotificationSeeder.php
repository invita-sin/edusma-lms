<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereHas('roles', fn($q) => $q->whereIn('name', ['student', 'teacher']))->get();

        if ($users->isEmpty()) {
            return;
        }

        $notifications = [
            [
                'type' => 'App\Notifications\AssignmentCreatedNotification',
                'data' => ['title' => 'Tugas Baru', 'message' => 'Tugas Matematika telah tersedia. Batas: 2026-07-01'],
            ],
            [
                'type' => 'App\Notifications\SubmissionGradedNotification',
                'data' => ['title' => 'Nilai Tugas', 'message' => 'Tugas Anda telah dinilai: 85'],
            ],
            [
                'type' => 'App\Notifications\QuizAvailableNotification',
                'data' => ['title' => 'Quiz Baru', 'message' => 'Quiz Fisika tersedia sekarang. Durasi: 30 menit'],
            ],
        ];

        foreach ($users as $user) {
            foreach ($notifications as $notif) {
                DatabaseNotification::create([
                    'id' => Str::uuid(),
                    'type' => $notif['type'],
                    'notifiable_type' => User::class,
                    'notifiable_id' => $user->id,
                    'data' => $notif['data'],
                    'created_at' => now()->subMinutes(rand(1, 1440)),
                ]);
            }
        }

        $this->command->info('Sample notifications seeded for ' . $users->count() . ' users.');
    }
}
