<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class SiteSettingDefaultsSeeder extends Seeder
{
    /**
     * Seed default site settings (idempotent - only creates missing keys)
     */
    public function run(): void
    {
        $defaults = [
            // General
            ['key' => 'site_name', 'value' => 'RoyalWay Media', 'type' => 'text', 'group' => 'general'],
            ['key' => 'copyright_name', 'value' => 'RoyalWay Media Ltd', 'type' => 'text', 'group' => 'general'],
            ['key' => 'footer_about', 'value' => 'At RoyalWay Media, we redefine excellence in integrated marketing and communications. Specializing in PR, Branding, Marketing, and Behavioral Change Communications, we transform ambitions into thriving brands.', 'type' => 'textarea', 'group' => 'general'],

            // Contact
            ['key' => 'contact_email', 'value' => 'sales@royalwaymedia.com', 'type' => 'email', 'group' => 'contact'],
            ['key' => 'phones', 'value' => json_encode([
                ['number' => '+256 772 464 686', 'label' => 'Mobile'],
                ['number' => '+256 312 284 552', 'label' => 'Office'],
                ['number' => '+256 774 038 086', 'label' => 'Mobile'],
            ]), 'type' => 'json', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda', 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'po_box', 'value' => 'P.O. Box 70348 Kampala', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'office_hours', 'value' => 'Mon – Fri: 8:00am – 6:00pm', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.748448252334!2d32.5882796!3d0.3390889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbba674754169%3A0x8a9ed4e73dc4c5b3!2sRoyalWay%20Media!5e0!3m2!1sen!2sug!4v1761603434898!5m2!1sen!2sug', 'type' => 'textarea', 'group' => 'contact'],

            // Social Media
            ['key' => 'social_facebook', 'value' => 'https://www.facebook.com/RoyalWayMediaLtd/', 'type' => 'url', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://twitter.com/RoyalWayMedia', 'type' => 'url', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://www.linkedin.com/company/royalway-media', 'type' => 'url', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/royalwaymedia', 'type' => 'url', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://www.youtube.com/channel/UC5292sL9n6DTH7p7Yh8HmOg/videos', 'type' => 'url', 'group' => 'social'],

            // Homepage
            ['key' => 'hero_title', 'value' => 'RoyalWay Media: Where Communications is catalyst for growth', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hero_subtitle', 'value' => 'We work with ambitious people and companies to help through creation, reinvention, or transformation of their brand.', 'type' => 'textarea', 'group' => 'homepage'],
            ['key' => 'hero_button1_label', 'value' => 'Start a Project', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hero_button1_link', 'value' => '/contact', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hero_button2_label', 'value' => 'Our Work', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hero_button2_link', 'value' => '/projects', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'homepage_stats', 'value' => json_encode([
                ['number' => '10+', 'label' => 'Years of Experience'],
                ['number' => '10+', 'label' => 'Awards Won'],
                ['number' => '150+', 'label' => 'Satisfied Customers'],
            ]), 'type' => 'json', 'group' => 'homepage'],

            // WhatsApp
            ['key' => 'whatsapp_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_number', 'value' => '256772464686', 'type' => 'text', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_display_name', 'value' => 'RoyalWay Media', 'type' => 'text', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_greeting', 'value' => "Hi there! \u{1F44B} Planning a campaign, event or media project? Chat with us now — we usually reply within minutes.", 'type' => 'textarea', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_prefill', 'value' => 'Hello RoyalWay Media, I\'d like to enquire about your services.', 'type' => 'textarea', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_position', 'value' => 'right', 'type' => 'text', 'group' => 'whatsapp'],

            // SEO
            ['key' => 'seo_title', 'value' => 'RoyalWay Media | Marketing, PR & Events Agency Uganda', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'seo_description', 'value' => 'Uganda\'s 360° integrated marketing and communications agency for PR, branding, events, experiential marketing and behavioral change communications.', 'type' => 'textarea', 'group' => 'seo'],

            // Company Profile
            ['key' => 'company_profile_pdf', 'value' => 'site/royalway-media-company-profile.pdf', 'type' => 'file', 'group' => 'general'],
        ];

        foreach ($defaults as $setting) {
            // Only create if key doesn't exist (idempotent)
            if (!SiteSetting::where('key', $setting['key'])->exists()) {
                SiteSetting::create($setting);
            }
        }

        // Clear settings cache
        Cache::forget('site_settings');

        $this->command->info('Site settings defaults seeded successfully.');
    }
}
