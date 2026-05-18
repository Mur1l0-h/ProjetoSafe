<?php

namespace App\Filament\Resources\AutorizacaoResource\Pages;

use App\Filament\Resources\AutorizacaoResource\AutorizacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAutorizacao extends EditRecord
{
    protected static string $resource = AutorizacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}