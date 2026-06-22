<?php

namespace App\Filament\Admin\Pages;

use App\Services\SettingsService;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\App;
use UnitEnum;

class SchoolSettings extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office';

    protected string $view = 'filament.admin.pages.settings';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 1;

    public array $data = [];

    public function mount(): void
    {
        $service = App::make(SettingsService::class);
        $this->form->fill($service->getSchoolSettings());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Pengaturan Sekolah')
                    ->schema([
                        TextInput::make('school_name')
                            ->label('Nama Sekolah')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('school_address')
                            ->label('Alamat')
                            ->maxLength(255),
                        TextInput::make('school_phone')
                            ->label('Telepon')
                            ->maxLength(20),
                        TextInput::make('school_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('school_npsn')
                            ->label('NPSN')
                            ->maxLength(20),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $service = App::make(SettingsService::class);
        $service->updateSchoolSettings($data);

        $this->notify('success', 'Pengaturan sekolah berhasil disimpan');
    }
}
