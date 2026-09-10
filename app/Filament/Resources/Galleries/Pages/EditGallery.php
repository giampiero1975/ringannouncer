<?php

namespace App\Filament\Resources\Galleries\Pages;

use App\Filament\Resources\Galleries\GalleryResource;
use App\Models\Gallery;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGallery extends EditRecord
{
    protected static string $resource = GalleryResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['title'] ?? null) !== $this->record->title) {
            $data['slug'] = Gallery::uniqueSlug($data['title'], $this->record->getKey(), 'gallery');
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
