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

class AcademicSettings extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected string $view = 'filament.admin.pages.settings';

    protected static string | UnitEnum | null $navigationGroup = 'Pengaturan';

    protected static ?int $navigationSort = 2;

    public array $data = [];

    public function mount(): void
    {
        $service = App::make(SettingsService::class);
        $this->form->fill($service->getAcademicSettings());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Pengaturan Akademik')
                    ->schema([
                        TextInput::make('passing_grade')
                            ->label('Nilai Minimal Lulus')
                            ->numeric()
                            ->required(),
                        TextInput::make('max_grade')
                            ->label('Nilai Maksimal')
                            ->numeric()
                            ->required(),
                        TextInput::make('grade_a_min')
                            ->label('Minimal Nilai A')
                            ->numeric()
                            ->required(),
                        TextInput::make('grade_b_min')
                            ->label('Minimal Nilai B')
                            ->numeric()
                            ->required(),
                        TextInput::make('grade_c_min')
                            ->label('Minimal Nilai C')
                            ->numeric()
                            ->required(),
                        TextInput::make('grade_d_min')
                            ->label('Minimal Nilai D')
                            ->numeric()
                            ->required(),
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
        $service->updateAcademicSettings($data);

        $this->notify('success', 'Pengaturan akademik berhasil disimpan');
    }
}
