<?php

namespace App\Filament\Resources;

use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Producto;

use App\Filament\Resources\OrdenTrabajoResource\Pages;
use App\Filament\Resources\OrdenTrabajoResource\RelationManagers;
use App\Models\OrdenTrabajo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdenTrabajoResource extends Resource
{
    protected static ?string $model = OrdenTrabajo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')->label('Titulo')
                ->required(),
                Forms\Components\Select::make('cliente_id')->label('Cliente')
                ->relationship('cliente', 'nombre')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    Forms\Components\TextInput::make('nombre')->label('Nombre del Cliente')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telefono')->label('Telefono')
                        ->tel()
                        ->required(),
                    Forms\Components\TextInput::make('correo')->label('Correo')
                        ->email()
                        ->maxLength(255),
                ])
                ->required(),
            Forms\Components\Textarea::make('descripcion')->label('Observaciones del Trabajo')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'completado' => 'Completado',
                ])
                ->default('pendiente'),

            // Servicios
            Forms\Components\Repeater::make('detalleServicios')->label('Servicios')
                 ->relationship('detalleServicios')
                ->schema([
                    Forms\Components\Select::make('servicio_id')->label('Servicio')
                        ->relationship('servicio', 'nombre')
                        ->required(),
                    Forms\Components\TextInput::make('cantidad')
                        ->numeric()
                        ->default(1),
                ])
                ->columns(2),

            // Productos
            Forms\Components\Repeater::make('detalleProductos')->label('Productos')
                ->relationship('detalleProductos')
                ->schema([
                    Forms\Components\Select::make('producto_id')->label('Producto')
                        ->relationship('producto', 'nombre'),
                    Forms\Components\TextInput::make('cantidad')
                        ->numeric()
                        ->default(1),
                ])
                ->columns(2),    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('# de Orden')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('cliente.nombre')->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('titulo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('estado')
                    ->label('Estado de la Orden')
                    ->icon(fn ($record) => match ($record->estado) {
                        'pendiente' => 'heroicon-o-clock',
                        'completado' => 'heroicon-o-check-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->color(fn ($record) => match ($record->estado) {
                        'pendiente' => 'warning',
                        'completado' => 'success',
                        default => 'gray',
                    })
                    ->size(IconColumn\IconColumnSize::ExtraLarge)
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')->date()
                    ->toggleable(isToggledHiddenByDefault: false),
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
            'index' => Pages\ListOrdenTrabajos::route('/'),
            'create' => Pages\CreateOrdenTrabajo::route('/create'),
            'edit' => Pages\EditOrdenTrabajo::route('/{record}/edit'),
        ];
    }
}
