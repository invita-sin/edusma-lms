<?php

namespace App\Filament\Admin\Resources\GradeResource\Pages;

use App\Filament\Admin\Resources\GradeResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('exportPdf')
                ->label('PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->form([
                    Select::make('course_id')
                        ->label('Course')
                        ->relationship('course', 'name')
                        ->nullable(),
                    Select::make('semester_id')
                        ->label('Semester')
                        ->relationship('semester', 'name')
                        ->nullable(),
                    Select::make('academic_year_id')
                        ->label('Tahun Ajaran')
                        ->relationship('academicYear', 'name')
                        ->nullable(),
                ])
                ->action(function (array $data) {
                    $params = http_build_query(array_filter($data));
                    return redirect()->route('reports.grades.pdf', $params);
                }),
            Action::make('exportExcel')
                ->label('Excel')
                ->icon('heroicon-o-table-cells')
                ->color('success')
                ->form([
                    Select::make('course_id')
                        ->label('Course')
                        ->relationship('course', 'name')
                        ->nullable(),
                    Select::make('semester_id')
                        ->label('Semester')
                        ->relationship('semester', 'name')
                        ->nullable(),
                ])
                ->action(function (array $data) {
                    $params = http_build_query(array_filter($data));
                    return redirect()->route('reports.grades.excel', $params);
                }),
        ];
    }
}
