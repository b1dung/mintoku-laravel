<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['responsible_guid']) && str_contains($data['responsible_guid'], '-')) {
            [$type, $id] = explode('-', $data['responsible_guid']);
            $data['responsible_type'] = $type;
            $data['responsible_id'] = $id;
        }

        unset($data['responsible_guid']);

        return $data;
    }
    protected function afterCreate(): void
    {
        $record = $this->record;
        $visaName = $record->visa?->name;
        $parentLoc = $record->locations()->where('parent_id', 0)->first()?->name;
        $record->update([
            'extra_attributes->id_job' => "{$visaName}-{$parentLoc}-{$record->id}"
        ]);
    }
}
