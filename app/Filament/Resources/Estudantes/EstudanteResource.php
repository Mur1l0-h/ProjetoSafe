<?php

namespace App\Filament\Resources\Estudantes;

use App\Filament\Resources\Estudantes\Pages\CreateEstudante;
use App\Filament\Resources\Estudantes\Pages\EditEstudante;
use App\Filament\Resources\Estudantes\Pages\ListEstudantes;
use App\Filament\Resources\Estudantes\Schemas\EstudanteForm;
use App\Filament\Resources\Estudantes\Tables\EstudantesTable;
use App\Models\Estudante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EstudanteResource extends Resource
{
    protected static ?string $model = Estudante::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Estudante';

    public static function form(Schema $schema): Schema
    {
        return EstudanteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EstudantesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEstudantes::route('/'),
            'create' => CreateEstudante::route('/create'),
            'edit' => EditEstudante::route('/{record}/edit'),
        ];
    }
}
