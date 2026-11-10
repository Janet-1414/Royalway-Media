<?php

namespace App\Filament\Pages;

use App\Models\PageHero;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManagePageHeroes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?string $navigationLabel = 'Page Heroes';

    protected static ?string $title = 'Page Heroes';

    protected static ?int $navigationSort = 11;

    protected static string $view = 'filament.pages.manage-page-heroes';

    public ?array $data = [];

    public function mount(): void
    {
        $state = [];

        foreach (array_keys(PageHero::PAGES) as $key) {
            $state[$key] = PageHero::forKey($key)->only(['heading', 'intro', 'image']);
        }

        $this->form->fill($state);
    }

    public function form(Form $form): Form
    {
        $tabs = [];

        foreach (PageHero::PAGES as $key => $label) {
            $tabs[] = Forms\Components\Tabs\Tab::make($label)
                ->schema([
                    Forms\Components\TextInput::make("{$key}.heading")
                        ->label('Heading')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make("{$key}.intro")
                        ->label('Intro text')
                        ->rows(4)
                        ->maxLength(600),

                    Forms\Components\FileUpload::make("{$key}.image")
                        ->label('Image')
                        ->image()
                        ->disk('public')
                        ->directory('page-heroes')
                        ->imageEditor()
                        ->imageCropAspectRatio('4:5')
                        ->imageEditorAspectRatios(['4:5'])
                        ->helperText('Portrait image, shown in a rounded card beside the heading. Leave empty to use the brand colour panel.'),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Tabs::make('Pages')
                    ->tabs($tabs)
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (array_keys(PageHero::PAGES) as $key) {
            PageHero::forKey($key)->update([
                'heading' => $state[$key]['heading'] ?? null,
                'intro' => $state[$key]['intro'] ?? null,
                'image' => $state[$key]['image'] ?? null,
            ]);
        }

        Notification::make()
            ->title('Page heroes saved')
            ->success()
            ->send();
    }
}
