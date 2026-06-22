<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Exports\StudentExport;
use App\Exports\StudentReportExport;
use App\Models\Attendance;
use App\Models\Grade;
use App\Services\PdfReportService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function downloadGradePdf(Request $request)
    {
        $query = Grade::with('student.user', 'course', 'semester', 'academicYear');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $grades = $query->orderBy('student_id')->get();

        $service = app(PdfReportService::class);
        return $service->downloadPdf('reports.grades', [
            'title' => 'Laporan Nilai',
            'school' => config('app.name'),
            'semester' => $request->semester_name ?? '',
            'grades' => $grades,
            'generated_at' => now()->format('d M Y H:i'),
        ], 'laporan-nilai.pdf');
    }

    public function downloadAttendancePdf(Request $request)
    {
        $query = Attendance::with('student.user', 'course');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        $service = app(PdfReportService::class);
        return $service->downloadPdf('reports.attendances', [
            'title' => 'Laporan Absensi',
            'school' => config('app.name'),
            'attendances' => $attendances,
            'generated_at' => now()->format('d M Y H:i'),
        ], 'laporan-absensi.pdf');
    }

    public function downloadGradeExcel(Request $request)
    {
        $query = Grade::with('student.user', 'course', 'semester', 'academicYear');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        $grades = $query->orderBy('student_id')->get();

        return Excel::download(
            new class($grades) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithMapping {
                public function __construct(private $grades) {}
                public function collection() { return $this->grades; }
                public function headings(): array {
                    return ['NISN', 'Nama', 'Course', 'Tugas (20%)', 'Quiz (20%)', 'UTS (30%)', 'UAS (30%)', 'Total', 'Grade'];
                }
                public function map($grade): array {
                    return [
                        $grade->student->nisn,
                        $grade->student->user->name,
                        $grade->course->name,
                        $grade->assignment_score,
                        $grade->quiz_score,
                        $grade->midterm_score,
                        $grade->final_exam_score,
                        $grade->total_score,
                        $grade->grade,
                    ];
                }
            },
            'laporan-nilai.xlsx'
        );
    }

    public function downloadAttendanceExcel(Request $request)
    {
        return Excel::download(
            new AttendanceExport(
                courseId: $request->filled('course_id') ? $request->course_id : null,
                startDate: $request->filled('start_date') ? $request->start_date : null,
                endDate: $request->filled('end_date') ? $request->end_date : null,
            ),
            'laporan-absensi.xlsx'
        );
    }

    public function exportStudents()
    {
        return Excel::download(new StudentExport, 'data-siswa.xlsx');
    }

    public function exportStudentReport(int $studentId)
    {
        return Excel::download(new StudentReportExport($studentId), 'laporan-siswa.xlsx');
    }
}
