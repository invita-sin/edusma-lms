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
        .present { color: green; }
        .absent { color: red; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        <p>{{ $school }}</p>
        <p>Dicetak: {{ $generated_at }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Siswa</th>
                <th>Course</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->user->name ?? '-' }}</td>
                    <td>{{ $attendance->course->name }}</td>
                    <td>{{ $attendance->date->format('d/m/Y') }}</td>
                    <td class="text-center {{ $attendance->status }}">
                        @switch($attendance->status)
                            @case('present') Hadir @break
                            @case('absent') Alpa @break
                            @case('sick') Sakit @break
                            @case('permission') Izin @break
                            @case('late') Terlambat @break
                            @default {{ $attendance->status }}
                        @endswitch
                    </td>
                    <td>{{ $attendance->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate otomatis oleh sistem EduSMA
    </div>
</body>
</html>
