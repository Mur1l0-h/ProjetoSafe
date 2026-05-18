<?php

namespace App\Filament\Resources\Estudantes\Pages;

use App\Filament\Resources\Estudantes\EstudanteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEstudantes extends ListRecords
{
    protected static string $resource = EstudanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
