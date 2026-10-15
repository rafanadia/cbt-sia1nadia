<?php

namespace App\Filament\Resources\ExamResults\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExamResultsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->label('Tanggal Ujian')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->placeholder('Belum selesai'),

                TextColumn::make('total_questions')
                    ->label('Total Soal')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('correct_answers')
                    ->label('Benar')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('wrong_answers')
                    ->label('Salah')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('score')
                    ->label('Nilai')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('started_at')
                    ->label('Mulai Ujian')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make()
                    ->label('Detail'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
