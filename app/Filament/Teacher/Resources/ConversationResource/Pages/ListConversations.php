<?php

namespace App\Filament\Teacher\Resources\ConversationResource\Pages;

use App\Filament\Teacher\Resources\ConversationResource;
use Filament\Resources\Pages\ListRecords;

class ListConversations extends ListRecords
{
    protected static string $resource = ConversationResource::class;

    protected ?string $heading = 'Percakapan';

    protected ?string $subheading = 'Daftar percakapan dengan siswa';
}
