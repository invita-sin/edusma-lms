<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class PdfReportService
{
    public function generateGradeReport(Collection $grades, array $meta = []): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'title' => $meta['title'] ?? 'Laporan Nilai',
            'school' => $meta['school'] ?? 'EduSMA',
            'semester' => $meta['semester'] ?? '',
            'grades' => $grades,
            'generated_at' => now()->format('d M Y H:i'),
        ];

        return Pdf::loadView('reports.grades', $data);
    }

    public function generateAttendanceReport(Collection $attendances, array $meta = []): \Barryvdh\DomPDF\PDF
    {
        $data = [
            'title' => $meta['title'] ?? 'Laporan Absensi',
            'school' => $meta['school'] ?? 'EduSMA',
            'attendances' => $attendances,
            'generated_at' => now()->format('d M Y H:i'),
        ];

        return Pdf::loadView('reports.attendances', $data);
    }

    public function downloadPdf(string $view, array $data, string $filename): \Illuminate\Http\Response
    {
        $pdf = Pdf::loadView($view, $data);
        return $pdf->download($filename);
    }

    public function streamPdf(string $view, array $data, string $filename): \Illuminate\Http\Response
    {
        $pdf = Pdf::loadView($view, $data);
        return $pdf->stream($filename);
    }
}
