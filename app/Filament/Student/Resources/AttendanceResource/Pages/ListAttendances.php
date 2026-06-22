<?php

namespace App\Filament\Student\Resources\AttendanceResource\Pages;

use App\Filament\Student\Resources\AttendanceResource;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;
}
