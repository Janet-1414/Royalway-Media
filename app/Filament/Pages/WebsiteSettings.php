<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class WebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $title = 'Website Settings';
    protected static string $view = 'filament.pages.website-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            // General
            'site_name' => SiteSetting::get('site_name', 'RoyalWay Media'),
            'logo' => SiteSetting::get('logo'),
            'logo_white' => SiteSetting::get('logo_white'),
            'favicon' => SiteSetting::get('favicon'),
            'footer_about' => SiteSetting::get('footer_about'),
            'copyright_name' => SiteSetting::get('copyright_name', 'RoyalWay Media Ltd'),
            'company_profile_pdf' => SiteSetting::get('company_profile_pdf'),
            'company_profile_url' => SiteSetting::get('company_profile_url'),

            // Contact
            'contact_email' => SiteSetting::get('contact_email', 'sales@royalwaymedia.com'),
            'phones' => json_decode(SiteSetting::get('phones', '[]'), true) ?: [],
            'address' => SiteSetting::get('address'),
            'po_box' => SiteSetting::get('po_box'),
            'office_hours' => SiteSetting::get('office_hours'),
            'google_maps_embed' => SiteSetting::get('google_maps_embed'),
            'google_business_url' => SiteSetting::get('google_business_url'),

            // Social
            'social_facebook' => SiteSetting::get('social_facebook'),
            'social_twitter' => SiteSetting::get('social_twitter'),
            'social_linkedin' => SiteSetting::get('social_linkedin'),
            'social_instagram' => SiteSetting::get('social_instagram'),
            'social_youtube' => SiteSetting::get('social_youtube'),

            // Homepage
            'hero_title' => SiteSetting::get('hero_title'),
            'hero_subtitle' => SiteSetting::get('hero_subtitle'),
            'hero_button1_label' => SiteSetting::get('hero_button1_label', 'Start a Project'),
            'hero_button1_link' => SiteSetting::get('hero_button1_link'),
            'hero_button2_label' => SiteSetting::get('hero_button2_label', 'Our Work'),
            'hero_button2_link' => SiteSetting::get('hero_button2_link'),
            'hero_video' => SiteSetting::get('hero_video'),
            'hero_poster' => SiteSetting::get('hero_poster'),
            'homepage_stats' => json_decode(SiteSetting::get('homepage_stats', '[]'), true) ?: [],

            // CTA Section
            'cta_title' => SiteSetting::get('cta_title', 'Ready to tell your story?'),
            'cta_subtitle' => SiteSetting::get('cta_subtitle'),
            'cta_button_text' => SiteSetting::get('cta_button_text', 'Start a Project'),
            'cta_button_link' => SiteSetting::get('cta_button_link', '/contact'),
            'cta_show_whatsapp' => SiteSetting::get('cta_show_whatsapp') === '1',

            // About Section Images
            'about_slider_images' => json_decode(SiteSetting::get('about_slider_images', '[]'), true) ?: [],
            'about_image_2' => SiteSetting::get('about_image_2'),

            // WhatsApp
            'whatsapp_enabled' => SiteSetting::get('whatsapp_enabled') === '1' || SiteSetting::get('whatsapp_enabled') === 'true',
            'whatsapp_number' => SiteSetting::get('whatsapp_number'),
            'whatsapp_display_name' => SiteSetting::get('whatsapp_display_name', 'RoyalWay Media'),
            'whatsapp_greeting' => SiteSetting::get('whatsapp_greeting'),
            'whatsapp_prefill' => SiteSetting::get('whatsapp_prefill'),
            'whatsapp_position' => SiteSetting::get('whatsapp_position', 'right'),

            // SEO
            'seo_title' => SiteSetting::get('seo_title'),
            'seo_description' => SiteSetting::get('seo_description'),
            'seo_og_image' => SiteSetting::get('seo_og_image'),
            'google_search_console' => SiteSetting::get('google_search_console'),
            'google_analytics_id' => SiteSetting::get('google_analytics_id'),

            // Security
            'spam_blocked_words' => SiteSetting::get('spam_blocked_words', ''),
            'spam_blocked_domains' => SiteSetting::get('spam_blocked_domains', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Settings')
                    ->tabs([
                        // General Tab
                        Forms\Components\Tabs\Tab::make('General')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('The name of your website'),

                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\FileUpload::make('logo')
                                        ->label('Logo')
                                        ->disk('public')
                                        ->directory('site')
                                        ->image()
                                        ->helperText('Main logo for light backgrounds'),

                                    Forms\Components\FileUpload::make('logo_white')
                                        ->label('White Logo')
                                        ->disk('public')
                                        ->directory('site')
                                        ->image()
                                        ->helperText('Logo for dark backgrounds/footer'),
                                ]),

                                Forms\Components\FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->disk('public')
                                    ->directory('site')
                                    ->image()
                                    ->helperText('Browser tab icon (32x32 PNG recommended)'),

                                Forms\Components\Textarea::make('footer_about')
                                    ->label('Footer About Text')
                                    ->rows(3)
                                    ->helperText('Brief description shown in footer'),

                                Forms\Components\TextInput::make('copyright_name')
                                    ->label('Copyright Name')
                                    ->helperText('Company name for copyright notice'),

                                Forms\Components\Section::make('Company Profile')
                                    ->schema([
                                        Forms\Components\FileUpload::make('company_profile_pdf')
                                            ->label('Company Profile PDF')
                                            ->disk('public')
                                            ->directory('site')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(10240)
                                            ->helperText('Upload company profile PDF (max 10MB)'),

                                        Forms\Components\TextInput::make('company_profile_url')
                                            ->label('Company Profile URL (Fallback)')
                                            ->url()
                                            ->helperText('External URL if no PDF uploaded'),
                                    ])->columns(2),
                            ]),

                        // Contact Tab
                        Forms\Components\Tabs\Tab::make('Contact')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Forms\Components\TextInput::make('contact_email')
                                    ->label('Primary Email')
                                    ->email()
                                    ->required()
                                    ->helperText('Main contact email address'),

                                Forms\Components\Repeater::make('phones')
                                    ->label('Phone Numbers')
                                    ->schema([
                                        Forms\Components\TextInput::make('number')
                                            ->label('Phone Number')
                                            ->tel()
                                            ->required(),
                                        Forms\Components\TextInput::make('label')
                                            ->label('Label')
                                            ->placeholder('e.g., Mobile, Office'),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(1)
                                    ->helperText('Add multiple contact numbers'),

                                Forms\Components\Textarea::make('address')
                                    ->label('Physical Address')
                                    ->rows(2),

                                Forms\Components\TextInput::make('po_box')
                                    ->label('P.O. Box'),

                                Forms\Components\TextInput::make('office_hours')
                                    ->label('Office Hours')
                                    ->placeholder('Mon – Fri: 8:00am – 6:00pm'),

                                Forms\Components\Textarea::make('google_maps_embed')
                                    ->label('Google Maps Embed URL')
                                    ->rows(2)
                                    ->helperText('Full iframe src URL from Google Maps'),

                                Forms\Components\TextInput::make('google_business_url')
                                    ->label('Google Business Profile URL')
                                    ->url(),
                            ]),

                        // Social Media Tab
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\TextInput::make('social_facebook')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('social_twitter')
                                    ->label('X (Twitter) URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('social_linkedin')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('social_instagram')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),

                                Forms\Components\TextInput::make('social_youtube')
                                    ->label('YouTube URL')
                                    ->url()
                                    ->prefixIcon('heroicon-o-link'),
                            ]),

                        // Homepage Tab
                        Forms\Components\Tabs\Tab::make('Homepage')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Section::make('Hero Content')
                                    ->schema([
                                        Forms\Components\TextInput::make('hero_title')
                                            ->label('Hero Title')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('hero_subtitle')
                                            ->label('Hero Subtitle')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('hero_button1_label')
                                                ->label('Button 1 Label'),
                                            Forms\Components\TextInput::make('hero_button1_link')
                                                ->label('Button 1 Link'),
                                        ]),

                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('hero_button2_label')
                                                ->label('Button 2 Label'),
                                            Forms\Components\TextInput::make('hero_button2_link')
                                                ->label('Button 2 Link'),
                                        ]),
                                    ]),

                                Forms\Components\Section::make('Hero Media')
                                    ->schema([
                                        Forms\Components\FileUpload::make('hero_video')
                                            ->label('Hero Video')
                                            ->disk('public')
                                            ->directory('site/hero')
                                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                                            ->maxSize(51200)
                                            ->helperText('MP4 (H.264), under 50MB, 1920x1080, 10-30s recommended'),

                                        Forms\Components\FileUpload::make('hero_poster')
                                            ->label('Hero Poster Image')
                                            ->disk('public')
                                            ->directory('site/hero')
                                            ->image()
                                            ->imageEditor()
                                            ->helperText('Shown while video loads and on mobile data saver'),
                                    ])->columns(2),

                                Forms\Components\Section::make('Statistics')
                                    ->schema([
                                        Forms\Components\Repeater::make('homepage_stats')
                                            ->label('Stats')
                                            ->schema([
                                                Forms\Components\TextInput::make('number')
                                                    ->label('Number')
                                                    ->required()
                                                    ->placeholder('10+'),
                                                Forms\Components\TextInput::make('label')
                                                    ->label('Label')
                                                    ->required()
                                                    ->placeholder('Years of Experience'),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(3)
                                            ->maxItems(4),
                                    ]),

                                Forms\Components\Section::make('Call to Action Section')
                                    ->description('The CTA band between Services and Projects sections')
                                    ->schema([
                                        Forms\Components\TextInput::make('cta_title')
                                            ->label('CTA Title')
                                            ->maxLength(255),

                                        Forms\Components\Textarea::make('cta_subtitle')
                                            ->label('CTA Subtitle')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)->schema([
                                            Forms\Components\TextInput::make('cta_button_text')
                                                ->label('Button Text'),
                                            Forms\Components\TextInput::make('cta_button_link')
                                                ->label('Button Link'),
                                        ]),

                                        Forms\Components\Toggle::make('cta_show_whatsapp')
                                            ->label('Show WhatsApp Button')
                                            ->helperText('Display a "Chat on WhatsApp" button alongside the primary button'),
                                    ]),

                                Forms\Components\Section::make('About Section Images')
                                    ->description('Images for the About Us section on the homepage')
                                    ->schema([
                                        Forms\Components\FileUpload::make('about_slider_images')
                                            ->label('About Slider Images (Left)')
                                            ->disk('public')
                                            ->directory('site/about')
                                            ->image()
                                            ->multiple()
                                            ->reorderable()
                                            ->maxFiles(5)
                                            ->helperText('Upload up to 5 images for the crossfade slider'),

                                        Forms\Components\FileUpload::make('about_image_2')
                                            ->label('About Second Image (Right)')
                                            ->disk('public')
                                            ->directory('site/about')
                                            ->image()
                                            ->helperText('The smaller right-side image'),
                                    ])->columns(2),
                            ]),

                        // WhatsApp Tab
                        Forms\Components\Tabs\Tab::make('WhatsApp')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Forms\Components\Toggle::make('whatsapp_enabled')
                                    ->label('Enable WhatsApp Widget')
                                    ->helperText('Show floating WhatsApp button on the website'),

                                Forms\Components\TextInput::make('whatsapp_number')
                                    ->label('WhatsApp Number')
                                    ->placeholder('256772464686')
                                    ->helperText('Number with country code, no + or spaces'),

                                Forms\Components\TextInput::make('whatsapp_display_name')
                                    ->label('Display Name')
                                    ->placeholder('RoyalWay Media'),

                                Forms\Components\Textarea::make('whatsapp_greeting')
                                    ->label('Greeting Message')
                                    ->rows(3)
                                    ->helperText('Message shown in the chat popup'),

                                Forms\Components\Textarea::make('whatsapp_prefill')
                                    ->label('Pre-filled Chat Message')
                                    ->rows(2)
                                    ->helperText('Message that appears when user opens WhatsApp'),

                                Forms\Components\Select::make('whatsapp_position')
                                    ->label('Button Position')
                                    ->options([
                                        'right' => 'Bottom Right',
                                        'left' => 'Bottom Left',
                                    ])
                                    ->default('right'),
                            ]),

                        // SEO Tab
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('Default Meta Title')
                                    ->live(onBlur: true)
                                    ->helperText(fn ($state) => strlen($state ?? '') . ' / 60 characters — longer titles may be truncated in Google'),

                                Forms\Components\Textarea::make('seo_description')
                                    ->label('Default Meta Description')
                                    ->rows(3)
                                    ->live(onBlur: true)
                                    ->helperText(fn ($state) => strlen($state ?? '') . ' / 160 characters — longer descriptions may be truncated'),

                                Forms\Components\FileUpload::make('seo_og_image')
                                    ->label('Default OG Image')
                                    ->disk('public')
                                    ->directory('site')
                                    ->image()
                                    ->helperText('Default image for social sharing (1200x630 recommended)'),

                                Forms\Components\TextInput::make('google_search_console')
                                    ->label('Google Search Console Verification')
                                    ->placeholder('google-site-verification=...')
                                    ->helperText('The content value from the verification meta tag'),

                                Forms\Components\TextInput::make('google_analytics_id')
                                    ->label('Google Analytics Measurement ID')
                                    ->placeholder('G-XXXXXXXXXX')
                                    ->helperText('GA4 Measurement ID'),
                            ]),

                        // Security Tab
                        Forms\Components\Tabs\Tab::make('Security')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Forms\Components\Section::make('Spam Protection')
                                    ->description('Configure blocked words and domains for contact forms')
                                    ->schema([
                                        Forms\Components\Textarea::make('spam_blocked_words')
                                            ->label('Blocked Words / Phrases')
                                            ->rows(10)
                                            ->helperText('One word or phrase per line. Messages containing any of these will be silently blocked.'),

                                        Forms\Components\Textarea::make('spam_blocked_domains')
                                            ->label('Blocked Email Domains')
                                            ->rows(6)
                                            ->helperText('One domain per line (e.g., mail.ru). Emails from these domains will be blocked.'),
                                    ])->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Helper to save and clean up old files
        $saveFile = function ($key, $value, $type = 'file', $group = 'general') {
            $old = SiteSetting::get($key);
            if ($value) {
                SiteSetting::set($key, $value, $type, $group);
                if ($old && $old !== $value && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            } else {
                SiteSetting::where('key', $key)->delete();
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
        };

        // General
        SiteSetting::set('site_name', $data['site_name'] ?? '', 'text', 'general');
        $saveFile('logo', $data['logo'] ?? null, 'image', 'general');
        $saveFile('logo_white', $data['logo_white'] ?? null, 'image', 'general');
        $saveFile('favicon', $data['favicon'] ?? null, 'image', 'general');
        SiteSetting::set('footer_about', $data['footer_about'] ?? '', 'textarea', 'general');
        SiteSetting::set('copyright_name', $data['copyright_name'] ?? '', 'text', 'general');
        $saveFile('company_profile_pdf', $data['company_profile_pdf'] ?? null, 'file', 'general');
        SiteSetting::set('company_profile_url', $data['company_profile_url'] ?? '', 'url', 'general');

        // Contact
        SiteSetting::set('contact_email', $data['contact_email'] ?? '', 'email', 'contact');
        SiteSetting::set('phones', json_encode($data['phones'] ?? []), 'json', 'contact');
        SiteSetting::set('address', $data['address'] ?? '', 'textarea', 'contact');
        SiteSetting::set('po_box', $data['po_box'] ?? '', 'text', 'contact');
        SiteSetting::set('office_hours', $data['office_hours'] ?? '', 'text', 'contact');
        SiteSetting::set('google_maps_embed', $data['google_maps_embed'] ?? '', 'textarea', 'contact');
        SiteSetting::set('google_business_url', $data['google_business_url'] ?? '', 'url', 'contact');

        // Social
        SiteSetting::set('social_facebook', $data['social_facebook'] ?? '', 'url', 'social');
        SiteSetting::set('social_twitter', $data['social_twitter'] ?? '', 'url', 'social');
        SiteSetting::set('social_linkedin', $data['social_linkedin'] ?? '', 'url', 'social');
        SiteSetting::set('social_instagram', $data['social_instagram'] ?? '', 'url', 'social');
        SiteSetting::set('social_youtube', $data['social_youtube'] ?? '', 'url', 'social');

        // Homepage
        SiteSetting::set('hero_title', $data['hero_title'] ?? '', 'text', 'homepage');
        SiteSetting::set('hero_subtitle', $data['hero_subtitle'] ?? '', 'textarea', 'homepage');
        SiteSetting::set('hero_button1_label', $data['hero_button1_label'] ?? '', 'text', 'homepage');
        SiteSetting::set('hero_button1_link', $data['hero_button1_link'] ?? '', 'text', 'homepage');
        SiteSetting::set('hero_button2_label', $data['hero_button2_label'] ?? '', 'text', 'homepage');
        SiteSetting::set('hero_button2_link', $data['hero_button2_link'] ?? '', 'text', 'homepage');
        $saveFile('hero_video', $data['hero_video'] ?? null, 'file', 'homepage');
        $saveFile('hero_poster', $data['hero_poster'] ?? null, 'image', 'homepage');
        SiteSetting::set('homepage_stats', json_encode($data['homepage_stats'] ?? []), 'json', 'homepage');

        // CTA
        SiteSetting::set('cta_title', $data['cta_title'] ?? '', 'text', 'homepage');
        SiteSetting::set('cta_subtitle', $data['cta_subtitle'] ?? '', 'textarea', 'homepage');
        SiteSetting::set('cta_button_text', $data['cta_button_text'] ?? '', 'text', 'homepage');
        SiteSetting::set('cta_button_link', $data['cta_button_link'] ?? '', 'text', 'homepage');
        SiteSetting::set('cta_show_whatsapp', $data['cta_show_whatsapp'] ? '1' : '0', 'boolean', 'homepage');

        // About Images
        SiteSetting::set('about_slider_images', json_encode($data['about_slider_images'] ?? []), 'json', 'homepage');
        $saveFile('about_image_2', $data['about_image_2'] ?? null, 'image', 'homepage');

        // WhatsApp
        SiteSetting::set('whatsapp_enabled', $data['whatsapp_enabled'] ? '1' : '0', 'boolean', 'whatsapp');
        SiteSetting::set('whatsapp_number', $data['whatsapp_number'] ?? '', 'text', 'whatsapp');
        SiteSetting::set('whatsapp_display_name', $data['whatsapp_display_name'] ?? '', 'text', 'whatsapp');
        SiteSetting::set('whatsapp_greeting', $data['whatsapp_greeting'] ?? '', 'textarea', 'whatsapp');
        SiteSetting::set('whatsapp_prefill', $data['whatsapp_prefill'] ?? '', 'textarea', 'whatsapp');
        SiteSetting::set('whatsapp_position', $data['whatsapp_position'] ?? 'right', 'text', 'whatsapp');

        // SEO
        SiteSetting::set('seo_title', $data['seo_title'] ?? '', 'text', 'seo');
        SiteSetting::set('seo_description', $data['seo_description'] ?? '', 'textarea', 'seo');
        $saveFile('seo_og_image', $data['seo_og_image'] ?? null, 'image', 'seo');
        SiteSetting::set('google_search_console', $data['google_search_console'] ?? '', 'text', 'seo');
        SiteSetting::set('google_analytics_id', $data['google_analytics_id'] ?? '', 'text', 'seo');

        // Security
        SiteSetting::set('spam_blocked_words', $data['spam_blocked_words'] ?? '', 'textarea', 'security');
        SiteSetting::set('spam_blocked_domains', $data['spam_blocked_domains'] ?? '', 'textarea', 'security');

        // Clear cache
        Cache::forget('site_settings');

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
