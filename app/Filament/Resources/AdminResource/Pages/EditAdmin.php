<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        Cache::forget('spatie.permission.cache');
        if ($record->id === auth()->id()) {
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            redirect('/camcom-cms/login');
        }

        return $record;
    }
}
