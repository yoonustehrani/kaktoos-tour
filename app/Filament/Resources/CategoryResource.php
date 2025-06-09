<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Traits\ResourceCommonMethods;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    use ResourceCommonMethods;

    protected static ?string $navigationGroup = 'Website';

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->translateLabel()->required()
                ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (!is_null($old) && ($get('slug') ?? '') !== slugify($old)) {
                            return;
                        }
                    
                        $set('slug', slugify($state));
                    }),
                TextInput::make('slug')->translateLabel(),
                Forms\Components\Select::make('classification_id')->translateLabel()
                    ->relationship('classification', 'title')
                    // ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('title')->translateLabel()->required(),
                    ])
                    ->required(),
                TextInput::make('icon_class')->translateLabel()->requiredWithout('image_src'),
                FileUpload::make('image_src')
                    ->label('Unique Image')->translateLabel()
                    ->image()->imageEditor()->openable()->moveFiles()
                    ->maxSize(750)
                    ->requiredWithout('icon_class')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->translateLabel(),
                Tables\Columns\ImageColumn::make('image_src')->label('Unique Image')->translateLabel(),
                Tables\Columns\TextColumn::make('classification.title')->translateLabel()
                // Tables\Columns\
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
