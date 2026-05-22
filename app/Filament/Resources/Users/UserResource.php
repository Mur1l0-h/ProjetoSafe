<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?string $recordTitleAttribute = 'Usuário';
    
    protected static ?string $navigationLabel = 'Gerenciar Usuários';

    // Restringe o acesso ao menu lateral apenas para Coordenadores
    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('coordenador');
    }

    // Formulário de Criação/Edição usando a estrutura de Schema do seu projeto
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('name')
                ->label('Nome')
                ->required(),

            Forms\Components\TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('password')
                ->label('Senha')
                ->password()
                ->dehydrated(fn ($state) => filled($state)) // Só salva se preenchido
                ->required(fn (string $context): bool => $context === 'create'), // Obrigatório apenas na criação

            Forms\Components\Select::make('roles')
                ->label('Nível de Acesso (Role)')
                ->relationship('roles', 'name') // Sincroniza diretamente com o Spatie Permission
                ->preload()
                ->required(),
        ]);
    }

    // Tabela de listagem dos usuários
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Perfil')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'coordenador' => 'danger',
                        'professor' => 'info',
                        'portaria' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}