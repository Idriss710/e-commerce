<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// I added this libararies 
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

// from my adding for widget like dialog 
public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Section::make('User Info')
            ->schema([
                TextEntry::make('full_name')->label('User Name'),
                TextEntry::make('phone')->label('Phone Number'),

            ])->columns(2)
        ]);
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id'),
                Forms\Components\TextInput::make('tracking_no'),
                Forms\Components\TextInput::make('subtotal'),
                Forms\Components\TextInput::make('discount')->nullable(),
                Forms\Components\TextInput::make('tax'),
                Forms\Components\TextInput::make('full_name'),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('locality'),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('city'),
                Forms\Components\TextInput::make('state'),
                Forms\Components\TextInput::make('country'),
                Forms\Components\TextInput::make('landmark'),
                Forms\Components\TextInput::make('zip'),
                Forms\Components\Select::make('payment_mode')->options([
                    'cash' => 'Ordered',
                    'debit_card' => 'Debit card',
                    'paypal' => 'Paypal',
                ]),
                Forms\Components\Select::make('status') ->options([
                    'ordered' => 'Ordered',
                    'delivered' => 'Delivered',
                    'canceled' => 'Canceled',
                ])
,

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('user_id'),
                // Tables\Columns\TextColumn::make('tracking_no'),
                Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('country'),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('subtotal'),
                // Tables\Columns\TextColumn::make('discount'),
                // Tables\Columns\TextColumn::make('tax'),
                // Tables\Columns\TextColumn::make('phone'),
                // Tables\Columns\TextColumn::make('locality'),
                // Tables\Columns\TextColumn::make('address'),
                // Tables\Columns\TextColumn::make('state'),
                // Tables\Columns\TextColumn::make('landmark'),
                // Tables\Columns\TextColumn::make('zip'),
                Tables\Columns\TextColumn::make('payment_mode'),
                Tables\Columns\TextColumn::make('status'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
