# Resources overhaul: change notes

Branch: `feature/resources-overhaul` (nothing committed).

This folder was not a git repository, so I ran `git init`, created the branch and staged the original files as a baseline (`git add -A`) without committing. To review:

- `git diff` shows every change to existing files
- `git status` lists new files as untracked

## 1. What was built

### Navigation, Publications removal, redirects
- **Resources dropdown** (`#resources-dropdown`) with News & Insights, Communication Assets and Policies. It works like the Services dropdown: hover or focus on desktop, tap to open on mobile. The CSS is a copy of the Services rules under the new id. Resources shows as active on all three pages and on article pages.
- `/resources` returns a 301 to `/insights`. The route name `resources.index` is kept. `/resources?type=communication_asset` goes to `/communication-assets` instead.
- `/communication-assets` is now the real page (route `assets.index`), not a redirect. `/blog` still returns a 301 to `/insights`.
- `/resources/{slug}` still serves article and asset pages. It now returns 404 for the hidden `publication` and `other` types.
- **Publications removed** from the nav, footer, Filament type options and colours, controller type lists, `scopePublications` and the sitemap. "Other" is also gone from the admin options.
- The old `resources/index.blade.php` listing was deleted because nothing uses it any more.
- **Old rows are kept.** Rows with type `publication` or `other` are hidden from every public page through `Resource::PUBLIC_TYPES` and `scopePublicTypes()`. In the admin they show a grey "Hidden (old type)" badge, and there is a filter called "Hidden from website (old types)".
- **Footer:** Publications is removed, Blog is now News & Insights (`insights.index`), and Resources is now Communication Assets (`assets.index`).
- **Sitemap:** includes `/insights`, `/communication-assets` and published News & Insights articles. It no longer includes `/resources` or the publication and other types.

### Page heroes (CMS)
- `partials/page-hero.blade.php` is built on the existing `.in-hero` styles: a portrait image card on the left, a tinted panel and a large heading with the short accent rule. When no image is uploaded it shows a brand gradient.
- It is used on `/insights`, `/communication-assets` and `/policies`. The policy content itself is unchanged.

### News & Insights page
- **Lead story:** the newest article marked "Lead story" (`is_featured`), or the newest article if none is marked. It sits next to a stack of the 4 latest headlines.
- Topic chips, a search box, a card grid (image, topic, headline, date, author, reading time) and pagination follow.
- The lead story and the headline stack are left out of the grid so nothing appears twice. When a topic or search filter is active, the lead story and stack are hidden and the grid shows every match.
- **Reading time** is worked out from the word count at 200 words per minute. It is not stored.
- **Article page** (`resources/show.blade.php`) is a single 46rem reading column. Order: back link, topic, title, standfirst (the excerpt), author, date, reading time, cover image, content, file box (if a file is attached), share bar, reactions, comments, then related articles.
- Communication assets with no content still work: the page shows the excerpt plus Preview and Download.

### Sharing
- Buttons: Copy link (with a fallback and a "Copied" message), LinkedIn, X, Facebook, WhatsApp and Email. All use plain share URLs with no third-party scripts.
- A native Share button appears only where `navigator.share` exists.
- Open Graph and Twitter tags: `seo-meta.blade.php` now accepts `@section('og_type')`. The layout head has a new `@stack('meta')`, which articles use for `article:published_time`, `article:section` and the reading time label. The OG description comes from the meta description, then the excerpt, then the start of the content.

### Reader engagement
- **Views:** the article page sends a small `sendBeacon` POST to `/resources/{slug}/view`.
  - Counted once per visitor per day, using `sha256(IP | user agent | APP_KEY)`. Raw IPs are never stored.
  - Bots and logged-in admins are skipped.
  - `views_count` on `resources` is kept up to date for fast sorting.
  - The beacon is exempt from CSRF so it still works if a page cache serves an old token. It is throttled and can only add one view row per visitor per day.
  - I used the beacon in all cases. I found no page caching in the app, but the live host may cache pages, and the beacon works either way.
