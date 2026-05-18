<?php

namespace App\Filament\Resources\Estudantes\Pages;

use App\Filament\Resources\Estudantes\EstudanteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEstudante extends EditRecord
{
    protected static string $resource = EstudanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
