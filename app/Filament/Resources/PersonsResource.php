<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonsResource\Pages;
use App\Filament\Resources\PersonsResource\RelationManagers;
use App\Models\Persons;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PersonsResource extends Resource
{
    protected static ?string $model = Persons::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Persona';

    protected static ?string $pluralModelLabel = 'Personas';

    protected static ?string $navigationLabel = 'Personas';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('identification')
                ->label('Cédula')
                ->maxLength(50)
                ->default(null),
            Forms\Components\TextInput::make('first_name')
                ->label('Primer Nombre')
                ->maxLength(50)
                ->default(null),
            Forms\Components\TextInput::make('last_name')
                ->label('Primer Apellido')
                ->maxLength(50)
                ->default(null),
            Forms\Components\TextInput::make('second_last_name')
                ->label('Segundo Apellido')
                ->maxLength(50)
                ->default(null),
            Forms\Components\DatePicker::make('birthdate')
                ->label('Fecha de Nacimiento')
                ->default(null),
            Forms\Components\select::make('gender')
                ->label('Género')
                ->default('F')
                ->options([
                    'F' => 'Femenino',
                    'M' => 'Masculino'
                ])
                ->searchable(),
            Forms\Components\Select::make('status')
                ->label('Estado')
                ->default('active')
                ->options([
                    'active' => 'Activo',
                    'inactive' => 'Inactivo'
                ])
                ->searchable(),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('identification')
                    ->label('Identificación')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Primer Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Primer Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('second_last_name')
                    ->label('Segundo Apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Fecha de Nacimiento')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Género'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListPersons::route('/'),
            'create' => Pages\CreatePersons::route('/create'),
            'edit' => Pages\EditPersons::route('/{record}/edit'),
        ];
    }
}