- **Reactions:** Like, Insightful and Inspiring, with one reaction per visitor per article.
  - Clicking another reaction changes it. Clicking the same one again removes it.
  - The visitor is identified by a random `rw_vid` cookie (1 year), hashed with APP_KEY. The IP is also stored as a salted hash.
  - At most 5 reactions are accepted per network (IP hash) per article.
  - The AJAX POST endpoint uses `throttle:20,1`, and counts update without a page reload.
- **Comments:** name, email (never shown publicly), comment, a honeypot, the timing token and the existing reCAPTCHA v3 (action `comment`) through `SpamGuard`.
  - Throttled at 6 per minute, plus SpamGuard's 5 per hour per IP.
  - Every comment starts as `pending`.
  - An email alert goes to the same address as the contact form (`config('mail.admin_email')`, falling back to sales@royalwaymedia.com).
  - No replies or threads. The note under the form says the email will not be published.
- Each throttle has its own counter (`throttle:30,1,resource-views`, `throttle:20,1,resource-reactions`, `throttle:6,1,resource-comments`). Without the prefix, Laravel shares one counter per IP across all throttled routes, and testing showed comments being blocked after a few reactions.

### Communication Assets page
- `/communication-assets` shows the CMS hero, search, a file type filter (`?format=documents|images|media|other`), a project filter (`?project=slug`) and pagination (12 per page).
- **Cards:** thumbnail (the featured image, or a file type icon), file type badge, title, short excerpt, date, Preview and Download.
- **Preview modal** uses the native `<dialog>` element with plain JS:
  - PDF and TXT in an iframe, images inline, MP4 and WEBM with the HTML5 video player, MP3 with the HTML5 audio player
  - Word, Excel and PowerPoint through the Microsoft Office online viewer, with a visible note and a Download button
  - CSV has no in-browser preview, so it is download only
- **Shareable previews:** `?preview=slug` opens the modal on load, and the address bar updates while the modal is open.

### Assets linked to projects
- New pivot table `project_resource`, with `Project::communicationAssets()` and `Resource::projects()`.
- The project page has a "Campaign materials" section (shown only when the project has assets). It shows up to 6 compact cards with Preview and Download, and a "View all materials" link to `/communication-assets?project={slug}`.

## 2. Database changes

| Laravel migration | What it does |
|---|---|
| `2026_11_10_000001_create_page_heroes_table` | `page_heroes` (key unique, heading, intro, image, timestamps) |
| `2026_11_10_000002_add_engagement_fields_to_resources_table` | `resources.topic`, `is_featured` (default 0), `allow_comments` (default 1), `views_count` (default 0) |
| `2026_11_10_000003_create_resource_views_table` | `resource_views` (resource_id, visitor_hash, viewed_on), unique on all three |
| `2026_11_10_000004_create_resource_reactions_table` | `resource_reactions` (resource_id, visitor_hash, ip_hash, type), unique on resource_id and visitor_hash |
| `2026_11_10_000005_create_resource_comments_table` | `resource_comments` (resource_id, name, email, body, status, ip_hash, timestamps) |
| `2026_11_10_000006_create_project_resource_table` | `project_resource` (project_id, resource_id), unique pair |

Every migration is guarded with `Schema::hasTable` or `Schema::hasColumn`.

**Live SQL:** `database/live-sql/resources-overhaul.sql`.
- It is safe to run more than once. It checks before every create or alter, adds the two settings rows only if they are missing, and records the six migrations in the `migrations` table.
- Its last statement is a read-only list of the hidden publication and other rows.
- I ran it twice against a throwaway local copy of `royalway.sql`. Both runs succeeded, and the scratch database was then dropped.
- The `resources.type` enum is unchanged, so no existing data is touched.

