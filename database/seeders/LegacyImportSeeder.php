<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Resource;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LegacyImportSeeder extends Seeder
{
    private const LEGACY_URL = 'https://royalwaymedia.com/assets/uploads/';

    public function run(): void
    {
        $serviceIds = $this->importServices();
        $this->importProjects($serviceIds);
        $this->importCommunicationAssets();
    }

    private function importServices(): array
    {
        $services = [
            'advertising' => [
                'title' => 'Advertising',
                'image' => 'dtbs-min1701169419.png',
                'short' => 'At Royal Way Media, we help businesses design cost-effective go-to-market strategies and advertising campaigns.',
                'full' => <<<'HTML'
<p>At Royal Way Media, we help businesses design <strong>cost-effective go-to-market strategies</strong> and advertising campaigns that make your brand cut through the crowd and target your audience carefully and thoughtfully — from traditional print, radio and billboards to the new world of digital and social media.</p>
<h3>Our Advertising Services</h3>
<ul>
<li><strong>Advertising Strategy</strong> — Comprehensive strategic planning to position your brand effectively and reach your target audience with precision and impact.</li>
<li><strong>Creative Development</strong> — Innovative creative solutions that capture attention and communicate your brand message with compelling visuals and engaging content.</li>
<li><strong>Media Planning &amp; Buying</strong> — Strategic media placement across traditional and digital platforms to maximize reach, frequency and return on advertising investment.</li>
<li><strong>Media Monitoring &amp; Analysis</strong> — Comprehensive tracking and analysis of campaign performance to optimize results and ensure maximum effectiveness of your advertising spend.</li>
</ul>
HTML,
            ],
            'design-printing' => [
                'title' => 'Design & Printing',
                'image' => 'bus-min1701169202.png',
                'short' => 'Our design and printing expertise is a blend of communication identity, strategy, creativity, and user experience.',
                'full' => <<<'HTML'
<p>Our design and printing expertise is a <strong>blend of communication identity, strategy, creativity and user experience</strong>. We are among the leading companies providing total design, printing, packaging and branding services. Royal Way Media is equipped with state-of-the-art machines that enable our skilled team to produce printed products for your administration, marketing and branding needs.</p>
<h3>Our Design &amp; Printing Services</h3>
<ul>
<li><strong>Corporate Stationery</strong> — Business cards, letterheads, envelopes and complete corporate identity packages that reinforce your brand's credibility.</li>
<li><strong>Reports</strong> — High-quality annual reports, corporate brochures, manuals and documentation with professional binding and finishing.</li>
<li><strong>Promotional Items</strong> — Custom branded merchandise and giveaways that keep your brand visible and memorable.</li>
<li><strong>Marketing Collaterals</strong> — Flyers, posters, banners, brochures and point-of-sale materials designed to drive engagement.</li>
</ul>
HTML,
            ],
            'digital-marketing' => [
                'title' => 'Digital Marketing',
                'image' => 'so-min1701169690.png',
                'short' => 'Great digital marketing strategy lies at the intersection of technology, empathy, and usability.',
                'full' => <<<'HTML'
<p>Great digital marketing strategy lies at the <strong>intersection of technology, empathy and usability</strong>. We tailor our digital marketing services to each client's expectations and goals. Through continuous monitoring and reporting we measure the success of paid advertising, social media campaigns, SEO and content work, and make ongoing improvements to achieve the best possible results — whether the aim is more website traffic and conversions or greater brand awareness.</p>
<h3>Our Digital Marketing Services</h3>
<ul>
<li><strong>SEO</strong> — An all-encompassing, bespoke SEO service that increases organic traffic from search engines and delivers measurable results.</li>
<li><strong>Content Marketing</strong> — Quality, well-structured content that engages visitors, demonstrates authority in your industry and generates a higher return on investment.</li>
<li><strong>Social Media</strong> — An integrated social media strategy to increase visibility, raise brand awareness, drive traffic and increase leads and sales.</li>
<li><strong>Analytics &amp; Reporting</strong> — Continuous monitoring and reporting to track performance and optimize strategies for maximum ROI.</li>
</ul>
HTML,
            ],
            'experiential-marketing' => [
                'title' => 'Experiential Marketing',
                'image' => 'air-min1701170256.png',
                'short' => 'At Royalway Media’s Experiential Marketing unit our passion, insight, and integrity fuel our relentless pursuit of brilliant brand experiences that forge deep emotional connections for audiences across Uganda.',
                'full' => <<<'HTML'
<p>At Royal Way Media's Experiential Marketing unit our <strong>passion, insight and integrity fuel our relentless pursuit of brilliant brand experiences</strong> that forge deep emotional connections with audiences across Uganda. Consumer expectations have shifted — captivating emotions now hold greater influence than mere social interactions. Experiential marketing's value ultimately lies in seamless planning and execution that drives tangible business outcomes.</p>
<h3>Our Experiential Marketing Services</h3>
<ul>
<li><strong>Road Shows</strong> — Mobile brand experiences that bring your message directly to consumers across Uganda through face-to-face engagement.</li>
<li><strong>Customer Education</strong> — Engaging educational campaigns that help customers understand your products and build trust in your brand.</li>
<li><strong>Promotional Community Drives</strong> — Community-focused events that create positive brand associations through meaningful local engagement.</li>
<li><strong>Market Activations</strong> — Brand activation events that create buzz and drive consumer participation through immersive experiences.</li>
</ul>
HTML,
            ],
            'pr-media-coordination' => [
                'title' => 'PR & Media Coordination',
                'image' => '5f-min1702130986.png',
                'short' => 'Royal Way Media offers a multitude of professionalized PR solutions designed to impact your brand’s reputation.',
                'full' => <<<'HTML'
<p>Royal Way Media offers a <strong>multitude of professionalized PR solutions designed to impact your brand's reputation</strong>, broaden your visibility and build concrete trust among your audience. Through our media coordination services, we help you with creative, catchy messaging and maintain a positive reputation with your target public across media channels.</p>
<h3>Our PR &amp; Media Coordination Services</h3>
<ul>
<li><strong>Content Development</strong> — Strategic content that tells your brand story across all communication channels.</li>
<li><strong>Press Releases Circulation</strong> — Professional press release writing and distribution to relevant media outlets.</li>
<li><strong>Press Conferences</strong> — Complete press conference planning and execution.</li>
<li><strong>Special Event Media Alerts</strong> — Timely media alerts to ensure coverage of your events and announcements.</li>
<li><strong>Fact Sheets</strong> — Accurate, easily digestible information for media and stakeholders.</li>
<li><strong>Feature Story Pitches</strong> — Creative story pitches that secure valuable feature coverage.</li>
<li><strong>Infographics</strong> — Visually compelling infographics that make complex information shareable.</li>
<li><strong>Radio &amp; TV Talk Show Placements</strong> — Strategic placements on talk shows to reach broader audiences.</li>
<li><strong>Employee Engagements</strong> — Internal communication programs that align your team with your brand.</li>
<li><strong>Crisis Management</strong> — Proactive and reactive crisis communication to protect your reputation.</li>
</ul>
HTML,
            ],
            'media-planning-buying-monitoring' => [
                'title' => 'Media Planning, Buying & Monitoring',
                'image' => '4e-min1702131185.png',
                'short' => 'Over the years, we have retained the expertise of successful media buying and ad placement in both the traditional and digital media spaces.',
                'full' => <<<'HTML'
<p>At Royal Way Media, we bring <strong>proven expertise in media planning, buying and monitoring</strong> across traditional and digital platforms. Our strategies ensure that your brand connects with audiences <strong>at the right time, in the right place, using the right channels</strong>, and we help businesses track and optimize the performance of their PR and marketing efforts.</p>
<h3>Benefits to Our Clients</h3>
<ul>
<li><strong>Good Media Price Deals</strong> — Favorable media rates and cost-effective advertising packages that maximize your return on investment.</li>
<li><strong>Optimizing Media Space</strong> — Strategic placement for maximum visibility, reach and audience engagement.</li>
<li><strong>Avoiding Ad Fraud</strong> — Vigilant monitoring and trusted platform partnerships that protect your campaigns from fraudulent impressions and clicks.</li>
</ul>
HTML,
            ],
            'events-experiences' => [
                'title' => 'Events & Experiences',
                'image' => '3c-min1702130141.png',
                'short' => 'We are a team of experts in the Event Industry. Our experience is rich and diverse and we have worked with numerous clients’ local companies.',
                'full' => <<<'HTML'
<p>We are a team of experts in the event industry. We have worked with clients ranging from local companies to top brands in banking, telecoms and FMCG, and international agencies such as UNICEF, UN Women and the European Union. We create, manage and execute events that are memorable for your audience and leave a lasting impression on guest speakers.</p>
<p>Event management starts with a wish to build an exemplary experience. Our job is to get you there — managing budgets and deadlines, choosing the right venues and partners, selecting talent and creating the best possible atmosphere for your audience.</p>
<h3>Events We Handle</h3>
<ul>
<li><strong>Product Launches</strong> — From concept to execution, a memorable first impression for your product.</li>
<li><strong>Thought Leadership Series</strong> — Curated events that position your brand as an authority in your field.</li>
<li><strong>Conferences &amp; Conventions</strong> — Planning and coordination for large-scale business gatherings.</li>
<li><strong>Corporate Events</strong> — Professional events tailored to your corporate objectives.</li>
<li><strong>International Day Celebrations</strong> — Creative, inclusive events for global milestones and awareness days.</li>
<li><strong>Capacity Building Workshops</strong> — Workshops that support learning, growth and engagement.</li>
<li><strong>Exhibitions &amp; Trade Shows</strong> — Booth setup, logistics and branding for maximum visibility.</li>
</ul>
<h3>Full Event Architecture</h3>
<ul>
<li><strong>Event Logistics</strong> — Seamless coordination of all moving parts.</li>
<li><strong>Venue Setup</strong> — Creative, comfortable and functional layouts.</li>
<li><strong>Event Branding &amp; Décor</strong> — Visuals and décor aligned with your brand identity.</li>
<li><strong>Photography &amp; Videography</strong> — Impactful visual coverage for future promotion.</li>
<li><strong>Event Livestreaming</strong> — High-quality real-time streaming to global audiences.</li>
<li><strong>Event Promotions</strong> — Campaigns that boost attendance and awareness.</li>
<li><strong>Media Coordination</strong> — Liaising with media for optimal coverage.</li>
<li><strong>Post Event Reporting</strong> — Summaries, insights and performance analytics.</li>
</ul>
HTML,
            ],
            'audio-visual-production' => [
                'title' => 'Audio & Visual Production',
                'image' => '4-min1701116628.png',
                'short' => 'Royalway Media is equipped with full audio-visual production sets that continuously focus on providing great service.',
                'full' => <<<'HTML'
<p>Royalway Media is equipped with full audio-visual production sets focused on excellent service and helping clients streamline event execution. We deliver quality solutions using the latest technologies, and every technical solution is managed by highly trained specialists and project managers to ensure precision and satisfaction.</p>
<h3>Our Audio-Visual Production Services</h3>
<ul>
<li><strong>Radio &amp; TV Production</strong> — Creative and technical production for broadcast content.</li>
<li><strong>Audio-Visual Equipment Supplies</strong> — High-quality PA and sound systems for diverse event needs.</li>
<li><strong>Video Wall Rental</strong> — High-resolution video walls for dynamic visual experiences.</li>
<li><strong>Videography Services</strong> — Professional video coverage and editing.</li>
<li><strong>Photography Services</strong> — Experienced photographers documenting your events and projects.</li>
<li><strong>Documentary Productions</strong> — End-to-end development from storyboarding to filming and editing.</li>
<li><strong>Live Streaming</strong> — Real-time broadcasting to local and global audiences.</li>
</ul>
HTML,
            ],
            'social-behavioural-change-communications' => [
                'title' => 'Social Behavioural Change Communications',
                'image' => '121701729297.png',
                'short' => 'Behavior change Communications is at the heart of everything we do. We’re one of Uganda\'s most experienced behaviour change agencies.',
                'full' => <<<'HTML'
<p>Royalway Media specializes in communication strategies that help governments, multilateral agencies, NGOs and corporations influence behavior and achieve program objectives. Our behavior change interventions create demand for products and services, mobilize communities, address policies and laws, and improve the lives of individuals and communities.</p>
<p>Behaviors and decisions are shaped by a complex mix of norms, emotions, biases and beliefs. Behavior change marketing is about understanding these influences to shape new behaviors — not only changing people's minds, but changing what they do. Our agency's mantra, <strong>"For people with purpose."</strong>, is underpinned by creative thinking.</p>
<p>Our multidisciplinary team works at the intersection of Uganda's community norms, cultural values and communication channels to create effective, integrated behavior change strategies.</p>
<h3>SBCC Program Areas</h3>
<ul>
<li><strong>Health &amp; Risk Communications</strong> — Impactful messaging that improves public health awareness and risk mitigation.</li>
<li><strong>Civic &amp; Voter Education</strong> — Empowering citizens to participate actively in democratic processes.</li>
<li><strong>Community Mobilization &amp; Action</strong> — Mobilizing communities for collective action and sustainable change.</li>
</ul>
HTML,
            ],
        ];

        $ids = [];
        $order = 1;

        foreach ($services as $slug => $data) {
            $service = Service::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'short_description' => $data['short'],
                    'full_description' => trim($data['full']),
                    'image' => $data['image'] ? ($this->fetch('media-uploader/' . $data['image'], 'services/images') ?? '') : '',
                    'order' => $order++,
                    'is_active' => true,
                ]
            );

            $ids[$slug] = $service->id;
            $this->command->info("Service: {$service->title}");
        }

        return $ids;
    }

    private function importProjects(array $serviceIds): void
    {
        $projects = [
            [
                'title' => '10 Years of Impact: Standard Chartered Bank',
                'client' => 'Standard Chartered Bank Uganda',
                'category' => 'Strategic Communications',
                'date' => '2023-12-04',
                'image' => '4d-min1702130143.png',
                'gallery' => ['a1701713283.jpg', 'b1701713283.jpg'],
                'services' => ['advertising', 'design-printing', 'experiential-marketing', 'pr-media-coordination', 'events-experiences'],
                'description' => 'As the top 360 marketing agency in Uganda, we have had an opportunity to work with Standard Chartered Bank for over 10 years across various Brand & marketing communications channels.',
                'challenge' => <<<'HTML'
<p><strong>As the top 360 marketing agency in Uganda we have worked with Standard Chartered Bank for over 10 years across brand and marketing communications channels including Branding, Media Management, and Experiential Marketing &amp; Events.</strong></p>
<h3>Target Market</h3>
<p>Standard Chartered primarily focuses on serving corporate and institutional clients, as well as high-net-worth individuals globally.</p>
<h3>Objectives</h3>
<ol>
<li>Increase brand awareness and familiarity among the bank's target audience</li>
<li>Customer onboarding across various client marketing segments</li>
<li>Customer education and assistance on product penetration, driving the retail products promotions agenda</li>
<li>Plan and manage bank events for internal and external stakeholders</li>
<li>Public relations and media management</li>
</ol>
<h3>Services Offered</h3>
<ul>
<li><strong>Advertising, PR &amp; Media Management</strong> — Comprehensive media strategies and public relations management.</li>
<li><strong>Events Planning &amp; Management</strong> — Full-service event coordination and execution.</li>
<li><strong>Customer Onboarding &amp; Promotions</strong> — Strategic customer acquisition and engagement campaigns.</li>
<li><strong>Printing &amp; Production</strong> — High-quality print materials and production services.</li>
</ul>
<h3>Strategy &amp; Tactics</h3>
<p>We developed a multi-faceted strategy that included brand concepts, media relations and event management plans. Marketing executions covered corporate and CSR sponsorships — event planning, publicity, guest invitations and logistics such as catering, transport, décor and communication tools.</p>
<p>We carried out promotions to create awareness of bank products, including brochures, customization of international documents for the local market, and media relations — developing and distributing press releases and writing supplements.</p>
HTML,
                'results' => <<<'HTML'
<ol>
<li>Increased bank visibility, maintaining its position as one of the leading commercial banks in Uganda.</li>
<li>Increased retail product penetration, onboarding over 50,000 new customers.</li>
<li>Increased media value earned and content gained through PR and marketing activities.</li>
</ol>
<p>Marketing campaigns boosted engagement around the bank's brand, prolonging customer lifetime value.</p>
HTML,
            ],
            [
                'title' => 'Airtel Nationwide Mobile Marketing Success',
                'client' => 'Airtel Uganda',
                'category' => 'Experiential Marketing',
                'date' => '2023-12-04',
                'image' => 'air-min1701170256.png',
                'gallery' => ['cc1701713844.jpg', 'aa1701713843.jpg', 'bb1701713843.jpg', 'air-min1701170256.png', '4-min1701116628.png'],
                'services' => ['experiential-marketing', 'events-experiences'],
                'description' => 'Since 2021, Airtel Uganda partnered with RoyalWay Media for countrywide Mobile Marketing Activations, covering 70+ districts, promoting products and services.',
                'challenge' => <<<'HTML'
<p><strong>Since 2021, Airtel Uganda has partnered with RoyalWay Media to design and implement countrywide mobile promotions and BTL marketing campaigns, reaching consumers in over 70 districts across Central, Western, Eastern and Northern Uganda.</strong></p>
<h3>National Coverage</h3>
<p>Our BTL campaigns span over 70 districts in all four regions of Uganda, ensuring maximum market penetration and customer engagement across diverse geographic and demographic segments.</p>
<h3>Services Provided</h3>
<ul>
<li><strong>Contact Center Launches</strong> — Launch of 58 contact centers countrywide, including shop launches and logistics supplies.</li>
<li><strong>Customer Product Education</strong> — Education programs on Airtel products and services.</li>
<li><strong>Customer Acquisitions</strong> — SIM card sales, Mobile Money registrations and airtime activations.</li>
<li><strong>Field Query Resolution</strong> — Resolving field queries including SIM blocks and barring issues.</li>
<li><strong>Product Activations</strong> — Mobile Money activations and promotional campaigns such as Freaky Fridays.</li>
<li><strong>Field Customer Service</strong> — Comprehensive field customer service support.</li>
</ul>
HTML,
                'results' => <<<'HTML'
<p>Our partnership has delivered nationwide market penetration through strategic BTL campaigns: 58 contact centers launched, significantly increased customer acquisition, and improved customer satisfaction through field support — strengthening Airtel's brand visibility and customer loyalty across all four regions of Uganda.</p>
HTML,
            ],
            [
                'title' => "UNICEF's Media Services for Child Rights in Uganda",
                'client' => 'UNICEF Uganda',
                'category' => 'PR & Media',
                'date' => '2023-12-05',
                'image' => '4e-min1702131185.png',
                'gallery' => ['131701729298.jpg', '121701729297.png', '111701729297.jpg'],
                'services' => ['pr-media-coordination', 'media-planning-buying-monitoring', 'audio-visual-production'],
                'description' => 'UNICEF Uganda amplifies child rights through strategic media services—advocacy, mass messaging—empowering voices, reaching hearts nationwide.',
                'challenge' => <<<'HTML'
<p><strong>UNICEF Uganda is mandated by the United Nations to advocate for the protection of children's rights, help meet their basic needs, and expand their opportunities to reach their full potential.</strong></p>
<h3>Communication Mission</h3>
<p>Communication is integral to UNICEF Uganda's work, ranging from focused advocacy to mass media messages targeting large segments of the population. Mass media advertising allows messages to reach large populations across different geographic and demographic segments.</p>
<h3>Partnership Overview</h3>
<p>Over the past six years, UNICEF engaged RoyalWay Media to develop media strategies for multimedia campaigns and provide translation and production services for radio spots, TV spots, infomercials, online/social media content and documentaries.</p>
<h3>Services Provided</h3>
<ul>
<li><strong>Media Strategy Development</strong> — Media strategy planning for child rights campaigns.</li>
<li><strong>Communication Media Plans</strong> — Targeted communication media plans.</li>
<li><strong>Radio &amp; TV Production</strong> — Production of radio and TV spots, plus translation services.</li>
<li><strong>Media Rate Negotiation</strong> — Competitive media rates and bonuses for maximum reach.</li>
<li><strong>Copywriting &amp; Translation</strong> — Professional copywriting and translation into local languages.</li>
<li><strong>Online Content Development</strong> — Engaging content for digital platforms and social media.</li>
</ul>
HTML,
                'results' => <<<'HTML'
<p>Through our six-year partnership we have delivered multimedia campaigns that significantly enhanced awareness of children's rights across Uganda. Strategic media planning, content production and multi-language translation enabled UNICEF to reach diverse audiences nationwide, contributing to improved child protection and advocacy outcomes.</p>
HTML,
            ],
            [
                'title' => "The European Union's Impact in Uganda",
                'client' => 'The European Union Delegation to Uganda',
                'category' => 'Strategic Communications',
                'date' => '2023-12-05',
                'image' => '5f-min1702130986.png',
                'gallery' => ['zz1701729476.png', 'xx1701729475.png', 'yy1701729475.png'],
                'services' => ['design-printing', 'digital-marketing', 'pr-media-coordination', 'media-planning-buying-monitoring', 'events-experiences', 'audio-visual-production'],
                'description' => 'The European Union, a key political and economic force in Uganda, leads in development support, emerging as the largest donor. Positioned as a strategic catalyst for growth.',
                'challenge' => <<<'HTML'
<p><strong>The European Union and its member states are major political and economic actors in Uganda, and the EU's development support makes it the largest donor in the country.</strong></p>
<h3>The Problem</h3>
<p>Despite the major impact of EU activities in Uganda, awareness among Ugandans of the EU's role and contributions to the country's development was low. The EU sought to increase communication and visibility around its projects, and to provide accountability and transparency on the use of EU funds to taxpayers in member states and citizens of Uganda.</p>
<h3>Solution</h3>
<p>RoyalWay Media is implementing a nationwide communication and visibility intervention to enhance awareness of the EU's activities in Uganda, especially grant support — through traditional media (with emphasis on radio) and social media, telling concrete stories of beneficiaries.</p>
<p><strong>Key focus areas:</strong></p>
<ul>
<li>Promoting Green Partnerships</li>
<li>Promoting sustainable and inclusive growth and jobs</li>
<li>Promoting democratic governance and social inclusion in private sector activities</li>
<li>EU support targeting both Ugandans and refugees</li>
</ul>
<h3>Communication &amp; Visibility Services</h3>
<ul>
<li><strong>Media Buying and Coordination</strong></li>
<li><strong>EU Events Planning and Management</strong></li>
<li><strong>Supply of Branded Materials</strong></li>
<li><strong>Social Media Management</strong></li>
<li><strong>PR/Media Coordination &amp; Monitoring</strong></li>
<li><strong>Perception Surveys</strong></li>
<li><strong>Visual/Billboard Campaigns</strong></li>
<li><strong>Photography/Video Production</strong></li>
</ul>
HTML,
                'results' => <<<'HTML'
<p>Over the past year we have implemented events, media management, editorial support and content development, social and digital management, and photography and video production — enhancing the visibility of the European Union and Team Europe in Uganda and improving awareness of the EU–Uganda partnership in all its dimensions.</p>
HTML,
            ],
            [
                'title' => "Cultivating Prosperity: aBi's Impact",
                'client' => 'Agricultural Business Initiative (aBi)',
                'category' => 'Events Planning',
                'date' => '2023-12-05',
                'image' => '3c-min1702130141.png',
                'gallery' => [],
                'services' => ['design-printing', 'pr-media-coordination', 'events-experiences', 'social-behavioural-change-communications'],
                'description' => 'aBi, a social enterprise, directs development funding to agribusinesses, fostering a competitive, profitable, and sustainable agriculture sector in Uganda.',
                'challenge' => <<<'HTML'
<p><strong>The Agricultural Business Initiative (aBi) is a social enterprise that channels development cooperation funding to agribusinesses and agricultural service providers, building a competitive, profitable and sustainable agriculture sector in support of equitable wealth creation in Uganda.</strong></p>
<h3>Project Overview</h3>
<p>Following the launch of the green agribusiness taxonomy and the aBi Green Finance Fund in December 2022, aBi Finance contracted RoyalWay Media to develop IEC communication tools, conduct district-level activations and use mass media to create awareness of the green taxonomy and green finance.</p>
<p><strong>Target districts:</strong> Kabale, Ntungamo, Bushenyi, Mbarara, Kasese, Fort Portal, Hoima, Masindi, Masaka, Kampala, Wakiso, Mukono, Jinja, Tororo, Mbale, Soroti, Lira, Moroto, Gulu and Arua.</p>
<h3>Services Provided</h3>
<ul>
<li>Development and dissemination of green finance IEC materials — wallboards, stickers, animation clips, brochures and pull-up banners</li>
<li>Constant visual reminders about green financing information</li>
<li>Distribution of IEC materials to 1,500 financial institutions in Uganda</li>
<li>Launch event sensitizing top-tier stakeholders on green finance</li>
<li>District-level green finance activations</li>
<li>Media coordination across TV, radio and digital channels</li>
</ul>
HTML,
                'results' => <<<'HTML'
<ul>
<li>Successful stakeholder launch event</li>
<li>Activations in 20 districts across Uganda</li>
<li>IEC tools delivered — wallboards, stickers, animation clips, brochures and pull-up banners</li>
<li>Messages disseminated in 1,500 financial institutions</li>
<li>Media outputs across multiple channels</li>
<li>Enhanced awareness of the green finance taxonomy among financial institutions</li>
</ul>
<p>The campaign laid a strong foundation for green finance adoption in Uganda's agricultural sector, positioning aBi Finance as a leader in sustainable agricultural development.</p>
HTML,
            ],
        ];

        foreach ($projects as $data) {
            $gallery = collect($data['gallery'])
                ->map(fn ($file) => $this->fetch('media-uploader/' . $file, 'projects/gallery'))
                ->filter()->values()->all();

            $project = Project::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'title' => $data['title'],
                    'client' => $data['client'],
                    'description' => $data['description'],
                    'challenge' => trim($data['challenge']),
                    'results' => trim($data['results']),
                    'featured_image' => $this->fetch('media-uploader/' . $data['image'], 'projects/featured') ?? '',
                    'gallery' => $gallery ?: null,
                    'category' => $data['category'],
                    'is_featured' => true,
                    'is_published' => true,
                    'project_date' => $data['date'],
                ]
            );

            $project->services()->sync(
                collect($data['services'])->map(fn ($slug) => $serviceIds[$slug] ?? null)->filter()->values()->all()
            );

            $this->command->info("Project: {$project->title}");
        }
    }

    private function importCommunicationAssets(): void
    {
        $assets = [
            [
                'title' => 'Baseline KAP Survey Report',
                'file' => 'Baseline KAP Survey Report.pdf',
                'excerpt' => 'Comprehensive baseline Knowledge, Attitudes, and Practices survey report providing essential insights and data analysis.',
            ],
            [
                'title' => 'Communications & Marketing Strategy',
                'file' => 'Communications & Marketing Strategy.pdf',
                'excerpt' => 'Strategic framework for communications and marketing initiatives, outlining key approaches and methodologies.',
            ],
            [
                'title' => 'End of Activity Report - ABI Trust',
                'file' => 'END OF ACTIVITY REPORT-ABI TRUST_compressed.pdf',
                'excerpt' => 'Comprehensive end-of-activity report detailing project outcomes, achievements, and key learnings from the ABI Trust initiative.',
            ],
            [
                'title' => 'UEUBI 2025 Summary Report',
                'file' => 'UEUBI 2025 Summary Report_final_compressed_250428_181430 (1)-1.pdf',
                'excerpt' => 'Final summary report for the Uganda-Europe Union Business Initiative 2025, highlighting key outcomes and strategic partnerships.',
            ],
            [
                'title' => 'European Union and Uganda Partnership 2025',
                'file' => 'European Union and Uganda Partnership 2025_v6-1.pdf',
                'excerpt' => 'Strategic partnership document outlining collaboration frameworks and initiatives between the European Union and Uganda for 2025.',
            ],
            [
                'title' => 'Furaha OBUL Flyers',
                'file' => 'Furaha_OBUL Flyers_v1.3c (1).pdf',
                'excerpt' => 'Marketing and communication flyers for the Furaha OBUL initiative, designed to promote awareness and engagement.',
            ],
        ];

        foreach ($assets as $data) {
            $slug = Str::slug($data['title']);

            $resource = Resource::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'type' => 'communication_asset',
                    'excerpt' => $data['excerpt'],
                    'content' => '<p>' . e($data['excerpt']) . '</p>',
                    'file' => $this->fetch('downloadable/' . $data['file'], 'resources/files', $slug . '.pdf'),
                    'author' => 'RoyalWay Media',
                    'is_published' => true,
                    'published_at' => '2025-08-04',
                ]
            );

            $this->command->info("Communication asset: {$resource->title}");
        }
    }

    private function fetch(string $legacyPath, string $directory, ?string $saveAs = null): ?string
    {
        $fileName = basename($legacyPath);
        $destination = $directory . '/' . ($saveAs ?? $fileName);

        if (Storage::disk('public')->exists($destination)) {
            return $destination;
        }

        $local = storage_path('app/legacy-uploads/' . $fileName);

        if (is_file($local)) {
            Storage::disk('public')->put($destination, file_get_contents($local));

            return $destination;
        }

        $url = self::LEGACY_URL . dirname($legacyPath) . '/' . rawurlencode($fileName);
        $response = Http::timeout(120)->withoutVerifying()->get($url);

        if ($response->successful()) {
            Storage::disk('public')->put($destination, $response->body());

            return $destination;
        }

        $this->command->warn("Could not fetch: {$url}");

        return null;
    }
}
