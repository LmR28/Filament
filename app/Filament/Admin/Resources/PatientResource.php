<?php


namespace App\Filament\Admin\Resources;

use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Admin\Resources\PatientResource\RelationManagers\TreatmentsRelationManager;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'gato' => 'Gato',
                        'perro' => 'Perro',
                        'conejo' => 'Conejo',
                        'otro' => 'Otro',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->label('Fecha de nacimiento')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email(),
                Forms\Components\TextInput::make('phone')
                    ->label('Teléfono'),
                Forms\Components\Select::make('owner_id')
                    ->label('Dueño')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->label('Fecha de nacimiento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo electrónico'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('owner.name')
                    ->label('Dueño')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipo de paciente')
                    ->options([
                        'gato' => 'Gato',
                        'perro' => 'Perro',
                        'conejo' => 'Conejo',
                        'otro' => 'Otro',
                    ]),
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
            TreatmentsRelationManager::class,
        ];
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