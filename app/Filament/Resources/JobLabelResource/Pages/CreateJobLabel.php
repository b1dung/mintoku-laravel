<?php

namespace App\Filament\Resources\JobLabelResource\Pages;

use App\Filament\Resources\JobLabelResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobLabel extends CreateRecord
{
    protected static string $resource = JobLabelResource::class;
}
