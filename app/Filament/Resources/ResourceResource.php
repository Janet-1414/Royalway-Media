<?php
/**
 * File Path: app/Filament/Resources/ResourceResource.php
 *
 * Run: php artisan make:filament-resource Resource --model=Resource
 * Then replace content with this file
 */

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Models\Resource as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 4;

    protected static ?string $label = 'Resource';

    public static function form(Form $form): Form
    {
        $isBlog = fn (Get $get) => $get('type') === 'blog';
        $isAsset = fn (Get $get) => $get('type') === 'communication_asset';

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

                        Forms\Components\Select::make('type')
                            ->required()
                            ->live()
                            ->options(ResourceModel::TYPE_LABELS)
                            ->in(array_keys(ResourceModel::TYPE_LABELS))
                            ->validationMessages(['in' => 'Choose News & Insights or Communication Asset so this item shows on the website.'])
                            ->helperText(fn (?ResourceModel $record) => $record && ! in_array($record->type, ResourceModel::PUBLIC_TYPES, true)
                                ? 'This item uses an old type and is hidden from the website. Choose a type to show it again.'
                                : null),

                        Forms\Components\TextInput::make('topic')
                            ->maxLength(100)
                            ->datalist(fn () => ResourceModel::query()
                                ->whereNotNull('topic')
                                ->where('topic', '!=', '')
                                ->distinct()
                                ->orderBy('topic')
                                ->pluck('topic')
                                ->all())
                            ->helperText(fn (Get $get) => $isAsset($get)
                                ? 'Groups related assets, for example Flyers, Reports or Brand Guidelines.'
                                : 'Used for the topic filters on News & Insights, for example Public Relations or Branding.')
                            ->visible(fn (Get $get) => $isBlog($get) || $isAsset($get)),

                        Forms\Components\TextInput::make('author')
                            ->maxLength(255)
                            ->hidden($isAsset),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(fn (Get $get) => $isAsset($get) ? 'Description' : 'Content')
                    ->schema([
                        Forms\Components\Textarea::make('excerpt')
                            ->label(fn (Get $get) => $isAsset($get) ? 'Short description' : 'Excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText(fn (Get $get) => $isAsset($get)
                                ? 'One or two sentences shown on the asset card and the asset page.'
                                : 'Shown on cards and used as the description when the link is shared.')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('content')
                            ->columnSpanFull()
                            ->hidden($isAsset),
                    ]),

                Forms\Components\Section::make(fn (Get $get) => $isAsset($get) ? 'Document & Image' : 'Media & Files')
                    ->schema([
                        Forms\Components\FileUpload::make('featured_image')
                            ->label(fn (Get $get) => $isAsset($get) ? 'Image' : 'Featured image')
                            ->helperText(fn (Get $get) => $isAsset($get) ? 'Cover image shown on the asset card and page.' : null)
                            ->image()
                            ->disk('public')
                            ->directory('resources/images')
                            ->imageEditor(),

                        // Article only. Assets always show their image, so the toggle is saved as on for them
                        Forms\Components\Toggle::make('show_cover')
                            ->label('Show cover image')
                            ->helperText('Turn off to display this resource without an image')
                            ->default(true)
                            ->hidden($isAsset)
                            ->dehydratedWhenHidden()
                            ->dehydrateStateUsing(fn ($state, Get $get) => $isAsset($get) ? true : (bool) $state),

                        Forms\Components\FileUpload::make('file')
                            ->label(fn (Get $get) => $isAsset($get) ? 'Document' : 'File')
                            ->disk('public')
                            ->directory('resources/files')
                            ->acceptedFileTypes(fn (Get $get) => $isAsset($get)
                                ? ResourceModel::DOCUMENT_MIME_TYPES
                                : ResourceModel::UPLOAD_MIME_TYPES)
                            ->maxSize(51200)
                            ->downloadable()
                            ->openable()
                            ->live()
                            ->helperText(fn (Get $get) => $isAsset($get)
                                ? 'PDF, Word (DOC, DOCX), PowerPoint (PPT, PPTX) or Excel (XLS, XLSX). Up to 50 MB.'
                                : 'PDF, images (JPG, PNG, WEBP, GIF), Word, Excel, PowerPoint, CSV, TXT, MP4, WEBM or MP3. Up to 50 MB.')
                            ->visible(fn (Get $get, ?ResourceModel $record) => $isAsset($get) || filled($record?->file)),

                        Forms\Components\Placeholder::make('detected_file_type')
                            ->label('Detected file type')
                            ->content(fn (Get $get) => static::describeFile($get('file')))
                            ->visible(fn (Get $get, ?ResourceModel $record) => $isAsset($get) || filled($record?->file)),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Related projects')
                    ->schema([
                        Forms\Components\Select::make('projects')
                            ->label('Related projects')
                            ->relationship('projects', 'title')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->helperText('The asset appears under Campaign materials on these project pages.')
                            ->columnSpanFull(),
                    ])
                    ->visible($isAsset),

                Forms\Components\Section::make('Publishing')
                    ->schema([
                        Forms\Components\DatePicker::make('published_at')
                            ->label('Publish Date'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Lead story')
                            ->helperText('Shown as the large lead story on News & Insights. If none is chosen, the newest article is used.')
                            ->visible($isBlog),

                        Forms\Components\Toggle::make('allow_comments')
                            ->label('Allow comments')
                            ->helperText('Comments also need to be switched on in Website Settings.')
                            ->default(true)
                            ->visible($isBlog),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->live(onBlur: true)
                            ->helperText(fn ($state) => strlen($state ?? '') . ' / 60 characters. Longer titles may be truncated in Google.'),

                        Forms\Components\Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(2)
                            ->live(onBlur: true)
                            ->helperText(fn ($state) => strlen($state ?? '') . ' / 160 characters. Longer descriptions may be truncated.'),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    /**
     * Readable file type for the uploaded or stored file
     */
    protected static function describeFile($state): string
    {
        $file = is_array($state) ? collect($state)->first() : $state;

        if ($file instanceof TemporaryUploadedFile) {
            $extension = strtolower($file->getClientOriginalExtension());
        } elseif (is_string($file) && $file !== '') {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        } else {
            return 'No file uploaded';
        }

        $group = 'Other';
        foreach (ResourceModel::FILE_GROUPS as $key => $extensions) {
            if (in_array($extension, $extensions, true)) {
                $group = ResourceModel::FILE_GROUP_LABELS[$key];
            }
        }

        return strtoupper($extension) . ' (' . $group . ')';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->disk('public')
                    ->size(60),

                Tables\Columns\ToggleColumn::make('show_cover')
                    ->label('Cover'),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => ResourceModel::TYPE_LABELS[$state] ?? 'Hidden (old type)')
                    ->color(fn (string $state) => match ($state) {
                        'blog' => 'primary',
                        'communication_asset' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('topic')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(fn ($state) => strtoupper(pathinfo((string) $state, PATHINFO_EXTENSION)))
                    ->badge()
                    ->color('gray')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('author')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Lead')
                    ->disabled(fn (ResourceModel $record) => $record->type !== 'blog')
                    ->toggleable(),

                Tables\Columns\IconColumn::make('allow_comments')
                    ->label('Comments')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(ResourceModel::TYPE_LABELS),
                Tables\Filters\Filter::make('hidden_old_types')
                    ->label('Hidden from website (old types)')
                    ->query(fn (Builder $query) => $query->whereNotIn('type', ResourceModel::PUBLIC_TYPES)),
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
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
        ];
    }
}
