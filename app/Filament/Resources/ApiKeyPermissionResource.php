<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApiKeyPermissionResource\Pages;
use App\Filament\Resources\ApiKeyPermissionResource\RelationManagers;
use App\Models\ApiKey;
use App\Models\ApiKeyPermission;
use App\Models\ApiPermission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ApiKeyPermissionResource extends Resource
{
    protected static ?string $model = ApiKeyPermission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('api_key_id')
                    ->label('API Key')
                    ->relationship('apiKey', 'key')
                    ->searchable()
                    ->required()
                    ->options(
                        ApiKey::where('user_id', Auth::id())->pluck('key', 'id')
                    ),
                Forms\Components\Select::make('api_permission_id')
                    ->label('Permission')
                    ->relationship('apiPermission', 'label')
                    ->searchable()
                    ->required()
                    ->options(
                        ApiPermission::all()->pluck('label', 'id')
                    )
                    ->rules(function (callable $get, $livewire) {
                        return [
                            function ($attribute, $value, $fail) use ($get, $livewire) {
                                $apiKeyId = $get('api_key_id');
                                $recordId = $livewire->record->id ?? null;

                                if ($apiKeyId && ApiKeyPermission::where('api_key_id', $apiKeyId)
                                    ->where('api_permission_id', $value)
                                    ->when($recordId, fn ($q) => $q->where('id', '!=', $recordId))
                                    ->exists()) {
                                    $fail('Kombinasi API Key dan Permission sudah digunakan.');
                                }
                            }
                        ];
                    }),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('apiKey.key')
                    ->label('API Key')
                    ->sortable(),
                Tables\Columns\TextColumn::make('apiPermission.label')
                    ->label('Permission')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListApiKeyPermissions::route('/'),
            'create' => Pages\CreateApiKeyPermission::route('/create'),
            'edit' => Pages\EditApiKeyPermission::route('/{record}/edit'),
        ];
    }
}
