<?php

namespace App\Filament\Admin\Resources\SemesterResource\Pages;

use App\Filament\Admin\Resources\SemesterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSemesters extends ListRecords
{
    protected static string $resource = SemesterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
