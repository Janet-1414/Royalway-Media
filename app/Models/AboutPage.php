<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'hero_title', 'hero_subtitle', 'hero_image',
        'intro_badge', 'intro_heading', 'intro_body', 'intro_images',
        'stats',
        'mission_image', 'mission', 'vision', 'purpose',
        'strengths_badge', 'strengths_intro', 'strengths',
        'cta_title', 'cta_text',
    ];

    protected $casts = [
        'intro_images' => 'array',
        'stats' => 'array',
        'strengths' => 'array',
    ];

    /**
     * The single About page record, created with the current wording on first use
     */
    public static function current(): self
    {
        return static::query()->first() ?? static::create(static::defaults());
    }

    /**
     * Public URL for an uploaded file, or null if it is missing
     */
    public static function fileUrl($path): ?string
    {
        if (! is_string($path) || $path === '' || ! file_exists(storage_path('app/public/' . $path))) {
            return null;
        }

        return asset('storage/' . $path);
    }

    public static function defaults(): array
    {
        return [
            'hero_title' => 'About Us',
            'hero_subtitle' => 'The bridge to influence, trust, and growth.',
            'intro_badge' => 'ABOUT US',
            'intro_heading' => 'Who We Are',
            'intro_body' => '<p>RoyalWay Media Ltd is a premier integrated communications firm based in Kampala, Uganda, dedicated to elevating brands and transforming ambitions into lasting communications impact. With more than 15 years of proven expertise, we deliver 360-degree solutions that seamlessly blend strategic public relations, powerful branding, innovative marketing, behavioral change communications, digital engagement, advertising, experiential events, and more. Our in-house team of creative strategists, storytellers, and industry specialists approaches every project with creativity, reliability, and unmatched speed of delivery, building meaningful connections between organizations and their audiences.</p>'
                . '<p>We partner closely with corporate entities, development organizations, and ambitious brands across East Africa and beyond, helping them navigate complex communication landscapes, amplify their voice, and achieve measurable results. Whether crafting compelling narratives, managing high-profile events, driving behavioral transformation, or executing integrated campaigns, we bring passion, precision, and a deep understanding of local and regional dynamics to every engagement.</p>'
                . '<p>At RoyalWay Media Ltd, communication is more than a service. It’s <strong>the bridge to influence, trust, and growth. We don’t just tell your story; we make it resonate.</strong></p>',
            'intro_images' => [],
            'stats' => [
                ['value' => '15+', 'label' => 'Years of proven expertise'],
                ['value' => '137', 'label' => 'Districts covered in Uganda'],
                ['value' => '360°', 'label' => 'Integrated communications approach'],
            ],
            'mission' => 'Our mission is to transform communication offerings into an integrated delivery model that provides our clients with one single point of contact for their entire communication programs and all strategic perspectives of their brands.',
            'vision' => 'To become a world-class communications service provider through the provision of innovative and superior service and total client attachment.',
            'purpose' => 'Our Purpose is to power and deliver superior value to our clients through integrated communication solutions.',
            'strengths_badge' => 'Our Strengths',
            'strengths_intro' => 'Our Purpose is to power and deliver superior value to our clients through integrated communication solutions.',
            'strengths' => [
                [
                    'icon' => 'fa-circle-nodes',
                    'title' => 'Integrated 360-Degree communications & marketing approach',
                    'body' => 'RoyalWay excels at providing comprehensive, end-to-end communications solutions, seamlessly blending PR, branding, advertising, digital marketing, behavioral change communications, experiential events, media management, and more, under one roof for maximum impact and consistency.',
                ],
                [
                    'icon' => 'fa-award',
                    'title' => 'Proven Expertise and Track Record',
                    'body' => 'With over a decade of experience we have successfully partnered with major multinational corporations (e.g., MTN Uganda, Standard Chartered Bank, ABSA, Airtel Uganda, Total E&P), development organizations (e.g., European Union, aBi Finance, UNDP, UNICEF, UN Women), and government bodies across East Africa, delivering measurable results in complex markets.',
                ],
                [
                    'icon' => 'fa-bolt',
                    'title' => 'Creativity Combined with Reliability and Speed',
                    'body' => 'Royalway Media is widely recognized for its creative storytelling, innovative strategies, and unmatched speed of delivery, qualities that set them apart in high-stakes campaigns, activations, and time-sensitive projects while maintaining consistent quality and professionalism.',
                ],
                [
                    'icon' => 'fa-map-location-dot',
                    'title' => 'Deep Local and Regional Insight',
                    'body' => 'Based in Kampala with strong East African roots, RoyalWay brings nuanced understanding of local dynamics, cultural contexts, and audience behaviors, essential for effective behavioral change, community engagements and nationwide activations covering 137 districts in Uganda.',
                ],
                [
                    'icon' => 'fa-handshake',
                    'title' => 'Passion-Driven, Client-Centric Collaboration',
                    'body' => 'They emphasize building meaningful partnerships, aligning communication strategies tightly to client goals, and infusing projects with passion, insight, knowledge, experience, curiosity, and vision, transforming ambitions into thriving outcomes and fostering long-term trust.',
                ],
            ],
            'cta_title' => 'Ready to Get Started?',
            'cta_text' => 'Let’s work together to achieve your communications and marketing goals.',
        ];
    }
}