**Local database:** `php artisan migrate` ran against the local `royalway` database on 127.0.0.1 only. It also ran three older migrations that were already pending locally (services offer background image, about pages, about strengths image). I added temporary test rows for smoke testing and deleted them afterwards.

## 3. Filament screens
- **Content Management > Page Heroes** (new). Three tabs: News & Insights, Communication Assets and Policies. Each has a heading, intro and image (disk public, folder `page-heroes`, image editor, 4:5 crop).
- **Content Management > Resources** (updated):
  - The type options are News & Insights and Communication Asset.
  - New fields: topic (with suggestions), Lead story, Allow comments, and Related projects (assets only).
  - The file upload accepts pdf, jpg, jpeg, png, webp, gif, doc, docx, xls, xlsx, ppt, pptx, csv, txt, mp4, webm and mp3, up to 51200 KB, and shows the detected file type.
  - The file input appears for Communication Assets, and also for any existing record that already has a file, so no attached file disappears from view.
  - Table: views (sortable), topic, file type badge and a Lead toggle.
- **Content Management > Projects** (updated): new "Communication assets" multi-select.
- **Form Submissions > Article Comments** (new):
  - Defaults to Pending, with a badge showing how many are waiting.
  - Actions: Approve, Spam and Delete, each also available as a bulk action.
- **Dashboard:** new "Article readership" widget showing total views in the last 30 days and the top 5 articles.
- **Settings > Website Settings > News & Insights tab** (new): the two switches below.

## 4. Settings switches

| Key | Default | Effect |
|---|---|---|
| `insights_reactions_enabled` | on (`1`) | Shows the reaction buttons on articles |
| `insights_comments_enabled` | **off** (`0`) | Shows the comment list and form. Each article must also have Allow comments on. |

## 5. Publication and other rows found

The local database is empty, so I listed these from `royalway.sql` (the dump in the project root, dated 6 October 2026). It has no `publication` rows. These are the `other` rows:

| id | title | type |
|---|---|---|
| 3 | Zero Tolerance to Corruption | other |
| 4 | Our Customer Service Pledge | other |
| 5 | Our Commitment To Sustainability. | other |
| 6 | Child Labor-Safeguarding, & Prevention of Sexual Exploitation & Abuse | other |

All four look like copies of policies. They are now hidden from the public site. The last query in the SQL file lists the current live rows, because live may have changed since the dump. Options:
- delete them
- change them to Communication Asset (for example as downloadable policy PDFs)
- leave them hidden

## 6. Hero wording to approve

| Page | Heading | Intro |
|---|---|---|
| News & Insights | Ideas. Perspectives. Insights. | Explore ideas, expert perspectives and industry insights on strategic communications, public relations, marketing, branding and the evolving landscape of business and development across Africa. (from the brief) |
| Communication Assets | Stories you can see, share and use. | Browse the reports, campaign materials, visuals and media we have created with our partners. Preview anything right here, then download what you need. |
| Policies | How we work, openly. | Integrity, care and accountability guide every partnership we build. Here you will find the commitments that shape how we serve our clients, our people and our communities. |

The defaults are created the first time each page loads. They can be edited under Page Heroes.

## 7. Technical limitations and notes
- **Upload limits:** the admin allows 50 MB per file. Livewire's temporary upload rule in `config/livewire.php` is already `max:51200`. Locally PHP has `upload_max_filesize=512M` and `post_max_size=512M`. On the live server, check that both are at least **64M** in cPanel > MultiPHP INI Editor, or uploads over the PHP limit will fail before Laravel sees them. `max_execution_time` should also allow slow uploads.
- **Office previews** rely on Microsoft's online viewer, a third-party service. The file must be at a public URL, so the viewer does not work on localhost or behind a login.
  - The browser cannot detect when the embedded viewer fails, because it is cross-origin. So the note and Download button are always shown for Word, Excel and PowerPoint files.
  - The viewer may also have its own file size limits.
