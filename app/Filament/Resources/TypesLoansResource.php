<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypesLoansResource\Pages;
use App\Filament\Resources\TypesLoansResource\RelationManagers;
use App\Models\Types_loans;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypesLoansResource extends Resource
{
    protected static ?string $model = Types_loans::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $modelLabel = 'Tipo de prestamo';

    protected static ?string $pluralModelLabel = 'Tipos de prestamos';

    protected static ?string $navigationLabel = 'Tipos de prestamos';

    protected static ?string $navigationGroup = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->nullable(),
                Forms\Components\TextInput::make('interest_rate')
                    ->label('Tasa de interés')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('max_term_months')
                    ->label('Plazo máximo en meses')
                    ->numeric(),
                Forms\Components\TextInput::make('min_amount')
                    ->label('Monto mínimo')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('max_amount')
                    ->label('Monto máximo')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('legal_fees')
                    ->label('Gastos legales')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('late_fee_percentage')
                    ->label('Porcentaje de mora')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\TextInput::make('grace_days')
                    ->label('Días de gracia')
                    ->numeric(),
                Forms\Components\Textarea::make('requirements')
                    ->label('Requisitos')
                    ->json()
                    ->nullable(),
                Forms\Components\Toggle::make('status')
                    ->label('Estado')
                    ->default(true),
                Forms\Components\TextInput::make('insurance')
                    ->label('Seguro')
                    ->numeric()
                    ->step(0.01),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del tipo de préstamo'),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción'),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->label('Tasa de interés'),
                Tables\Columns\TextColumn::make('max_term_months')
                    ->label('Plazo máximo (meses)'),
                Tables\Columns\TextColumn::make('min_amount')
                    ->label('Monto mínimo'),
                Tables\Columns\TextColumn::make('max_amount')
                    ->label('Monto máximo'),
                Tables\Columns\TextColumn::make('legal_fees')
                    ->label('Gastos legales'),
                Tables\Columns\TextColumn::make('late_fee_percentage')
                    ->label('Porcentaje de mora'),
                Tables\Columns\TextColumn::make('grace_days')
                    ->label('Días de gracia'),
                Tables\Columns\TextColumn::make('insurance')
                    ->label('Seguro'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Estado')
                    ->boolean(),
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
            'index' => Pages\ListTypesLoans::route('/'),
            'create' => Pages\CreateTypesLoans::route('/create'),
            'edit' => Pages\EditTypesLoans::route('/{record}/edit'),
        ];
    }
}
