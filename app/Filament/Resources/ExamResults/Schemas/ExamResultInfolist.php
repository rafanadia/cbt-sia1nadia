<?php

namespace App\Filament\Resources\ExamResults\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExamResultInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('subject.name')
                    ->label('Subject'),
                TextEntry::make('total_questions')
                    ->numeric(),
                TextEntry::make('correct_answers')
                    ->numeric(),
                TextEntry::make('wrong_answers')
                    ->numeric(),
                TextEntry::make('score')
                    ->numeric(),
                TextEntry::make('started_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('completed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
