<?php
/**
 * File Path: app/Filament/Resources/PolicyResource.php
 *
 * Run: php artisan make:filament-resource Policy
 * Then replace content with this file
 */

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Models\Policy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PolicyResource extends Resource
{
    protected static ?string $model = Policy::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\TextInput::make('badge_text')
                            ->maxLength(255)
                            ->placeholder('e.g., Ethical Today, Thriving Tomorrow'),

                        Forms\Components\TextInput::make('version')
                            ->default('1.0')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Policy Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                            ]),
                    ]),

                Forms\Components\Section::make('Sidebar Information')
                    ->schema([
                        Forms\Components\FileUpload::make('sidebar_image')
                            ->image()
                            ->directory('policies/sidebar')
                            ->imageEditor(),

                        Forms\Components\Repeater::make('contact_info')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'email' => 'Email',
                                        'phone' => 'Phone',
                                        'office_hours' => 'Office Hours',
                                        'address' => 'Address',
                                    ])
                                    ->required(),

                                Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->placeholder('e.g., Email, Phone, Office hours'),

                                Forms\Components\Textarea::make('value')
                                    ->required()
                                    ->rows(2)
                                    ->placeholder('Contact information'),
                            ])
                            ->columns(3)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->collapsible(),
                    ]),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\DatePicker::make('effective_date')
                            ->label('Effective Date'),

                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('version')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('effective_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListPolicies::route('/'),
            'create' => Pages\CreatePolicy::route('/create'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }
}
