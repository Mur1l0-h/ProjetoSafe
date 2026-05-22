<?php

namespace App\Filament\Resources\AutorizacaoResource;

use App\Filament\Resources\AutorizacaoResource\Pages;
use App\Models\Autorizacao;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Action;

class AutorizacaoResource extends Resource
{
    protected static ?string $model = Autorizacao::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'Autorizacao';

 // 1. FORMULÁRIO CORRIGIDO (Removendo os segundos do seletor de vez)
    public static function form(Schema $schema): Schema
    {
        return $schema->components([ 
            Forms\Components\TextInput::make('student_name')
                ->label('Nome do Aluno')
                ->placeholder('Digite o nome completo')
                ->required(),

            Forms\Components\TextInput::make('turma')
                ->label('Turma')
                ->placeholder('Ex: 1º Ano A, 2º Ano B')
                ->required(),

            Forms\Components\TextInput::make('professor_name')
                ->label('Professor(a)')
                ->placeholder('Nome do professor responsável')
                ->default(fn () => auth()->user()->hasRole('professor') ? auth()->user()->name : null)
                ->required(),

            Forms\Components\DatePicker::make('data')
                ->label('Data')
                ->default(now())
                ->displayFormat('d/m/Y')
                ->required(),

            // CORRIGIDO: ->seconds(false) remove a coluna de segundos do relógio
            Forms\Components\TimePicker::make('horario')
                ->label('Horário')
                ->seconds(false) 
                ->displayFormat('H:i')
                ->required(),
            
            Forms\Components\Select::make('type')
                ->label('Tipo de Autorização')
                ->options([
                    'entrada' => 'Entrada',
                    'saida' => 'Saída',
                ])
                ->required(),
            
            Forms\Components\TextInput::make('absences_to_apply')
                ->numeric()
                ->label('Faltas a aplicar')
                ->default(0),
            
            Forms\Components\Hidden::make('created_by')
                ->default(auth()->id()),
        ]);
    }

    // 2. TABELA DE EXIBIÇÃO MANTENDO TODOS OS CAMPOS E FORMATO LIMPO
    public static function table(Table $table): Table
    {
        return $table 
            ->columns([
                Tables\Columns\TextColumn::make('student_name')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('turma')
                    ->label('Turma')
                    ->searchable(),

                Tables\Columns\TextColumn::make('professor_name')
                    ->label('Professor(a)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('data')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                // CORRIGIDO: Força a exibição na listagem estritamente como Hora:Minuto
                Tables\Columns\TextColumn::make('horario')
                    ->label('Horário')
                    ->time('H:i'),

                Tables\Columns\TextColumn::make('absences_to_apply')
                    ->label('Faltas')
                    ->numeric()
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'danger' : 'gray'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'entrada' => 'success',
                        'saida' => 'warning',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'danger',
                        'concluida' => 'success',
                    }),
            ])
            ->actions([
                Action::make('validarSaida')
                    ->label('Validar Saída')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->type === 'saida' && $record->status === 'pendente' && auth()->user()->hasRole('portaria'))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'concluida',
                            'validated_by' => auth()->id(),
                            'validated_at' => now(),
                        ]);
                    })
            ]);
    }
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAutorizacaos::route('/'),
            'create' => Pages\CreateAutorizacao::route('/create'),
            'edit' => Pages\EditAutorizacao::route('/{record}/edit'),
        ];
    }

   
 public static function getEloquentQuery(): Builder
{
    $query = parent::getEloquentQuery();
    $user = auth()->user();

    // Filtra para o professor ver apenas as autorizações com o nome dele
    if ($user->hasRole('professor')) {
        return $query->where('professor_name', $user->name);
    }

    return $query;
}


    // Quem pode criar novos registros?
    public static function canCreate(): bool
    {
        return auth()->user()->hasRole('coordenador');
    }

    // Quem pode editar registros existentes?
    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()->hasRole('coordenador');
    }
}