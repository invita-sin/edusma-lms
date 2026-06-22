<?php

namespace App\Providers;

use App\Models\AcademicYear;
use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Course;
use App\Models\Conversation;
use App\Models\Grade;
use App\Models\Major;
use App\Models\Material;
use App\Models\Quiz;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Policies\AcademicYearPolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\ClassroomPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\CoursePolicy;
use App\Policies\GradePolicy;
use App\Policies\MajorPolicy;
use App\Policies\MaterialPolicy;
use App\Policies\QuizPolicy;
use App\Policies\SemesterPolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());

        Gate::before(function (User $user) {
            return $user->hasRole('super-admin') ? true : null;
        });
        
        Gate::policy(AcademicYear::class, AcademicYearPolicy::class);
        Gate::policy(Semester::class, SemesterPolicy::class);
        Gate::policy(Conversation::class, ConversationPolicy::class);
        Gate::policy(Major::class, MajorPolicy::class);
        Gate::policy(Classroom::class, ClassroomPolicy::class);
        Gate::policy(Subject::class, SubjectPolicy::class);
        Gate::policy(Teacher::class, TeacherPolicy::class);
        Gate::policy(Student::class, StudentPolicy::class);
        Gate::policy(Course::class, CoursePolicy::class);
        Gate::policy(Material::class, MaterialPolicy::class);
        Gate::policy(Assignment::class, AssignmentPolicy::class);
        Gate::policy(Quiz::class, QuizPolicy::class);
        Gate::policy(Attendance::class, AttendancePolicy::class);
        Gate::policy(Grade::class, GradePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
