<?php

namespace App\Filament\Resources\ApiKeyPermissionResource\Pages;

use App\Filament\Resources\ApiKeyPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApiKeyPermission extends EditRecord
{
    protected static string $resource = ApiKeyPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
