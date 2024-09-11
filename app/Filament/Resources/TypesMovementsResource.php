<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypesMovementsResource\Pages;
use App\Filament\Resources\TypesMovementsResource\RelationManagers;
use App\Models\Types_movements;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TypesMovementsResource extends Resource
{
    protected static ?string $model = Types_movements::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $modelLabel = 'Tipo de movimiento';

    protected static ?string $pluralModelLabel = 'Tipos de movimientos';

    protected static ?string $navigationLabel = 'Tipos de movimientos';

    protected static ?string $navigationGroup = 'Mantenimiento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Nombre')
                ->maxLength(60)
                ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListTypesMovements::route('/'),
            'create' => Pages\CreateTypesMovements::route('/create'),
            'edit' => Pages\EditTypesMovements::route('/{record}/edit'),
        ];
    }
}
