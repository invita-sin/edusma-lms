<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    public function findOrCreate(int $courseId, int $teacherId, int $studentId): Conversation
    {
        return Conversation::firstOrCreate([
            'course_id' => $courseId,
            'teacher_id' => $teacherId,
            'student_id' => $studentId,
        ]);
    }

    public function sendMessage(Conversation $conversation, string $message, string $senderType): Message
    {
        $userId = Auth::id();
        if (!$userId) {
            throw new \RuntimeException('User must be authenticated to send a message');
        }

        $msg = $conversation->messages()->create([
            'sender_id' => $userId,
            'sender_type' => $senderType,
            'message' => $message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        return $msg;
    }

    public function markAsRead(Conversation $conversation): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        $conversation->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function getTeacherConversations(int $teacherId)
    {
        return Conversation::with([
            'course:id,name',
            'student:id,user_id',
            'student.user:id,name',
            'messages' => fn($q) => $q->latest()->limit(1),
        ])
            ->where('teacher_id', $teacherId)
            ->orderByDesc('last_message_at')
            ->get();
    }

    public function getStudentConversations(int $studentId)
    {
        return Conversation::with([
            'course:id,name',
            'teacher:id,user_id',
            'teacher.user:id,name',
            'messages' => fn($q) => $q->latest()->limit(1),
        ])
            ->where('student_id', $studentId)
            ->orderByDesc('last_message_at')
            ->get();
    }

    public function getMessages(Conversation $conversation)
    {
        return $conversation->messages()
            ->with('sender:id,name')
            ->orderBy('created_at')
            ->get();
    }

    public function getUnreadCount(int $userId, ?int $teacherId = null, ?int $studentId = null): int
    {
        return Message::whereHas('conversation', function ($q) use ($teacherId, $studentId) {
            if ($teacherId) {
                $q->where('teacher_id', $teacherId);
            }
            if ($studentId) {
                $q->where('student_id', $studentId);
            }
        })
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }
}
