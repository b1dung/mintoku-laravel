<?php

namespace App\Filament\Resources\JobFairResource\Pages;

use App\Filament\Resources\JobFairResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobFair extends EditRecord
{
    protected static string $resource = JobFairResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
