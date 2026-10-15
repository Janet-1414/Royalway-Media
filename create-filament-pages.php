<?php
/**
 * File: create-filament-pages.php
 * Run this with: php create-filament-pages.php
 *
 * This script creates all Filament page files with proper code
 */

$pages = [
    // Projects
    'ProjectResource' => [
        'ListProjects' => 'ListRecords',
        'CreateProject' => 'CreateRecord',
        'EditProject' => 'EditRecord',
    ],
    // Services
    'ServiceResource' => [
        'ListServices' => 'ListRecords',
        'CreateService' => 'CreateRecord',
        'EditService' => 'EditRecord',
    ],
    // Team Members
    'TeamMemberResource' => [
        'ListTeamMembers' => 'ListRecords',
        'CreateTeamMember' => 'CreateRecord',
        'EditTeamMember' => 'EditRecord',
    ],
    // Resources
    'ResourceResource' => [
        'ListResources' => 'ListRecords',
        'CreateResource' => 'CreateRecord',
        'EditResource' => 'EditRecord',
    ],
    // Policies
    'PolicyResource' => [
        'ListPolicies' => 'ListRecords',
        'CreatePolicy' => 'CreateRecord',
        'EditPolicy' => 'EditRecord',
    ],
    // Contact Submissions
    'ContactSubmissionResource' => [
        'ListContactSubmissions' => 'ListRecords',
        'ViewContactSubmission' => 'ViewRecord',
    ],
    // Event Briefs
    'EventBriefResource' => [
        'ListEventBriefs' => 'ListRecords',
        'ViewEventBrief' => 'ViewRecord',
    ],
    // Partners
    'PartnerResource' => [
        'ListPartners' => 'ListRecords',
        'CreatePartner' => 'CreateRecord',
        'EditPartner' => 'EditRecord',
    ],
    // Site Settings
    'SiteSettingResource' => [
        'ListSiteSettings' => 'ListRecords',
        'CreateSiteSetting' => 'CreateRecord',
        'EditSiteSetting' => 'EditRecord',
    ],
];

foreach ($pages as $resource => $pageClasses) {
    $dir = "app/Filament/Resources/{$resource}/Pages";

    // Create directory if it doesn't exist
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "✅ Created directory: {$dir}\n";
    }

    foreach ($pageClasses as $className => $baseClass) {
        $filePath = "{$dir}/{$className}.php";

        $content = generatePageContent($resource, $className, $baseClass);

        file_put_contents($filePath, $content);
        echo "✅ Created: {$filePath}\n";
    }
}

echo "\n🎉 All Filament page files created successfully!\n";

function generatePageContent($resource, $className, $baseClass) {
    $namespace = "App\\Filament\\Resources\\{$resource}\\Pages";
    $useResource = "App\\Filament\\Resources\\{$resource}";

    if ($baseClass === 'ListRecords') {
        return <<<PHP
<?php

namespace {$namespace};

use {$useResource};
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class {$className} extends ListRecords
{
    protected static string \$resource = {$resource}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

PHP;
    }

    if ($baseClass === 'CreateRecord') {
        return <<<PHP
<?php

namespace {$namespace};

use {$useResource};
use Filament\Resources\Pages\CreateRecord;

class {$className} extends CreateRecord
{
    protected static string \$resource = {$resource}::class;
}

PHP;
    }

    if ($baseClass === 'EditRecord') {
        return <<<PHP
<?php

namespace {$namespace};

use {$useResource};
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class {$className} extends EditRecord
{
    protected static string \$resource = {$resource}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

PHP;
    }

    if ($baseClass === 'ViewRecord') {
        return <<<PHP
<?php

namespace {$namespace};

use {$useResource};
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class {$className} extends ViewRecord
{
    protected static string \$resource = {$resource}::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}

PHP;
    }

    return '';
}
