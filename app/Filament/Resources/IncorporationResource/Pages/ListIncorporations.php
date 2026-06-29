<?php

namespace App\Filament\Resources\IncorporationResource\Pages;

use App\Filament\Resources\IncorporationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncorporations extends ListRecords
{
    protected static string $resource = IncorporationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
