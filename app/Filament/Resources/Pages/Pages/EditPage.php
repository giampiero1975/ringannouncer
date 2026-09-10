<?php

namespace App\Filament\Resources\Pages\Pages;

use App\Filament\Resources\Pages\PageResource;
use App\Models\Page;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['title'] ?? null) !== $this->record->title) {
            $data['key'] = Page::uniqueKey($data['title'], $this->record->getKey());
        }

        return $data;
    }
}
