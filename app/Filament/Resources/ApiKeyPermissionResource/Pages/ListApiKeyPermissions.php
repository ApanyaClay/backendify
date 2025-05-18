<?php

namespace App\Filament\Resources\ApiKeyPermissionResource\Pages;

use App\Filament\Resources\ApiKeyPermissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApiKeyPermissions extends ListRecords
{
    protected static string $resource = ApiKeyPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
