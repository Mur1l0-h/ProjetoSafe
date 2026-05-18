<?php

namespace App\Filament\Resources\GradeEscolars;

use App\Filament\Resources\GradeEscolars\Pages\CreateGradeEscolar;
use App\Filament\Resources\GradeEscolars\Pages\EditGradeEscolar;
use App\Filament\Resources\GradeEscolars\Pages\ListGradeEscolars;
use App\Filament\Resources\GradeEscolars\Schemas\GradeEscolarForm;
use App\Filament\Resources\GradeEscolars\Tables\GradeEscolarsTable;
use App\Models\GradeEscolar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GradeEscolarResource extends Resource
{
    protected static ?string $model = GradeEscolar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Grade Escolar';

    public static function form(Schema $schema): Schema
    {
        return GradeEscolarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GradeEscolarsTable::configure($table);
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
            'index' => ListGradeEscolars::route('/'),
            'create' => CreateGradeEscolar::route('/create'),
            'edit' => EditGradeEscolar::route('/{record}/edit'),
        ];
    }
}
