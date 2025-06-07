<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Filament\Traits\ResourceCommonMethods;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TourResource extends Resource
{
    use ResourceCommonMethods;

    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Tables\Columns\TextColumn::make('title')->translateLabel()->formatStateUsing(fn($state) => $state),
                Tables\Columns\TextColumn::make('origin.name_fa')->translateLabel(),
                Tables\Columns\TextColumn::make('destinations.location.name_fa')->translateLabel(),
                Tables\Columns\TextColumn::make('is_inbound')
                ->label('داخلی / خارجی')
                ->formatStateUsing(fn($state) => $state ? 'داخلی' : 'خارجی')
                ->color(fn (string $state): string => $state ? 'success' : 'danger')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('edit')->translateLabel()->url(function(Model $record) {
                    return route('tours.edit', ['tour' => $record->id]);
                })
                // Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }


    public static function getUrl(string $name = 'index', array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        if ($name == 'create') {
            return route('tours.create');
        }
        return parent::getUrl($name, $parameters, $isAbsolute, $panel, $tenant);
    }
}
