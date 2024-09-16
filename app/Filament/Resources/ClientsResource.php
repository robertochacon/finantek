<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientsResource\Pages;
use App\Filament\Resources\ClientsResource\RelationManagers;
use App\Models\Clients;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientsResource extends Resource
{
    protected static ?string $model = Clients::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Cliente';

    protected static ?string $pluralModelLabel = 'Clientes';

    protected static ?string $navigationLabel = 'Clientes';

    protected static ?string $navigationGroup = 'Administración';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('person.identification')
                    ->label('Identificación')
                    ->searchable(),
                Tables\Columns\TextColumn::make('person.first_name')
                    ->label('Primer Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('person.last_name')
                    ->label('Primer Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('person.second_last_name')
                    ->label('Segundo Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('person.birthdate')
                    ->label('Fecha de Nacimiento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('person.gender')
                    ->label('Género'),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('person.created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('person.updated_at')
                    ->label('Fecha de Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClients::route('/create'),
            'edit' => Pages\EditClients::route('/{record}/edit'),
        ];
    }
}
