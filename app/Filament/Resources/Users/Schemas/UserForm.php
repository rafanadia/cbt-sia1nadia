<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        // upload foto 
                        FileUpload::make('photo_path')
                            ->label('Upload foto profil')
                            ->image() // khusus upload gambar
                            ->avatar() // resize otomatis dan circular
                            ->disk('public') // partisi storage
                            ->directory('user-photos') // nama folder
                            ->maxSize(1024) // ukuran max 1MB
                            ->imageEditor()
                            ->ColumnSpanFull(),
                            // ->alignCenter(),
                        TextInput::make('name')
                            ->label('Nama lengkap')
                            ->required()
                            ->ColumnSpanFull(),
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->unique('users', 'email')
                            ->prefix('@')
                            ->email(),
                        // DateTimePicker::make('email_verified_at'),
                        TextInput::make('password')
                            ->hiddenOn('edit')  // disembunyikan di halaman edit
                            ->revealable()
                            ->placeholder('Digunakan untuk login akun')
                            ->password()
                            ->required(),
                        TextInput::make('username')
                            ->label('Login Username')
                            ->unique( // harus unik dnegan user lain
                                table: 'users',
                                column: 'username',
                            )
                            ->placeholder('Digunakan untuk login akun')
                            ->helperText('Username harus unik!')
                            ->required(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->prefixIcon('heroicon-o-phone')  // pake string
                            ->tel()
                            ->default(null),
                    ]),
            ]);
    }
}