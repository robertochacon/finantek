<?php

namespace App\Filament\Resources\PersonsResource\Pages;

use App\Filament\Resources\PersonsResource;
use App\Models\Clients;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Session;

class CreatePersons extends CreateRecord
{
    protected static string $resource = PersonsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;
        Session::put('type_person', $data['type'] ?? null);
        return $data;
    }

    protected function afterCreate(): void
    {
        $typePerson = Session::pull('type_person');

        if($typePerson == 'cliente'){
            Clients::create([
                'person_id' => $this->record->id,
                'company_id' => $this->record->company_id,
                'created_at' => now(),
            ]);
        }

    }
}
