<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->requiresConfirmation()];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['role']);

        return $data;
    }
}
