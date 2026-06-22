<?php

namespace App\Filament\Teacher\Resources;

use App\Filament\Teacher\Resources\MaterialResource\Pages;
use App\Models\Material;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | UnitEnum | null $navigationGroup = 'Akademik';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $teacher = Auth::user()->teacher;
        return parent::getEloquentQuery()->when($teacher, fn($q) => $q->whereHas('course', fn($cq) => $cq->where('teacher_id', $teacher->id)));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()->schema([
                    Select::make('course_id')
                        ->label('Course')
                        ->relationship('course', 'name')
                        ->required(),
                    TextInput::make('title')
                        ->label('Judul Materi')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('description')
                        ->label('Deskripsi'),
                    FileUpload::make('file_path')
                        ->label('File')
                        ->disk('public')
                        ->directory('materials')
                        ->visibility('public')
                        ->maxSize(102400),
                    TextInput::make('url')
                        ->label('URL (opsional)')
                        ->url()
                        ->maxLength(2048),
                    TextInput::make('order')
                        ->label('Urutan')
                        ->numeric()
                        ->default(0),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.name')
                    ->label('Course')
                    ->sortable(),
                TextColumn::make('file_type')
                    ->label('Tipe'),
                TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
