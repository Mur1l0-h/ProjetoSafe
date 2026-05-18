<?php

namespace App\Filament\Resources\GradeEscolars\Pages;

use App\Filament\Resources\GradeEscolars\GradeEscolarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGradeEscolar extends EditRecord
{
    protected static string $resource = GradeEscolarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
