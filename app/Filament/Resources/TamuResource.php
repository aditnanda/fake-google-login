<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TamuResource\Pages;
use App\Filament\Resources\TamuResource\RelationManagers;
use App\Models\Tamu;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class TamuResource extends Resource
{
    protected static ?string $model = Tamu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->maxLength(255),
                Forms\Components\TextInput::make('pass')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ip')
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_agent')
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')
                ->formatStateUsing(fn (string $state): string => 'xxxxx' .substr($state, 4, strlen($state)-1)  )
                    ->searchable(),

                Tables\Columns\TextColumn::make('pass')
                ->formatStateUsing(fn (string $state): string => substr($state, 0, -6) . 'xxxxxx')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip')
                ->formatStateUsing(fn (string $state): string => substr($state, 0, -5) . 'xxxxx')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_agent')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
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
            'index' => Pages\ListTamus::route('/'),
            'create' => Pages\CreateTamu::route('/create'),
            'edit' => Pages\EditTamu::route('/{record}/edit'),
        ];
    }
}
