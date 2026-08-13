<?php

namespace App\Filament\Resources\Migrations\Pages;

use App\Filament\Resources\Migrations\MigrationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMigration extends ViewRecord
{
    protected static string $resource = MigrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
