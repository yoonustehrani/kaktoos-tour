<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Traits\ResourceCommonMethods;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    use ResourceCommonMethods;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Username')->translateLabel()->required(),
                Forms\Components\TextInput::make('email')->translateLabel()->required()->email(),
                Forms\Components\TextInput::make('password')->translateLabel()->password()->autocomplete('new-password')->revealable(),
                Forms\Components\DateTimePicker::make('email_verified_at')->translateLabel()->firstDayOfWeek(6)->native(false)->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Username')->translateLabel(),
                Tables\Columns\TextColumn::make('email')->translateLabel(),
                // Tables\Columns\IconColumn::make('email_verified_at')->icon(fn($state) => is_null($state) ? 'heroicon-o-check-badge' : 'heroicon-o-x-mark')->color('red')->translateLabel()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
