<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    private const LEGACY_URL = 'https://royalwaymedia.com/assets/uploads/media-uploader/';

    private const PARTNERS = [
        ['name' => 'European Union', 'file' => 'g1701374901.png', 'website' => 'https://european-union.europa.eu/index_en'],
        ['name' => 'UNICEF', 'file' => 'o1701374904.png', 'website' => 'https://www.unicef.org/'],
        ['name' => 'United Nations Development Programme', 'file' => 'n1701374904.png', 'website' => 'https://www.undp.org/'],
        ['name' => 'Agricultural Business Initiative (aBi)', 'file' => 'p1701374905.png', 'website' => 'https://www.abi.co.ug/'],
        ['name' => 'Standard Chartered Bank', 'file' => 'k1701374903.png', 'website' => 'https://www.sc.com'],
        ['name' => 'Airtel Uganda', 'file' => '21701374896.png', 'website' => 'https://www.airtel.co.ug'],
        ['name' => 'UN Women', 'file' => 'm1701374904.png', 'website' => 'https://www.unwomen.org/en'],
        ['name' => 'ABSA', 'file' => 'a1701374896.png', 'website' => 'https://www.absa.co.ug'],
        ['name' => 'DTB', 'file' => 'e1701374900.png', 'website' => 'https://dtbu.dtbafrica.com'],
        ['name' => 'British Council', 'file' => 'd1701374900.png', 'website' => 'https://www.britishcouncil.org/'],
        ['name' => 'Amref Health Africa', 'file' => 'c1701374899.png', 'website' => 'https://amref.org/'],
        ['name' => 'Embassy of Ireland', 'file' => 'f1701374901.png', 'website' => 'https://www.dfa.ie/irish-embassy/uganda/'],
        ['name' => 'Johns Hopkins University', 'file' => 'h1701374901.png', 'website' => 'https://www.jhu.edu/'],
        ['name' => 'Private Sector Foundation Uganda', 'file' => 'i1701374902.png', 'website' => 'https://www.psfuganda.org/'],
        ['name' => 'SNV', 'file' => 'j1701374902.png', 'website' => 'https://www.snv.org/'],
        ['name' => 'Uganda Tourism Board', 'file' => 'l1701374903.png', 'website' => 'https://utb.go.ug/'],
    ];

    /** Existing short names used by earlier placeholder rows */
    private const ALIASES = [
        'European Union' => ['EU'],
        'UNICEF' => ['Unicef'],
        'United Nations Development Programme' => ['UNDP'],
        'Agricultural Business Initiative (aBi)' => ['ABI', 'aBi', 'aBi Trust', 'Agricultural Business Initiative'],
        'Standard Chartered Bank' => ['Standard Chartered', 'SCB'],
        'Airtel Uganda' => ['Airtel'],
        'UN Women' => ['UN WOMEN'],
        'ABSA' => ['Absa', 'ABSA Bank'],
        'DTB' => ['Diamond Trust Bank'],
        'British Council' => [],
        'Amref Health Africa' => ['Amref', 'AMREF'],
        'Embassy of Ireland' => ['Irish Embassy'],
        'Johns Hopkins University' => ['Johns Hopkins', 'JHU'],
        'Private Sector Foundation Uganda' => ['PSFU'],
        'SNV' => [],
        'Uganda Tourism Board' => ['UTB'],
    ];

    /** Folders searched for the legacy logo files */
    private const LOCAL_DIRS = [
        'app/legacy-uploads',
        'app/private/legacy-uploads',
        'app/public/legacy-uploads',
    ];

    /** project slug => partner name */
    private const PROJECT_PARTNER = [
        '10-years-of-impact-standard-chartered-bank' => 'Standard Chartered Bank',
        'airtel-nationwide-mobile-marketing-success' => 'Airtel Uganda',
        'unicefs-media-services-for-child-rights-in-uganda' => 'UNICEF',
        'the-european-unions-impact-in-uganda' => 'European Union',
        'cultivating-prosperity-abis-impact' => 'Agricultural Business Initiative (aBi)',
    ];

    public function run(): void
    {
        $ids = [];

        foreach (self::PARTNERS as $index => $data) {
            $logo = $this->fetch($data['file'], Str::slug($data['name']) . '.png');

            $names = array_merge([$data['name']], self::ALIASES[$data['name']] ?? []);

            $partner = Partner::whereIn('name', $names)->orderBy('id')->first() ?? new Partner();

            $partner->fill([
                'name' => $data['name'],
                'logo' => $logo ?? ($partner->logo ?? ''),
                'website' => $data['website'],
                'order' => $index + 1,
                'is_active' => (bool) $logo,
            ])->save();

            Partner::whereIn('name', $names)->where('id', '!=', $partner->id)->update(['is_active' => false]);

            $ids[$data['name']] = $partner->id;
            $this->command->info("Partner: {$partner->name}" . ($logo ? '' : '  (logo missing — set inactive)'));
        }

        $this->deactivateBrokenPartners(array_keys($ids));
        $this->linkProjects($ids);
    }

    private function deactivateBrokenPartners(array $keep): void
    {
        Partner::whereNotIn('name', $keep)->get()->each(function (Partner $partner) {
            if (! $partner->logo || ! Storage::disk('public')->exists($partner->logo)) {
                $partner->update(['is_active' => false]);
                $this->command->warn("Deactivated (missing logo): {$partner->name}");
            }
        });
    }

    private function linkProjects(array $ids): void
    {
        if (! Schema::hasColumn('projects', 'partner_id')) {
            return;
        }

        foreach (self::PROJECT_PARTNER as $slug => $name) {
            $updated = Project::where('slug', $slug)->update(['partner_id' => $ids[$name] ?? null]);
            $this->command->info($updated ? "Project linked: {$slug} → {$name}" : "Project not found: {$slug}");
        }
    }

    private function fetch(string $file, string $saveAs): ?string
    {
        $disk = Storage::disk('public');
        $destination = 'partners/' . $saveAs;

        if ($disk->exists($destination)) {
            return $destination;
        }

        $dirs = array_merge(
            array_map(fn ($dir) => storage_path($dir), self::LOCAL_DIRS),
            [base_path('legacy-uploads'), getenv('HOME') . '/Downloads/legacy-uploads']
        );

        foreach ($dirs as $dir) {
            $local = rtrim($dir, '/') . '/' . $file;

            if (is_file($local)) {
                $disk->put($destination, file_get_contents($local));

                return $destination;
            }
        }

        try {
            $response = Http::connectTimeout(5)->timeout(20)->withoutVerifying()->get(self::LEGACY_URL . rawurlencode($file));

            if ($response->successful()) {
                $disk->put($destination, $response->body());

                return $destination;
            }
        } catch (\Throwable $e) {
            // fall through to warning
        }

        $this->command->warn("Logo not found locally or online: {$file}. Looked in: " . implode(', ', $dirs));

        return null;
    }
}
