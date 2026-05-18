<?php

namespace App\Filament\Resources\AutorizacaoResource\Pages;

use App\Filament\Resources\AutorizacaoResource\AutorizacaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAutorizacaos extends ListRecords
{
    protected static string $resource = AutorizacaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}