<?php

namespace App\Filament\Resources\GradeEscolars\Pages;

use App\Filament\Resources\GradeEscolars\GradeEscolarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGradeEscolars extends ListRecords
{
    protected static string $resource = GradeEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
