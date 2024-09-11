<?php

namespace App\Filament\Resources\TypesLoansResource\Pages;

use App\Filament\Resources\TypesLoansResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTypesLoans extends CreateRecord
{
    protected static string $resource = TypesLoansResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        return $data;
    }
}
