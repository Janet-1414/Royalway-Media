<?php

namespace App\Filament\Pages;

use App\Models\AboutPage;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageAboutPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'About Page';

    protected static ?string $title = 'About Page';

    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.manage-about-page';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutPage::current()->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page banner')
                    ->schema([
                        Forms\Components\TextInput::make('hero_title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('hero_subtitle')
                            ->label('Short tagline (shown beside the title)')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('hero_image')
                            ->label('Banner background image')
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:5')
                            ->imageResizeTargetWidth('1920')
                            ->imageResizeTargetHeight('600')
                            ->helperText('Optional. A dark blue overlay is added automatically. Leave empty to use the default banner.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Who we are')
                    ->schema([
                        Forms\Components\TextInput::make('intro_badge')
                            ->label('Small label')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('intro_heading')
                            ->label('Heading')
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('intro_body')
                            ->label('Text')
                            ->toolbarButtons(['bold', 'italic', 'link', 'h3', 'bulletList', 'orderedList', 'undo', 'redo'])
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('intro_images')
                            ->label('Photos (up to 3)')
                            ->multiple()
                            ->maxFiles(3)
                            ->reorderable()
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->helperText('Shown as a photo collage next to the text. 1, 2 or 3 photos all work. Leave empty for a full width text block.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Key numbers')
                    ->description('Up to 4 number cards under the intro. Remove all to hide the row.')
                    ->schema([
                        Forms\Components\Repeater::make('stats')
                            ->schema([
                                Forms\Components\TextInput::make('value')->label('Number')->required()->placeholder('e.g. 15+'),
                                Forms\Components\TextInput::make('label')->label('Label')->required()->placeholder('e.g. Years of proven expertise'),
                            ])
                            ->columns(2)
                            ->maxItems(4)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['value'] ?? null)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Mission, vision and purpose')
                    ->schema([
                        Forms\Components\FileUpload::make('mission_image')
                            ->label('Photo')
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->imageEditor()
                            ->helperText('Portrait photo works best. Leave empty to keep the current photo.')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('mission')->rows(3),
                        Forms\Components\Textarea::make('vision')->rows(3),
                        Forms\Components\Textarea::make('purpose')->label('Our purpose')->rows(3),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Our strengths')
                    ->schema([
                        Forms\Components\TextInput::make('strengths_badge')
                            ->label('Small label')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('strengths_intro')
                            ->label('Intro sentence')
                            ->rows(2),

                        Forms\Components\FileUpload::make('strengths_image')
                            ->label('Background photo')
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->imageEditor()
                            ->helperText('Shown behind the cards. It is blurred and darkened automatically. Leave empty for plain blue.')
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('strengths')
                            ->label('Cards')
                            ->schema([
                                Forms\Components\Select::make('icon')
                                    ->options([
                                        'fa-circle-nodes' => 'Network',
                                        'fa-award' => 'Award',
                                        'fa-bolt' => 'Lightning',
                                        'fa-map-location-dot' => 'Map',
                                        'fa-location-dot' => 'Location pin',
                                        'fa-atom' => 'Atom',
                                        'fa-handshake' => 'Handshake',
                                        'fa-lightbulb' => 'Idea',
                                        'fa-bullseye' => 'Target',
                                        'fa-users' => 'People',
                                        'fa-chart-line' => 'Growth',
                                        'fa-globe' => 'Globe',
                                        'fa-shield-halved' => 'Shield',
                                        'fa-rocket' => 'Rocket',
                                        'fa-star' => 'Star',
                                        'fa-heart' => 'Heart',
                                    ])
                                    ->default('fa-star')
                                    ->required(),
                                Forms\Components\TextInput::make('title')->required(),
                                Forms\Components\Textarea::make('body')->label('Text')->rows(4)->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->collapsible()
                            ->addActionLabel('Add card')
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Closing banner')
                    ->schema([
                        Forms\Components\TextInput::make('cta_title')->label('Heading')->maxLength(255),
                        Forms\Components\Textarea::make('cta_text')->label('Text')->rows(2),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        AboutPage::current()->update($this->form->getState());

        Notification::make()
            ->title('About page saved')
            ->success()
            ->send();
    }
}
