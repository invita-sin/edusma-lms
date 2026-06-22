<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 5px; }
        .meta { text-align: center; margin-bottom: 20px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f4f4f4; font-weight: bold; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        <p>{{ $school }} | {{ $semester ?? '' }}</p>
        <p>Dicetak: {{ $generated_at }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Course</th>
                <th class="text-center">Tugas (20%)</th>
                <th class="text-center">Quiz (20%)</th>
                <th class="text-center">UTS (30%)</th>
                <th class="text-center">UAS (30%)</th>
                <th class="text-center">Total</th>
                <th class="text-center">Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr>
                    <td>{{ $grade->student->user->name ?? '-' }}</td>
                    <td>{{ $grade->course->name }}</td>
                    <td class="text-center">{{ $grade->assignment_score ?? '-' }}</td>
                    <td class="text-center">{{ $grade->quiz_score ?? '-' }}</td>
                    <td class="text-center">{{ $grade->midterm_score ?? '-' }}</td>
                    <td class="text-center">{{ $grade->final_exam_score ?? '-' }}</td>
                    <td class="text-center">{{ $grade->total_score }}</td>
                    <td class="text-center">{{ $grade->grade }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate otomatis oleh sistem EduSMA
    </div>
</body>
</html>
