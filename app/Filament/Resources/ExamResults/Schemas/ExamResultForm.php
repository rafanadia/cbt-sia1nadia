<?php

namespace App\Filament\Resources\ExamResults\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamResultForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                TextInput::make('total_questions')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('correct_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('wrong_answers')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('score')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
