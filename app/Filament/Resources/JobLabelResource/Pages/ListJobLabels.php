<?php

namespace App\Filament\Resources\JobLabelResource\Pages;

use App\Filament\Resources\JobLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobLabels extends ListRecords
{
    protected static string $resource = JobLabelResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
