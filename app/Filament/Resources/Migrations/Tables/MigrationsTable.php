<?php

namespace App\Filament\Resources\Migrations\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MigrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('migration')
                    ->label('Migration')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('batch')
                    ->label('Batch')
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }
}