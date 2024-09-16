<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersonsResource\Pages;
use App\Filament\Resources\PersonsResource\RelationManagers;
use App\Models\Persons;
use App\Services\JCEServices;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class PersonsResource extends Resource
{
    protected static ?string $model = Persons::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $modelLabel = 'Persona';

    protected static ?string $pluralModelLabel = 'Personas';

    protected static ?string $navigationLabel = 'Personas';

    protected static ?string $navigationGroup = 'Administración';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Información general')
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    // ->avatar()
                    ->imageEditor()
                    ->circleCropper()
                    ->label('Foto de Perfil')
                    ->disk('public')
                    ->directory('profile-images')
                    ->downloadable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('identification')
                    ->label('Cédula')
                    ->maxLength(50)
                    ->default(null)
                    ->live()
                    ->afterStateUpdated(function (?string $state, ?string $old, Set $set, Get $get) {

                        try {

                            $jceService = new JCEServices();
                            $person = $jceService->getPerson($state);

                            if ($person['success']) {
                                $set('first_name', $person['citizenInfo']['nombres']);
                                $set('last_name', $person['citizenInfo']['apellido1']);
                                $set('second_last_name', $person['citizenInfo']['apellido2']);
                                $set('gender', $person['citizenInfo']['ced_a_sexo']);

                                $imageData = $person['citizenInfo']['foto_encoded'];

                                if ($imageData) {
                                    // Decodifica la imagen desde base64
                                    $image = str_replace('data:image/jpeg;base64,', '', $imageData);
                                    $image = str_replace(' ', '+', $image);
                                    $imageName = $state . '.jpg';

                                    Storage::disk('public')->put('profile-images/' . $imageName, base64_decode($image));

                                    $set('image', ['profile-images/' . $imageName]);

                                }
                            }

                        } catch (\Throwable $th) {
                            //throw $th;
                        }

                }),
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
                Forms\Components\Select::make('type')
                    ->label('Tipo de registro')
                    ->default('cliente')
                    ->options([
                        'cliente' => 'Cliente',
                        'empleado' => 'Empleado',
                        'usuario' => 'Usuario'
                    ])
                    ->searchable(),
            ])->columns(2)
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
                Tables\Columns\ToggleColumn::make('status')
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
