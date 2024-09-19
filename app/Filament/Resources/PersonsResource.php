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
use Filament\Forms\Components\Tabs;

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
                    ->live()
                    ->options([
                        'cliente' => 'Cliente',
                        'empleado' => 'Empleado',
                        'usuario' => 'Usuario'
                    ])
                    ->searchable(),
                //Cliente
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Referencias')
                            ->schema([
                                Forms\Components\Repeater::make('personal_references')
                                    ->label('Referencias personales')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombre')
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Teléfono')
                                            ->maxLength(50),
                                    ])
                                    ->defaultItems(2)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderableWithDragAndDrop(false)
                                    ->columns(2),
                                Forms\Components\Repeater::make('family_references')
                                    ->label('Referencias familiares')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Nombre')
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('phone')
                                            ->label('Teléfono')
                                            ->maxLength(50),
                                    ])
                                    ->defaultItems(2)
                                    ->addable(false)
                                    ->deletable(false)
                                    ->reorderableWithDragAndDrop(false)
                                    ->columns(2),
                                    Forms\Components\Repeater::make('business_references')
                                        ->label('Referencias comerciales')
                                        ->schema([
                                            Forms\Components\TextInput::make('name')
                                                ->label('Nombre')
                                                ->maxLength(50),
                                            Forms\Components\TextInput::make('phone')
                                                ->label('Teléfono')
                                                ->maxLength(50),
                                        ])
                                        ->defaultItems(2)
                                        ->addable(false)
                                        ->deletable(false)
                                        ->reorderableWithDragAndDrop(false)
                                        ->columns(2)
                            ]),
                        Tabs\Tab::make('Ingresos y gastos')
                            ->schema([
                                Forms\Components\Section::make('Ingresos')
                                    ->description('Información sobre los ingresos del cliente.')
                                    ->schema([
                                        Forms\Components\TextInput::make('income_salary')
                                            ->label('Salario')
                                            ->numeric()
                                            ->maxLength(10)
                                            ->default(null),
                                        Forms\Components\TextInput::make('income_other')
                                            ->label('Otros Ingresos')
                                            ->numeric()
                                            ->maxLength(10)
                                            ->default(null),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Gastos')
                                    ->description('Información sobre los gastos del cliente.')
                                    ->schema([
                                        Forms\Components\TextInput::make('expenses_home')
                                            ->label('Gastos del Hogar')
                                            ->numeric()
                                            ->maxLength(10)
                                            ->default(null),
                                        Forms\Components\TextInput::make('expenses_credit_quotas')
                                            ->label('Cuotas de Crédito')
                                            ->numeric()
                                            ->maxLength(10)
                                            ->default(null),
                                        Forms\Components\TextInput::make('expenses_other')
                                            ->label('Otros Gastos')
                                            ->numeric()
                                            ->maxLength(10)
                                            ->default(null),
                                    ])
                                    ->columns(2),
                            ]),
                        Tabs\Tab::make('Garantias')
                            ->schema([
                                Forms\Components\RichEditor::make('warranty')
                                ->label('')
                            ]),
                    ])
                    ->visible(fn (Get $get): bool => $get('type') == "cliente")
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
                Forms\Components\Section::make('Empleado')
                    ->description('Información adicional sobre el empleado.')
                    ->icon('heroicon-m-user')
                    ->schema([
                        Forms\Components\TextInput::make('position')
                            ->label('Posición')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('salary')
                            ->label('Salario')
                            ->numeric()
                            ->default(null),
                        Forms\Components\DatePicker::make('contract_start_date')
                            ->label('Fecha de inicio')
                            ->default(null),
                    ])
                    ->columns(3)
                    ->extraAttributes(['class' => 'bg-gray-50 border-l-4 border-indigo-500'])
                    ->visible(fn (Get $get): bool => $get('type') == "empleado"),
                Forms\Components\Section::make('Usuario')
                    ->description('Información adicional sobre el usuario.')
                    ->icon('heroicon-m-user')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->maxLength(50)
                            ->default(null),
                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password(),
                        Forms\Components\Select::make('role')
                            ->label('Role')
                            ->default('admin')
                            ->options([
                                'employee' => 'Empleado',
                                'supervisor' => 'Supervisor',
                                'admin' => 'Administrador',
                            ])
                            ->searchable(),
                    ])
                    ->columns(3)
                    ->extraAttributes(['class' => 'bg-gray-50 border-l-4 border-indigo-500'])
                    ->visible(fn (Get $get): bool => $get('type') == "usuario"),
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
