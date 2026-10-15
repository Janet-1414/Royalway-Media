# RoyalWay Media - Laravel Filament Implementation Plan

## Phase 1: Database Structure (Migrations)
### 1.1 Core Content Tables
- **projects** - Project portfolio items
- **services** - Service offerings
- **team_members** - Team member profiles
- **resources** - Blog posts, publications, policies, communication assets

### 1.2 Form Submission Tables
- **contact_submissions** - Contact form entries
- **event_briefs** - Event management brief submissions

### 1.3 Settings Tables
- **site_settings** - General site configuration
- **partners** - Partner/client logos
- **policies** - Company policies (corruption, privacy, terms, etc.)
- **testimonials** - Client testimonials (optional for future)

---

## Phase 2: Models & Relationships
### 2.1 Models to Create
1. `Project` - with image upload, gallery, stats JSON
2. `Service` - with icon/image upload
3. `TeamMember` - with photo upload, social links JSON
4. `Resource` - polymorphic for different content types
5. `Policy` - for company policies (corruption, privacy, terms, etc.)
6. `ContactSubmission` - with email notification
7. `EventBrief` - with detailed form data, email notification
8. `SiteSetting` - key-value pairs for site config
9. `Partner` - for logo carousel

### 2.2 Model Features
- Sluggable trait for SEO-friendly URLs
- Image upload handling with Spatie Media Library
- Scopes for published/featured content
- Proper relationships and accessors

---

## Phase 3: Filament Resources (Admin Dashboard)
### 3.1 Main Resources
1. **ProjectResource** 
   - Form: title, client, description, challenge, objectives, activities, results
   - Rich text editor for content
   - Image uploads for featured image and gallery
   - Repeater for stats/metrics
   - Category select, tags input

2. **ServiceResource**
   - Simple form with ordering
   - Icon picker or image upload
   - Toggle for active/inactive

3. **TeamMemberResource**
   - Photo upload
   - Social links repeater
   - Ordering functionality

4. **ResourceResource**
   - Type selector (blog/publication/policy/asset)
   - File upload for downloadables
   - Rich text editor
   - Publishing controls

5. **ContactSubmissionResource**
   - Read-only fields
   - Status updates (new/read/replied)
   - Email preview
   - Quick reply action

6. **EventBriefResource**
   - Read-only comprehensive form data
   - Status tracking
   - PDF export functionality

### 3.2 Settings & Configuration
7. **PartnerResource** - Logo management
8. **PolicyResource** - Company policies management with rich text editor
9. **SiteSettingResource** - Global site settings

---

## Phase 4: Frontend (Blade Templates)
### 4.1 Layout Files
- `layouts/app.blade.php` - Main layout
- `layouts/partials/navbar.blade.php`
- `layouts/partials/footer.blade.php`

### 4.2 Page Templates
1. `welcome.blade.php` (index.html) - Homepage
2. `about.blade.php` - About page with team
3. `services/index.blade.php` - Services listing
4. `projects/index.blade.php` - Projects with filters
5. `projects/show.blade.php` - Single project (project-detail.html)
6. `resources/index.blade.php` - Resources listing
7. `contact.blade.php` - Contact form
8. `event-brief.blade.php` - Event brief form
9. `policies/index.blade.php` - Policies listing page
10. `policies/show.blade.php` - Single policy page (corruption.html template)

### 4.3 Components
- `components/project-card.blade.php`
- `components/service-card.blade.php`
- `components/team-member.blade.php`
- `components/partner-logo.blade.php`

---

## Phase 5: Controllers & Routes
### 5.1 Controllers
1. `HomeController` - Homepage with featured projects/services
2. `ProjectController` - Index and show methods
3. `ServiceController` - Index method
4. `ResourceController` - Index by type
5. `PolicyController` - Index and show methods
6. `ContactController` - Form submission + email
7. `EventBriefController` - Form submission + email
8. `PageController` - Static pages (about)

### 5.2 Routes Structure
```
/ - Homepage
/about - About page
/services - Services listing
/projects - Projects with filters
/projects/{slug} - Single project
/resources - Resources listing
/resources/{type} - Filtered resources
/policies - Policies listing
/policies/{slug} - Single policy (corruption, privacy, terms, etc.)
/contact - Contact page
/event-brief - Event brief form
```

---

## Phase 6: Email Notifications
### 6.1 Mailables
1. `ContactSubmissionMail` - Notification to admin
2. `ContactConfirmationMail` - Auto-reply to user
3. `EventBriefSubmissionMail` - Notification to admin
4. `EventBriefConfirmationMail` - Auto-reply to user

### 6.2 Email Templates
- Branded email layouts matching site design
- Include submission details
- Professional formatting

---

## Phase 7: Additional Features
### 7.1 SEO & Meta
- Dynamic meta tags for all pages
- OpenGraph images for social sharing
- Sitemap generation

### 7.2 Form Validation
- Request classes for contact and event brief forms
- Proper error messages
- CSRF protection

### 7.3 Asset Management
- Vite for compiling existing CSS/JS
- Image optimization
- Lazy loading for images

---

## Phase 8: Testing & Deployment
### 8.1 Testing Checklist
- [ ] All forms submit correctly
- [ ] Emails send properly (use Mailtrap for testing)
- [ ] Admin dashboard fully functional
- [ ] Images upload and display correctly
- [ ] Filters work on projects page
- [ ] Responsive design maintained
- [ ] Performance optimization

### 8.2 Deployment Setup
- Environment configuration
- Database migration
- Storage symlink
- Queue configuration for emails
- Cache configuration

---

## Implementation Order (Recommended)

1. **Start Here**: Migrations → Models → Seeders (for testing)
2. **Admin First**: Filament Resources (allows content entry)
3. **Frontend**: Blade templates (can test with real data)
4. **Forms**: Controllers + Email notifications
5. **Polish**: SEO, validation, optimization

---

## File Structure Overview
```
app/
├── Models/
├── Http/Controllers/
├── Mail/
├── Filament/Resources/
database/
├── migrations/
├── seeders/
resources/
├── views/
│   ├── layouts/
│   ├── components/
│   ├── projects/
│   ├── services/
│   ├── resources/
│   └── emails/
├── css/
└── js/
public/
├── assets/ (your existing assets)
```

---

## Next Steps
Which phase would you like to start with? I recommend:
1. **Migrations** (7 separate files - including policies table)
2. **Models** (9 separate files - including Policy model)
3. **Filament Resources** (9 separate files - including PolicyResource)

**Policy Features to Include:**
- Multiple policy types (Corruption, Privacy, Terms, Data Protection, etc.)
- Rich text editor for policy content
- Effective date tracking
- Version history (optional)
- Published/Draft status
- PDF export functionality
- SEO-friendly URLs (slug-based)

Let me know which artifacts you'd like me to create first!