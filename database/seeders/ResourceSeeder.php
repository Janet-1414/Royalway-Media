<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title' => 'Our Purpose: Driving Meaningful Progress Through Purposeful Communication',
                'slug' => 'our-purpose-driving-meaningful-progress',
                'type' => 'publication',
                'author' => 'RoyalWay Media',
                'excerpt' => 'We believe tomorrow\'s companies are purpose-driven and solve real problems for people, real challenges for industries, and real dilemmas for society.',
                'content' => '
                    <h3>Driving meaningful progress through purposeful communication</h3>
                    <p>We\'ve always believed that companies are an absolute necessity for individuals and society to progress. But they must contribute more than they take away, and to do that they need to be clear about their purpose.</p>
                    <p>We believe tomorrow\'s companies are purpose-driven and solve real problems for people, real challenges for industries, and real dilemmas for society.</p>
                    <p>Purposeful companies secure future relevance and improve their bottom line.</p>
                    <p>Our Purpose is to power and deliver superior value to our clients through integrated communication solutions that support people, progress & productivity as well as, helping them to make the world a better place.</p>

                    <h3>Our Core Values</h3>
                    <p>What drives us every day</p>

                    <h4>People</h4>
                    <p>Supporting individuals and teams to reach their full potential through meaningful communication.</p>

                    <h4>Progress</h4>
                    <p>Driving continuous improvement and innovation in everything we do.</p>
                ',
                'is_published' => true,
                'published_at' => '2024-01-01',
            ],
            [
                'title' => 'Diversity & Inclusion: Building a Better Workplace',
                'slug' => 'diversity-inclusion-building-better-workplace',
                'type' => 'publication',
                'author' => 'RoyalWay Media',
                'excerpt' => 'We believe success is created by a diverse workforce of individuals with different ideas, strengths, interests, and cultural backgrounds.',
                'content' => '
                    <h3>Diverse teams are better at making innovative ideas happen</h3>
                    <p>We believe success is created by a diverse workforce of individuals with different ideas, strengths, interests, and cultural backgrounds.</p>
                    <p>A diverse and inclusive workforce inspires innovation and is fundamental to our company\'s success.</p>
                    <p>Having an environment comprised of people from different dimensions of diversity also helps us better understand the unique needs of the customers, and Brands we serve, including those with different abilities.</p>

                    <h3>Our Commitment</h3>
                    <p>Building an inclusive workplace for everyone.</p>

                    <h4>Inclusive Culture</h4>
                    <p>Creating an environment where everyone feels valued, respected, and empowered to contribute their best work.</p>

                    <h4>Innovation Through Diversity</h4>
                    <p>Leveraging diverse perspectives and experiences to drive creative solutions and breakthrough thinking.</p>

                    <h4>Equal Opportunity</h4>
                    <p>Ensuring fair treatment and advancement opportunities for all employees regardless of background or identity.</p>
                ',
                'is_published' => true,
                'published_at' => '2024-02-01',
            ],
            [
                'title' => 'Our Commitment to Sustainability: People, Profit, and Planet',
                'slug' => 'commitment-to-sustainability-people-profit-planet',
                'type' => 'publication',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Royalway Media recognizes its responsibility to conduct business in a way that improves the well-being of the people and protects the state of the environment for future generations.',
                'content' => '
                    <h3>Promoting a better future for People, Profit, and Planet</h3>
                    <p>Royalway Media recognizes its responsibility to conduct business in a way that improves the well-being of the people and protects the state of the environment for future generations. As a leading firm, we understand that the long-term well-being of society, the well-being of our colleagues, the strength of the global economy, and the continuing success of our own business depend on our commitment to sustainability.</p>
                    <p>Sustainability is an integral part of being a successful business and we always aim to act in an ethical, transparent, and responsible way. Naturally, we expect our business partners to do the same.</p>

                    <h3>Our Core Commitments</h3>

                    <h4>Transparency & Collaboration</h4>
                    <p>Transparency and collaboration are critical commodities for high-performing teams because they are a quick way to establish trust. We are keen to openly work with our customers, suppliers, and regulators like URA, PPDA, KCCA, URSB, and the United Nations and endeavor to play our role transparently and collaboratively.</p>

                    <h4>Impact on People</h4>
                    <p>We respect human rights, promote inclusion, and champion diversity throughout our work and supply chain — and call on our Business Partners to do the same. Our company culture is an attitude and environment where we cultivate collaboration, productivity, and satisfaction among our employees.</p>

                    <h4>Reducing Carbon Footprint</h4>
                    <ul>
                        <li>Reducing energy consumption</li>
                        <li>Switching to renewable energy sources</li>
                        <li>Encouraging sustainable transportation</li>
                        <li>Working with sustainable suppliers</li>
                        <li>Investing in green growth</li>
                    </ul>

                    <h4>Climate Change Education & Literacy</h4>
                    <p>We leverage our talents and expertise in communication to promote climate action by designing awareness messages and communication tools, working with partners like the Rotary Club of Acacia Sunset to help people understand and address the impacts of the climate crisis.</p>
                ',
                'is_published' => true,
                'published_at' => '2024-03-01',
            ],
        ];

        $communicationAssets = [
            [
                'title' => 'Baseline KAP Survey Report',
                'slug' => 'baseline-kap-survey-report',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Comprehensive baseline Knowledge, Attitudes, and Practices survey report providing essential insights and data analysis.',
                'content' => '<p>Comprehensive baseline Knowledge, Attitudes, and Practices survey report providing essential insights and data analysis.</p>',
                'is_published' => true,
                'published_at' => '2024-01-01',
            ],
            [
                'title' => 'Communications & Marketing Strategy',
                'slug' => 'communications-marketing-strategy',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Strategic framework for communications and marketing initiatives, outlining key approaches and methodologies.',
                'content' => '<p>Strategic framework for communications and marketing initiatives, outlining key approaches and methodologies.</p>',
                'is_published' => true,
                'published_at' => '2024-02-01',
            ],
            [
                'title' => 'End of Activity Report - ABI Trust',
                'slug' => 'end-of-activity-report-abi-trust',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Comprehensive end-of-activity report detailing project outcomes, achievements, and key learnings from the ABI Trust initiative.',
                'content' => '<p>Comprehensive end-of-activity report detailing project outcomes, achievements, and key learnings from the ABI Trust initiative.</p>',
                'is_published' => true,
                'published_at' => '2024-03-01',
            ],
            [
                'title' => 'UEUBI 2025 Summary Report',
                'slug' => 'ueubi-2025-summary-report',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Final summary report for the Uganda-Europe Union Business Initiative 2025, highlighting key outcomes and strategic partnerships.',
                'content' => '<p>Final summary report for the Uganda-Europe Union Business Initiative 2025, highlighting key outcomes and strategic partnerships.</p>',
                'is_published' => true,
                'published_at' => '2025-01-01',
            ],
            [
                'title' => 'European Union and Uganda Partnership 2025',
                'slug' => 'european-union-uganda-partnership-2025',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Strategic partnership document outlining collaboration frameworks and initiatives between the European Union and Uganda for 2025.',
                'content' => '<p>Strategic partnership document outlining collaboration frameworks and initiatives between the European Union and Uganda for 2025.</p>',
                'is_published' => true,
                'published_at' => '2025-01-01',
            ],
            [
                'title' => 'Furaha OBUL Flyers',
                'slug' => 'furaha-obul-flyers',
                'type' => 'communication_asset',
                'author' => 'RoyalWay Media',
                'excerpt' => 'Marketing and communication flyers for the Furaha OBUL initiative, designed to promote awareness and engagement.',
                'content' => '<p>Marketing and communication flyers for the Furaha OBUL initiative, designed to promote awareness and engagement.</p>',
                'is_published' => true,
                'published_at' => '2024-06-01',
            ],
        ];

        foreach (array_merge($resources, $communicationAssets) as $resource) {
            Resource::updateOrCreate(
                ['slug' => $resource['slug']],
                $resource
            );
        }
    }
}
