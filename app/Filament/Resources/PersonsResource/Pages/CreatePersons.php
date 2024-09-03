<?php

namespace App\Filament\Resources\PersonsResource\Pages;

use App\Filament\Resources\PersonsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePersons extends CreateRecord
{
    protected static string $resource = PersonsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        return $data;
    }
}
