<?php

namespace App\Filament\Resources\JobResource\Pages;

use App\Filament\Resources\JobResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJob extends EditRecord
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        if ($this->record->responsible_id) {
            $data['responsible_guid'] = "{$this->record->responsible_type}-{$this->record->responsible_id}";
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['responsible_guid']) && str_contains($data['responsible_guid'], '-')) {
            [$type, $id] = explode('-', $data['responsible_guid']);
            $data['responsible_type'] = $type;
            $data['responsible_id'] = $id;
        } else {
            $data['responsible_type'] = null;
            $data['responsible_id'] = null;
        }

        unset($data['responsible_guid']);

        return $data;
    }
}
