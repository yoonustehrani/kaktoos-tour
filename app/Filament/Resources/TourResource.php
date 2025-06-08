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

    protected static ?string $navigationGroup = 'Tour';

    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'fas-suitcase';

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
                Tables\Columns\ImageColumn::make('image_src')->label('Unique Image')->translateLabel()->checkFileExistence(false),
                Tables\Columns\TextColumn::make('title')->searchable()->translateLabel(),
                Tables\Columns\TextColumn::make('origin.name_fa')->translateLabel(),
                // Tables\Columns\TextColumn::make('destinations.location.name_fa')->translateLabel(),
                Tables\Columns\TextColumn::make('is_inbound')
                ->label('Tour type')
                ->translateLabel()
                ->formatStateUsing(fn($state) => $state ? 'داخلی' : 'خارجی')
                ->color(fn (string $state): string => $state ? 'success' : 'danger')
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_inbound')
                    ->label('Tour type')
                    ->placeholder(__('All'))
                    ->trueLabel(__('inbound'))
                    ->falseLabel(__('outbound'))
                    ->translateLabel()
                    ->queries(
                        true: fn (Builder $query) => $query->where('is_inbound', true),
                        false: fn (Builder $query) => $query->where('is_inbound', false),
                        blank: fn (Builder $query) => $query, // In this example, we do not want to filter the query when it is blank.
                    )
            ])
            ->actions([
                Tables\Actions\Action::make('edit')->translateLabel()->url(function(Model $record) {
                    return route('tours.edit', ['tour' => $record->id]);
                })->icon('heroicon-m-pencil-square')
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
