<?php

namespace App\Filament\Resources\JobLabelResource\Pages;

use App\Filament\Resources\JobLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobLabel extends EditRecord
{
    protected static string $resource = JobLabelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
