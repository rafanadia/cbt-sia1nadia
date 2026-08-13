<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->label('Mata Pelajaran')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('title')
                    ->label('Soal')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),

                TextInput::make('score')
                    ->label('Nilai')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Select::make('correct_answer')
                    ->label('Jawaban Benar')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                    ])
                    ->required(),

                Toggle::make('is_active')
                    ->label('Tersedia')
                    ->default(true),

                Repeater::make('answers')
                    ->label('Pilihan Jawaban')
                    ->relationship()
                    ->schema([
                        Select::make('option')
                            ->label('Pilihan')
                            ->options([
                                'A' => 'A',
                                'B' => 'B',
                                'C' => 'C',
                                'D' => 'D',
                            ])
                            ->required(),

                        TextInput::make('answer')
                            ->label('Jawaban')
                            ->required(),

                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(3)
                    ->defaultItems(4)
                    ->minItems(4)
                    ->maxItems(4)
                    ->columnSpanFull(),
            ]);
    }
}