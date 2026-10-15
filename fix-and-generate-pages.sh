#!/bin/bash
# File: fix-and-generate-pages.sh
# This script temporarily disables getPages() methods, generates pages, then restores them

echo "🔧 Fixing Filament Resources and generating pages..."

# Step 1: Comment out getPages() methods in all Resource files
echo "Step 1: Temporarily commenting out getPages() methods..."

cd app/Filament/Resources

for file in *Resource.php; do
    if [ -f "$file" ]; then
        # Create backup
        cp "$file" "$file.backup"

        # Comment out the getPages() method
        sed -i.tmp '/public static function getPages(): array/,/^    }$/s/^/\/\/ /' "$file"
        rm "$file.tmp" 2>/dev/null

        echo "  ✓ Commented out getPages() in $file"
    fi
done

cd ../../..

# Step 2: Generate all the pages
echo ""
echo "Step 2: Generating Filament pages..."

# Projects
echo "  Generating Project pages..."
php artisan make:filament-page ListProjects --resource=ProjectResource --type=ListRecords
php artisan make:filament-page CreateProject --resource=ProjectResource --type=CreateRecord
php artisan make:filament-page EditProject --resource=ProjectResource --type=EditRecord

# Services
echo "  Generating Service pages..."
php artisan make:filament-page ListServices --resource=ServiceResource --type=ListRecords
php artisan make:filament-page CreateService --resource=ServiceResource --type=CreateRecord
php artisan make:filament-page EditService --resource=ServiceResource --type=EditRecord

# Team Members
echo "  Generating TeamMember pages..."
php artisan make:filament-page ListTeamMembers --resource=TeamMemberResource --type=ListRecords
php artisan make:filament-page CreateTeamMember --resource=TeamMemberResource --type=CreateRecord
php artisan make:filament-page EditTeamMember --resource=TeamMemberResource --type=EditRecord

# Resources
echo "  Generating Resource pages..."
php artisan make:filament-page ListResources --resource=ResourceResource --type=ListRecords
php artisan make:filament-page CreateResource --resource=ResourceResource --type=CreateRecord
php artisan make:filament-page EditResource --resource=ResourceResource --type=EditRecord

# Policies
echo "  Generating Policy pages..."
php artisan make:filament-page ListPolicies --resource=PolicyResource --type=ListRecords
php artisan make:filament-page CreatePolicy --resource=PolicyResource --type=CreateRecord
php artisan make:filament-page EditPolicy --resource=PolicyResource --type=EditRecord

# Contact Submissions
echo "  Generating ContactSubmission pages..."
php artisan make:filament-page ListContactSubmissions --resource=ContactSubmissionResource --type=ListRecords
php artisan make:filament-page ViewContactSubmission --resource=ContactSubmissionResource --type=ViewRecord

# Event Briefs
echo "  Generating EventBrief pages..."
php artisan make:filament-page ListEventBriefs --resource=EventBriefResource --type=ListRecords
php artisan make:filament-page ViewEventBrief --resource=EventBriefResource --type=ViewRecord

# Partners
echo "  Generating Partner pages..."
php artisan make:filament-page ListPartners --resource=PartnerResource --type=ListRecords
php artisan make:filament-page CreatePartner --resource=PartnerResource --type=CreateRecord
php artisan make:filament-page EditPartner --resource=PartnerResource --type=EditRecord

# Site Settings
echo "  Generating SiteSetting pages..."
php artisan make:filament-page ListSiteSettings --resource=SiteSettingResource --type=ListRecords
php artisan make:filament-page CreateSiteSetting --resource=SiteSettingResource --type=CreateRecord
php artisan make:filament-page EditSiteSetting --resource=SiteSettingResource --type=EditRecord

# Step 3: Restore original Resource files
echo ""
echo "Step 3: Restoring original Resource files..."

cd app/Filament/Resources

for file in *.backup; do
    if [ -f "$file" ]; then
        original="${file%.backup}"
        mv "$file" "$original"
        echo "  ✓ Restored $original"
    fi
done

cd ../../..

# Step 4: Optimize
echo ""
echo "Step 4: Optimizing Filament..."
php artisan filament:optimize
php artisan optimize:clear

echo ""
echo "✅ All done! Your Filament pages have been generated and Resource files restored."
echo "You can now access your admin panel at /admin"
