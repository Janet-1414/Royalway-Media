#!/bin/bash
# File: create-all-filament-pages.sh
# Make executable: chmod +x create-all-filament-pages.sh
# Run: ./create-all-filament-pages.sh

echo "🚀 Creating all Filament Page files..."

# Function to create List page
create_list_page() {
    local resource=$1
    local classname=$2
    local filepath="app/Filament/Resources/${resource}Resource/Pages/${classname}.php"

    cat > "$filepath" << EOF
<?php

namespace App\Filament\Resources\\${resource}Resource\Pages;

use App\Filament\Resources\\${resource}Resource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ${classname} extends ListRecords
{
    protected static string \$resource = ${resource}Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
EOF
    echo "✅ Created: $filepath"
}

# Function to create Create page
create_create_page() {
    local resource=$1
    local classname=$2
    local filepath="app/Filament/Resources/${resource}Resource/Pages/${classname}.php"

    cat > "$filepath" << EOF
<?php

namespace App\Filament\Resources\\${resource}Resource\Pages;

use App\Filament\Resources\\${resource}Resource;
use Filament\Resources\Pages\CreateRecord;

class ${classname} extends CreateRecord
{
    protected static string \$resource = ${resource}Resource::class;
}
EOF
    echo "✅ Created: $filepath"
}

# Function to create Edit page
create_edit_page() {
    local resource=$1
    local classname=$2
    local filepath="app/Filament/Resources/${resource}Resource/Pages/${classname}.php"

    cat > "$filepath" << EOF
<?php

namespace App\Filament\Resources\\${resource}Resource\Pages;

use App\Filament\Resources\\${resource}Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class ${classname} extends EditRecord
{
    protected static string \$resource = ${resource}Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
EOF
    echo "✅ Created: $filepath"
}

# Function to create View page
create_view_page() {
    local resource=$1
    local classname=$2
    local filepath="app/Filament/Resources/${resource}Resource/Pages/${classname}.php"

    cat > "$filepath" << EOF
<?php

namespace App\Filament\Resources\\${resource}Resource\Pages;

use App\Filament\Resources\\${resource}Resource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ${classname} extends ViewRecord
{
    protected static string \$resource = ${resource}Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
EOF
    echo "✅ Created: $filepath"
}

# Create directories
mkdir -p app/Filament/Resources/ProjectResource/Pages
mkdir -p app/Filament/Resources/ServiceResource/Pages
mkdir -p app/Filament/Resources/TeamMemberResource/Pages
mkdir -p app/Filament/Resources/ResourceResource/Pages
mkdir -p app/Filament/Resources/PolicyResource/Pages
mkdir -p app/Filament/Resources/ContactSubmissionResource/Pages
mkdir -p app/Filament/Resources/EventBriefResource/Pages
mkdir -p app/Filament/Resources/PartnerResource/Pages
mkdir -p app/Filament/Resources/SiteSettingResource/Pages

# Projects
create_list_page "Project" "ListProjects"
create_create_page "Project" "CreateProject"
create_edit_page "Project" "EditProject"

# Services
create_list_page "Service" "ListServices"
create_create_page "Service" "CreateService"
create_edit_page "Service" "EditService"

# Team Members
create_list_page "TeamMember" "ListTeamMembers"
create_create_page "TeamMember" "CreateTeamMember"
create_edit_page "TeamMember" "EditTeamMember"

# Resources
create_list_page "Resource" "ListResources"
create_create_page "Resource" "CreateResource"
create_edit_page "Resource" "EditResource"

# Policies
create_list_page "Policy" "ListPolicies"
create_create_page "Policy" "CreatePolicy"
create_edit_page "Policy" "EditPolicy"

# Contact Submissions
create_list_page "ContactSubmission" "ListContactSubmissions"
create_view_page "ContactSubmission" "ViewContactSubmission"

# Event Briefs
create_list_page "EventBrief" "ListEventBriefs"
create_view_page "EventBrief" "ViewEventBrief"

# Partners
create_list_page "Partner" "ListPartners"
create_create_page "Partner" "CreatePartner"
create_edit_page "Partner" "EditPartner"

# Site Settings
create_list_page "SiteSetting" "ListSiteSettings"
create_create_page "SiteSetting" "CreateSiteSetting"
create_edit_page "SiteSetting" "EditSiteSetting"

echo ""
echo "🎉 All Filament page files created successfully!"
echo ""
echo "Now run:"
echo "  php artisan filament:optimize"
echo "  php artisan optimize:clear"
