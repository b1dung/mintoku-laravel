<?php

namespace App\Filament\Resources\TypeJobResource\Pages;

use App\Filament\Resources\TypeJobResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypeJob extends EditRecord
{
    protected static string $resource = TypeJobResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
