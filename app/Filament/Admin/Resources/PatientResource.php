<?php


namespace App\Filament\Admin\Resources;

use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono'),
                Forms\Components\Select::make('owner_id')
                    ->label('Dueño')
                    ->relationship('owner', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
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
public static function shouldRegisterNavigation(): bool
{
    return true;
}
    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\PatientResource\Pages\ListPatients::route('/'),
            'create' => \App\Filament\Admin\Resources\PatientResource\Pages\CreatePatient::route('/create'),
            'edit' => \App\Filament\Admin\Resources\PatientResource\Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}