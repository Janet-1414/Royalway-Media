<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => '10 Years of Impact: Standard Chartered Bank',
                'slug' => '10-years-of-impact-standard-chartered-bank',
                'client' => 'Standard Chartered Bank',
                'category' => 'Experiential Marketing',
                'description' => 'As the top 360 marketing agency in Uganda we have had an opportunity to work with Standard Chartered Bank for over 10 years across various Brand & marketing communications channels including Branding, Media Management, and Experiential Marketing & Events.',
                'challenge' => '<p>Standard Chartered Bank needed to maintain its top position as a leading commercial bank in Uganda while increasing retail product penetration and managing brand communications across multiple channels.</p>',
                'results' => '<ul><li>Increased bank visibility to maintain its top position as one of the leading commercial banks in Uganda.</li><li>Increased Bank Retail Products penetration — onboarded over 50,000 new customers.</li><li>Increased media value earned through PR and marketing activities.</li><li>Marketing campaigns boosted engagement around Bank brand to prolong customer lifetime value.</li></ul>',
                'tags' => 'Branding, Media Management, Experiential Marketing, Events, PR',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'is_featured' => true,
                'is_published' => true,
                'project_date' => '2024-01-01',
            ],
            [
                'title' => 'Cultivating Prosperity: aBi\'s Impact',
                'slug' => 'cultivating-prosperity-abi-impact',
                'client' => 'aBi Finance',
                'category' => 'Behavioral Change',
                'description' => 'The Agricultural Business Initiative (aBi) is a social enterprise that channels development cooperation funding to agribusinesses & agricultural service providers. RoyalWay Media supported green finance awareness initiatives across 20 districts in Uganda.',
                'challenge' => '<p>Following the launch of the green agribusiness taxonomy and aBi Green Finance Fund in December 2022, aBi Finance needed to create widespread awareness about green finance taxonomy among financial institutions and agribusinesses across Uganda.</p>',
                'results' => '<ul><li>Successful Stakeholder Launch Event.</li><li>Activations in 20 Districts in Uganda.</li><li>IEC Materials delivered including Wallboards, Stickers, Animation video clips, Brochures, and Pull banners.</li><li>Message dissemination in 1,500 Financial Institutions.</li><li>Enhanced awareness of green finance taxonomy among financial institutions.</li></ul>',
                'tags' => 'Green Finance, IEC Materials, Activations, Media Management',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'is_featured' => true,
                'is_published' => true,
                'project_date' => '2023-01-01',
            ],
            [
                'title' => 'Airtel Nationwide Mobile Marketing Success',
                'slug' => 'airtel-nationwide-mobile-marketing-success',
                'client' => 'Airtel Uganda',
                'category' => 'Experiential Marketing',
                'description' => 'Since 2021, Airtel Uganda partnered with RoyalWay Media to design and implement countrywide Mobile Promotions outreach BTL marketing campaigns covering over 70 districts across Central, Western, Eastern, and Northern Uganda.',
                'challenge' => '<p>Airtel Uganda needed comprehensive nationwide BTL marketing campaigns to reach consumers across 70+ districts while managing contact center launches, customer acquisitions, and field customer service support simultaneously.</p>',
                'results' => '<ul><li>Successfully launched 58 Contact Centers countrywide.</li><li>Significantly increased customer acquisition rates through SIM card sales and Mobile Money registrations.</li><li>Enhanced customer satisfaction through comprehensive field support services.</li><li>Strengthened Airtel\'s market presence across all four regions of Uganda.</li><li>Improved brand visibility and customer loyalty nationwide.</li></ul>',
                'tags' => 'BTL Marketing, Mobile Promotions, Customer Acquisition, Field Marketing',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'is_featured' => true,
                'is_published' => true,
                'project_date' => '2021-01-01',
            ],
            [
                'title' => 'UNICEF\'s Media Services for Child Rights in Uganda',
                'slug' => 'unicef-media-services-child-rights-uganda',
                'client' => 'UNICEF Uganda',
                'category' => 'Strategic Communications',
                'description' => 'Over a six-year partnership, RoyalWay Media developed media strategies for multimedia campaigns and provided translation and production services for radio spots, TV spots, infomercials, online/social media platforms, and documentaries to support UNICEF\'s child rights communication agenda.',
                'challenge' => '<p>UNICEF Uganda required comprehensive media strategy development and production services to effectively advocate for children\'s rights across diverse geographic and demographic segments throughout Uganda, including multi-language translation for local communities.</p>',
                'results' => '<ul><li>Successfully delivered multimedia communication campaigns enhancing awareness of children\'s rights across Uganda.</li><li>Strategic media planning enabled UNICEF to effectively reach diverse audiences nationwide.</li><li>Multi-language translation services expanded reach to local communities.</li><li>Contributed to improved child protection and advocacy outcomes throughout the country.</li></ul>',
                'tags' => 'Media Strategy, Radio Production, TV Production, Child Rights, Advocacy',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'is_featured' => true,
                'is_published' => true,
                'project_date' => '2018-01-01',
            ],
            [
                'title' => 'The European Union\'s Impact in Uganda',
                'slug' => 'european-union-impact-uganda',
                'client' => 'European Union (EU) Uganda',
                'category' => 'Strategic Communications',
                'description' => 'RoyalWay Media is implementing a nationwide communication and visibility intervention to enhance awareness of the EU\'s activities in Uganda through a multimedia mix via traditional media and social media, telling concrete stories of beneficiaries of EU support.',
                'challenge' => '<p>Despite major EU contributions to Uganda\'s development, there was low awareness among the Ugandan population about the EU\'s role. The EU needed to increase communication and visibility around its projects to raise awareness and provide accountability on the use of EU funds.</p>',
                'results' => '<ul><li>Successfully implemented multimedia communication interventions across Uganda.</li><li>Enhanced visibility of the European Union as a single entity and Team Europe.</li><li>Improved awareness among targeted audiences about the EU-Uganda partnership.</li><li>Delivered events management, media coordination, social media management, and video productions.</li></ul>',
                'tags' => 'Visibility, Media Buying, Social Media, PR, Events, Photography',
                'featured_image' => 'projects/featured/placeholder.jpg',
                'is_featured' => true,
                'is_published' => true,
                'project_date' => '2023-06-01',
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
