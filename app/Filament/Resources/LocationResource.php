<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LocationResource\Pages;
use App\Filament\Resources\LocationResource\RelationManagers;
use App\Filament\Traits\ResourceCommonMethods;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationResource extends Resource
{
    use ResourceCommonMethods;

    protected static ?string $navigationGroup = 'Places';

    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->translateLabel()->alpha()->required()->maxLength(100),
                Forms\Components\TextInput::make('name_fa')->translateLabel()->alpha()->required()->maxLength(100),
                Forms\Components\Toggle::make('is_origin')->translateLabel(),
                Forms\Components\Select::make('country_code')->translateLabel()
                    ->relationship('country', 'name_fa')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('code')->alpha()->required()->length(2),
                        Forms\Components\TextInput::make('name')->alpha()->required()->maxLength(100),
                        Forms\Components\TextInput::make('name_fa')->alpha()->required()->maxLength(100),
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_fa')->translateLabel()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->translateLabel()->searchable()->sortable(),
                \App\Tables\Columns\CoutryImage::make('country.code')->translateLabel()->searchable(['name_fa', 'name']),
                IconColumn::make('is_origin')->boolean()->translateLabel()
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_origin')
                    ->label('Location Type')
                    ->placeholder(__('All'))
                    ->trueLabel(__('Origins'))
                    ->falseLabel(__('Destinations'))
                    ->translateLabel()
                    ->queries(
                        true: fn (Builder $query) => $query->where('is_origin', true),
                        false: fn (Builder $query) => $query->where('is_origin', false),
                        blank: fn (Builder $query) => $query, // In this example, we do not want to filter the query when it is blank.
                    )
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