- **Visitor tracking cannot stop a determined person** from reacting again: clearing cookies or switching networks gets around it. The cap of 5 reactions per network per article limits repeats. View counts are approximate in the same way.
- **Comments need moderation.** They stay hidden until approved, and the comments switch is off by default.
- **Privacy:** the privacy policy should mention the following:
  - the `rw_vid` cookie (anonymous reader id for reactions)
  - hashed IP addresses (views, reactions and comments)
  - comment names and email addresses, stored to moderate comments
  - Google reCAPTCHA on the comment form
- **Pre-existing em dash:** the default site title in `partials/seo-meta.blade.php` contains an em dash. It is existing site wording that only shows when the SEO title setting is empty, so I left it alone. I replaced the em dashes in admin helper texts I touched.
- **Smaller decisions:**
  - The lead story is chosen by "Lead story". If several articles are marked, the newest is used.
  - Card thumbnails use empty alt text because the headline link next to them already names the article. Hero images use the heading as alt text.
  - If an old `publication` or `other` row is opened in the admin, the type field is empty until a new type is chosen.

## 8. Files

**New**
- `app/Models/PageHero.php`, `ResourceView.php`, `ResourceReaction.php`, `ResourceComment.php`
- `app/Services/Visitor.php`
- `app/Http/Controllers/ResourceEngagementController.php`
- `app/Mail/ResourceCommentMail.php`
- `app/Filament/Pages/ManagePageHeroes.php`
- `app/Filament/Resources/ResourceCommentResource.php` and `ResourceCommentResource/Pages/ListResourceComments.php`
- `app/Filament/Widgets/ResourceViewsWidget.php`
- `database/migrations/2026_11_10_000001` to `000006`
- `database/live-sql/resources-overhaul.sql`
- `resources/views/assets/index.blade.php`
- `resources/views/partials/page-hero.blade.php`, `asset-card.blade.php`, `asset-preview-modal.blade.php`
- `resources/views/emails/resource-comment.blade.php`
- `resources/views/filament/pages/manage-page-heroes.blade.php`
- `RESOURCES_CHANGES.md`

**Changed**
- `routes/web.php`, `bootstrap/app.php`
- `app/Models/Resource.php`, `Project.php`
- `app/Http/Controllers/ResourceController.php`, `PolicyController.php`, `ProjectController.php`, `SeoController.php`
- `app/Services/SpamGuard.php` (reCAPTCHA action `comment`)
- `app/Filament/Resources/ResourceResource.php`, `ProjectResource.php`
- `app/Filament/Pages/WebsiteSettings.php`, `Dashboard.php`
- `resources/views/layouts/app.blade.php`, `layouts/partials/navbar.blade.php`, `layouts/partials/footer.blade.php`
- `resources/views/partials/seo-meta.blade.php`
- `resources/views/insights/index.blade.php`, `resources/show.blade.php`, `policies/index.blade.php`, `projects/show.blade.php`
- `public/assets/css/style.css` (new block at the end)

**Deleted**
- `resources/views/resources/index.blade.php`

## 9. Live server steps
1. Back up the live database and files.
2. Upload every new and changed file above to the same paths, and delete `resources/views/resources/index.blade.php`.
3. In phpMyAdmin, run `database/live-sql/resources-overhaul.sql`. Note the rows listed at the end.
4. Run `php artisan optimize:clear` (or open `/clear-cache`). This also clears the cached sitemap and settings.
5. Check that `public/storage` links to `storage/app/public`. If it does not, run `php artisan storage:link` (or recreate the symlink in cPanel).
6. Check that PHP `upload_max_filesize` and `post_max_size` are at least 64M.
7. In the admin:
   - review the Page Heroes wording and upload images
   - add topics to articles and pick a Lead story
   - link assets to projects
   - switch on comments under Website Settings > News & Insights when the team is ready to moderate
