#!/bin/bash
# File: generate-filament-pages.sh
# Save this in your project root and run: bash generate-filament-pages.sh

echo "Generating Filament Resource Pages..."

# Projects
mkdir -p app/Filament/Resources/ProjectResource/Pages
php artisan make:filament-page ListProjects --resource=ProjectResource --type=ListRecords
php artisan make:filament-page CreateProject --resource=ProjectResource --type=CreateRecord
php artisan make:filament-page EditProject --resource=ProjectResource --type=EditRecord

# Services
mkdir -p app/Filament/Resources/ServiceResource/Pages
php artisan make:filament-page ListServices --resource=ServiceResource --type=ListRecords
php artisan make:filament-page CreateService --resource=ServiceResource --type=CreateRecord
php artisan make:filament-page EditService --resource=ServiceResource --type=EditRecord

# Team Members
mkdir -p app/Filament/Resources/TeamMemberResource/Pages
php artisan make:filament-page ListTeamMembers --resource=TeamMemberResource --type=ListRecords
php artisan make:filament-page CreateTeamMember --resource=TeamMemberResource --type=CreateRecord
php artisan make:filament-page EditTeamMember --resource=TeamMemberResource --type=EditRecord

# Resources
mkdir -p app/Filament/Resources/ResourceResource/Pages
php artisan make:filament-page ListResources --resource=ResourceResource --type=ListRecords
php artisan make:filament-page CreateResource --resource=ResourceResource --type=CreateRecord
php artisan make:filament-page EditResource --resource=ResourceResource --type=EditRecord

# Policies
mkdir -p app/Filament/Resources/PolicyResource/Pages
php artisan make:filament-page ListPolicies --resource=PolicyResource --type=ListRecords
php artisan make:filament-page CreatePolicy --resource=PolicyResource --type=CreateRecord
php artisan make:filament-page EditPolicy --resource=PolicyResource --type=EditRecord

# Contact Submissions
mkdir -p app/Filament/Resources/ContactSubmissionResource/Pages
php artisan make:filament-page ListContactSubmissions --resource=ContactSubmissionResource --type=ListRecords
php artisan make:filament-page ViewContactSubmission --resource=ContactSubmissionResource --type=ViewRecord

# Event Briefs
mkdir -p app/Filament/Resources/EventBriefResource/Pages
php artisan make:filament-page ListEventBriefs --resource=EventBriefResource --type=ListRecords
php artisan make:filament-page ViewEventBrief --resource=EventBriefResource --type=ViewRecord

# Partners
mkdir -p app/Filament/Resources/PartnerResource/Pages
php artisan make:filament-page ListPartners --resource=PartnerResource --type=ListRecords
php artisan make:filament-page CreatePartner --resource=PartnerResource --type=CreateRecord
php artisan make:filament-page EditPartner --resource=PartnerResource --type=EditRecord

# Site Settings
mkdir -p app/Filament/Resources/SiteSettingResource/Pages
php artisan make:filament-page ListSiteSettings --resource=SiteSettingResource --type=ListRecords
php artisan make:filament-page CreateSiteSetting --resource=SiteSettingResource --type=CreateRecord
php artisan make:filament-page EditSiteSetting --resource=SiteSettingResource --type=EditRecord

echo "✅ All Filament pages generated successfully!"
echo "Now run: php artisan filament:optimize"
