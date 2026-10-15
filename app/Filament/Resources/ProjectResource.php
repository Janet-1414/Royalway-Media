<?php
/**
 * File Path: app/Filament/Resources/ProjectResource.php
 *
 * Run: php artisan make:filament-resource Project
 * Then replace content with this file
 */

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Project')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basics')
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

                                        Forms\Components\Select::make('partner_id')
                                            ->label('Partner / Client')
                                            ->relationship('partner', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                if ($state) {
                                                    $partner = \App\Models\Partner::find($state);
                                                    if ($partner) {
                                                        $set('client', $partner->name);
                                                        $set('client_logo', $partner->logo);
                                                    }
                                                }
                                            })
                                            ->nullable(),

                                        Forms\Components\TextInput::make('client')
                                            ->required()
                                            ->maxLength(255)
                                            ->helperText('Auto-filled from partner or enter manually'),

                                        Forms\Components\Select::make('category')
                                            ->required()
                                            ->options([
                                                'Strategic Communications' => 'Strategic Communications & Visibility',
                                                'PR & Media' => 'PR & Media Management',
                                                'Events Planning' => 'Events Planning & Management',
                                                'Experiential Marketing' => 'Experiential Marketing',
                                                'Behavioral Change' => 'Behavioral Change Communications',
                                            ]),

                                        Forms\Components\TextInput::make('location')
                                            ->maxLength(255)
                                            ->default('Uganda'),

                                        Forms\Components\DatePicker::make('project_date')
                                            ->label('Project Date'),

                                        Forms\Components\TextInput::make('tags')
                                            ->placeholder('Comma separated tags'),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Description')
                                    ->schema([
                                        Forms\Components\Textarea::make('description')
                                            ->required()
                                            ->rows(4)
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('lead')
                                            ->label('Lead / Introduction')
                                            ->rows(3)
                                            ->helperText('Opening paragraph shown at the top of the project page')
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Services')
                                    ->schema([
                                        Forms\Components\Select::make('services')
                                            ->label('Services Offered')
                                            ->relationship('services', 'title')
                                            ->multiple()
                                            ->preload()
                                            ->searchable()
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Publishing')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Featured Project'),

                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Published')
                                            ->default(true),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Story')
                            ->schema([
                                Forms\Components\Section::make('Headline Stats')
                                    ->schema([
                                        Forms\Components\Repeater::make('headline_stats')
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->required()
                                                    ->placeholder('e.g., 3,470'),
                                                Forms\Components\TextInput::make('label')
                                                    ->required()
                                                    ->placeholder('e.g., Children reached'),
                                            ])
                                            ->columns(2)
                                            ->maxItems(3)
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('Challenge / Story')
                                    ->schema([
                                        Forms\Components\RichEditor::make('challenge')
                                            ->label('Challenge')
                                            ->columnSpanFull(),

                                        Forms\Components\Repeater::make('narrative_blocks')
                                            ->label('Story Blocks')
                                            ->schema([
                                                Forms\Components\TextInput::make('heading')
                                                    ->required()
                                                    ->placeholder('Block heading'),
                                                Forms\Components\RichEditor::make('body')
                                                    ->required(),
                                            ])
                                            ->defaultItems(0)
                                            ->columnSpanFull()
                                            ->collapsible(),
                                    ]),

                                Forms\Components\Section::make('Side Card')
                                    ->schema([
                                        Forms\Components\TextInput::make('side_card_title')
                                            ->label('Side Card Title')
                                            ->placeholder('e.g., Services delivered')
                                            ->default('Services delivered'),

                                        Forms\Components\Repeater::make('side_card_items')
                                            ->label('Side Card Items')
                                            ->simple(
                                                Forms\Components\TextInput::make('item')
                                                    ->required()
                                                    ->placeholder('e.g., Strategic Communications')
                                            )
                                            ->defaultItems(0)
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Results (Variant A)')
                            ->schema([
                                Forms\Components\Section::make('Results Content')
                                    ->description('Use this for projects with quantitative results data')
                                    ->schema([
                                        Forms\Components\RichEditor::make('results')
                                            ->label('Results Summary')
                                            ->columnSpanFull(),

                                        Forms\Components\Repeater::make('result_channels')
                                            ->label('Result Channels (Progress Bars)')
                                            ->schema([
                                                Forms\Components\TextInput::make('label')
                                                    ->required()
                                                    ->placeholder('e.g., TV Broadcast'),
                                                Forms\Components\TextInput::make('percent')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->placeholder('e.g., 85'),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(0)
                                            ->columnSpanFull(),

                                        Forms\Components\Repeater::make('result_kpis')
                                            ->label('Result KPIs')
                                            ->schema([
                                                Forms\Components\TextInput::make('value')
                                                    ->required()
                                                    ->placeholder('e.g., 2.5M'),
                                                Forms\Components\TextInput::make('label')
                                                    ->required()
                                                    ->placeholder('e.g., Impressions'),
                                                Forms\Components\TextInput::make('note')
                                                    ->placeholder('e.g., +45% vs target'),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('results_footnote')
                                            ->label('Results Footnote')
                                            ->rows(2)
                                            ->helperText('Source attribution or additional context')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Outcome (Variant B)')
                            ->schema([
                                Forms\Components\Section::make('Outcome Content')
                                    ->description('Use this for projects without quantitative results - shows a dark callout box')
                                    ->schema([
                                        Forms\Components\Textarea::make('outcome_text')
                                            ->label('Outcome Text')
                                            ->rows(4)
                                            ->helperText('Qualitative outcome description shown in a dark callout')
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Media')
                            ->schema([
                                Forms\Components\Section::make('Images')
                                    ->schema([
                                        Forms\Components\FileUpload::make('featured_image')
                                            ->required()
                                            ->image()
                                            ->disk('public')
                                            ->directory('projects/featured')
                                            ->imageEditor(),

                                        Forms\Components\FileUpload::make('client_logo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('projects/logos')
                                            ->imageEditor()
                                            ->helperText('Auto-filled from partner or upload manually'),

                                        Forms\Components\FileUpload::make('gallery')
                                            ->multiple()
                                            ->image()
                                            ->disk('public')
                                            ->directory('projects/gallery')
                                            ->imageEditor()
                                            ->reorderable()
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Downloads & Links')
                                    ->schema([
                                        Forms\Components\TextInput::make('report_url')
                                            ->label('Full Report URL')
                                            ->url()
                                            ->placeholder('https://...'),

                                        Forms\Components\FileUpload::make('summary_pdf')
                                            ->label('Summary PDF')
                                            ->disk('public')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->directory('projects/summaries'),

                                        Forms\Components\FileUpload::make('download_link')
                                            ->label('Legacy Download (PDF)')
                                            ->disk('public')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->directory('projects/downloads'),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                Forms\Components\Section::make('Search Engine Optimization')
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
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->disk('public')
                    ->size(60),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('project_date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category'),
                Tables\Filters\TernaryFilter::make('is_featured'),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
