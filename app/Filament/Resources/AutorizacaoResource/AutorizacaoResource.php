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

class AutorizacaoResource extends Resource
{
    protected static ?string $model = Autorizacao::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'Autorizacao';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([ 
            // CORRIGIDO: Agora usa 'student_id' para bater exatamente com a sua migration!
            Forms\Components\Select::make('student_id')
                ->relationship('student', 'name') 
                ->searchable()
                ->required(),
            
            Forms\Components\Select::make('type')
                ->options(['entrada' => 'Entrada', 'saida' => 'Saída'])
                ->required(),
            
            Forms\Components\TextInput::make('absences_to_apply')
                ->numeric()
                ->label('Faltas a aplicar'),
            
            Forms\Components\Hidden::make('created_by')
                ->default(auth()->id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table 
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo de Liberação')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'entrada' => 'info',
                        'saida' => 'warning',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendente' => 'warning',
                        'concluida' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->label('Criada em'),
            ])
           ->actions([
                // CORRIGIDO: Chamando a Action a partir do Tables\ que já está importado com segurança no topo
                Tables\Actions\Action::make('validarSaida')
                    ->label('Validar Saída')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
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
        // CORRIGIDO: Caminho padronizado das páginas
        return [
            'index' => Pages\ListAutorizacaos::route('/'),
            'create' => Pages\CreateAutorizacao::route('/create'),
            'edit' => Pages\EditAutorizacao::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user->hasRole('professor')) {
            return $query->whereHas('student.schoolClass.schedules', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->where('day_of_week', now()->dayOfWeek) 
                  ->whereTime('start_time', '<=', now())   
                  ->whereTime('end_time', '>=', now());    
            });
        }

        return $query; 
    }
}