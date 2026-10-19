<?php
/**
 * File Path: app/Filament/Resources/ServiceResource.php
 *
 * Run: php artisan make:filament-resource Service
 * Then replace content with this file
 */

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 2;

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

                        Forms\Components\TextInput::make('tagline')
                            ->maxLength(255)
                            ->helperText('Short tagline shown in hero section'),

                        Forms\Components\Select::make('category')
                            ->options([
                                'Media & PR' => 'Media & PR',
                                'Events & Activations' => 'Events & Activations',
                                'Creative & Production' => 'Creative & Production',
                                'Strategy & Research' => 'Strategy & Research',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('headline')
                            ->maxLength(255)
                            ->helperText('Short impactful headline for the service page'),

                        Forms\Components\Textarea::make('short_description')
                            ->required()
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('intro')
                            ->label('Introduction')
                            ->rows(4)
                            ->helperText('Opening paragraph for the service detail page')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Service Features')
                    ->schema([
                        Forms\Components\TagsInput::make('checklist')
                            ->label('Checklist Items')
                            ->helperText('Key features/services offered (max 6 items)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Detailed Information')
                    ->schema([
                        Forms\Components\RichEditor::make('full_description')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content')
                            ->label('Extended Content')
                            ->helperText('Additional rich content for the service page')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Features List')
                    ->schema([
                        Forms\Components\Repeater::make('features')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->rows(2),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    ]),

                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('icon')
                            ->label('Service Icon')
                            ->image()
                            ->disk('public')
                            ->directory('services/icons')
                            ->imageEditor(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Card Image (Square)')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('services/images')
                            ->imageEditor()
                            ->helperText('Square image for service cards'),

                        Forms\Components\FileUpload::make('poster_image')
                            ->label('Poster Image')
                            ->image()
                            ->disk('public')
                            ->directory('services/posters')
                            ->imageEditor()
                            ->helperText('Large image for service detail page'),

                        Forms\Components\FileUpload::make('gallery')
                            ->label('Gallery Images')
                            ->multiple()
                            ->image()
                            ->disk('public')
                            ->directory('services/gallery')
                            ->reorderable()
                            ->helperText('Materials/work samples gallery'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->default(false)
                            ->helperText('Home page shows 8 featured services'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->live(onBlur: true)
                            ->helperText(fn ($state) => strlen($state ?? '') . ' / 60 characters — longer titles may be truncated in Google'),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->live(onBlur: true)
                            ->helperText(fn ($state) => strlen($state ?? '') . ' / 160 characters — longer descriptions may be truncated'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->width(50),

                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('short_description')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Media & PR' => 'Media & PR',
                        'Events & Activations' => 'Events & Activations',
                        'Creative & Production' => 'Creative & Production',
                        'Strategy & Research' => 'Strategy & Research',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_active'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
