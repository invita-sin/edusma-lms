<?php

namespace App\Filament\Admin\Resources\AttendanceResource\Pages;

use App\Filament\Admin\Resources\AttendanceResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

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
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal'),
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal'),
                ])
                ->action(function (array $data) {
                    $params = http_build_query(array_filter($data));
                    return redirect()->route('reports.attendances.pdf', $params);
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
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal'),
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal'),
                ])
                ->action(function (array $data) {
                    $params = http_build_query(array_filter($data));
                    return redirect()->route('reports.attendances.excel', $params);
                }),
        ];
    }
}
