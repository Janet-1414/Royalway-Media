<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ── Auth ─────────────────────────────────────────────────────────────────────
define('SECRET', 'ivanos_storage_2026');

if (($_GET['key'] ?? '') !== SECRET) {
    http_response_code(403);
    die('403 Forbidden. Add ?key=ivanos_storage_2026 to the URL.');
}

// ── Path Detection ────────────────────────────────────────────────────────────
$publicDir = __DIR__;
$action    = $_GET['action'] ?? '';

$candidates = [
    dirname($publicDir),
    dirname(dirname($publicDir)),
];

$root = null;
foreach ($candidates as $c) {
    if (file_exists($c . '/artisan')) {
        $root = $c;
        break;
    }
}

$storagePub  = $root ? $root . '/storage/app/public' : null;
$symlinkPath = $publicDir . '/storage';
$base        = '?key=' . SECRET;

// ── Actions ───────────────────────────────────────────────────────────────────
$log = [];

function logOk($msg)  { global $log; $log[] = ['ok',   $msg]; }
function logErr($msg) { global $log; $log[] = ['err',  $msg]; }
function logWarn($msg){ global $log; $log[] = ['warn', $msg]; }

if ($root && $action === 'symlink') {
    if (!is_dir($storagePub)) {
        mkdir($storagePub, 0775, true);
        logOk("Created directory: $storagePub");
    }
    if (is_link($symlinkPath) && !is_dir($symlinkPath)) {
        unlink($symlinkPath);
        logWarn("Removed broken symlink.");
    }
    if (is_link($symlinkPath) && is_dir($symlinkPath)) {
        logOk("Symlink already exists and works.");
    } elseif (is_dir($symlinkPath) && !is_link($symlinkPath)) {
        rename($symlinkPath, $publicDir . '/storage_backup_' . time());
        symlink($storagePub, $symlinkPath)
            ? logOk("Symlink created (moved old directory to backup).")
            : logErr("symlink() failed after backup.");
    } elseif (!file_exists($symlinkPath)) {
        symlink($storagePub, $symlinkPath)
            ? logOk("Symlink created: $symlinkPath → $storagePub")
            : logErr("symlink() failed. Host may not support it. Try the .htaccess fix.");
    }
}

if ($root && $action === 'permissions') {
    $dirs = [
        $root . '/storage',
        $root . '/storage/app',
        $root . '/storage/app/public',
        $root . '/storage/app/public/hero',
        $root . '/storage/app/public/services',
        $root . '/storage/app/public/blog',
        $root . '/storage/app/public/partners',
        $root . '/storage/logs',
        $root . '/storage/framework',
        $root . '/storage/framework/cache',
        $root . '/storage/framework/sessions',
        $root . '/storage/framework/views',
        $root . '/bootstrap/cache',
    ];
    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
            logOk("Created: $dir");
        }
        @chmod($dir, 0775);
        logOk("775 ✓ $dir");
    }
    if (is_dir($storagePub)) {
        $count = 0;
        try {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($storagePub, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($it as $f) {
                if ($f->isFile()) { @chmod($f->getPathname(), 0644); $count++; }
                if ($f->isDir())  { @chmod($f->getPathname(), 0775); }
            }
            logOk("Fixed $count files in storage/app/public");
        } catch (Throwable $e) {
            logErr("Permission scan error: " . $e->getMessage());
        }
    }
}

if ($root && $action === 'htaccess') {
    if (!is_dir($storagePub)) mkdir($storagePub, 0775, true);

    $htaccess = 'Options -Indexes
<IfModule mod_headers.c>
    Header set Access-Control-Allow-Origin "*"
    Header set Cache-Control "public, max-age=2592000"
</IfModule>
<FilesMatch "\.(jpg|jpeg|png|gif|webp|svg|ico|pdf|mp4|zip|csv)$">
    Order allow,deny
    Allow from all
    Require all granted
</FilesMatch>';

    file_put_contents($storagePub . '/.htaccess', $htaccess)
        ? logOk("Wrote .htaccess to storage/app/public")
        : logErr("Failed to write .htaccess to storage/app/public");

    if (is_dir($symlinkPath) && !is_link($symlinkPath)) {
        file_put_contents($symlinkPath . '/.htaccess', $htaccess)
            ? logOk("Also wrote .htaccess to public/storage")
            : logErr("Failed to write .htaccess to public/storage");
    }
}

if ($root && $action === 'cache') {
    $viewCache = $root . '/storage/framework/views';
    $count = 0;
    if (is_dir($viewCache)) {
        foreach (glob($viewCache . '/*.php') as $file) {
            unlink($file);
            $count++;
        }
    }
    logOk("Cleared $count compiled views.");

    $configCache = $root . '/bootstrap/cache/config.php';
    if (file_exists($configCache)) {
        unlink($configCache);
        logOk("Cleared config cache.");
    }

    $routeCache = $root . '/bootstrap/cache/routes-v7.php';
    if (file_exists($routeCache)) {
        unlink($routeCache);
        logOk("Cleared route cache.");
    }

    logOk("Cache cleared. Run php artisan optimize after if you have SSH access.");
}

if ($root && $action === 'test') {
    $found = null;
    if (is_dir($storagePub)) {
        try {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($storagePub, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($it as $f) {
                if ($f->isFile() && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $f->getFilename())) {
                    $found = $f->getPathname();
                    break;
                }
            }
        } catch (Throwable $e) {
            logErr("Scan error: " . $e->getMessage());
        }
    }
    if ($found) {
        $rel = str_replace('\\', '/', str_replace($storagePub, '', $found));
        logOk("Found test image: /storage$rel");
    } else {
        logWarn("No images found in storage/app/public yet. Upload a hero image first.");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ivanos — Storage Fix</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#071540;color:#e2e8f0;min-height:100vh;padding:32px 16px}
        .wrap{max-width:760px;margin:0 auto}
        .brand{font-size:22px;font-weight:700;color:white;letter-spacing:0.06em;margin-bottom:4px}
        .brand-sub{font-size:10px;color:rgba(255,255,255,0.4);letter-spacing:0.18em;text-transform:uppercase;margin-bottom:40px}
        .card{background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:24px;margin-bottom:20px}
        .card h2{font-size:13px;font-weight:600;color:#00c2e0;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:16px}
        .grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .btn{display:block;padding:12px 16px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600;text-align:center;transition:opacity 0.2s;border:1px solid transparent}
        .btn:hover{opacity:0.85}
        .btn-green{background:#059669;color:white}
        .btn-blue{background:#0369a1;color:white}
        .btn-amber{background:#b45309;color:white}
        .btn-purple{background:#6d28d9;color:white}
        .btn-red{background:#dc2626;color:white}
        .btn-gray{background:rgba(255,255,255,0.08);color:rgba(255,255,255,0.7);border-color:rgba(255,255,255,0.1)}
        .log{margin-top:20px}
        .log-item{display:flex;align-items:flex-start;gap:10px;padding:8px 12px;border-radius:6px;margin-bottom:6px;font-size:13px;font-family:monospace}
        .log-item.ok{background:rgba(5,150,105,0.15);color:#6ee7b7}
        .log-item.err{background:rgba(220,38,38,0.15);color:#fca5a5}
        .log-item.warn{background:rgba(180,83,9,0.15);color:#fcd34d}
        .status-grid{display:grid;grid-template-columns:1fr 1fr;gap:8px}
        .status-item{display:flex;align-items:center;gap:8px;font-size:13px;padding:10px 12px;background:rgba(255,255,255,0.04);border-radius:8px;border:1px solid rgba(255,255,255,0.07)}
        .dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
        .dot-ok{background:#10b981}
        .dot-err{background:#ef4444}
        .dot-warn{background:#f59e0b}
        .info-row{display:flex;justify-content:space-between;font-size:12px;padding:5px 0;border-bottom:1px solid rgba(255,255,255,0.05);color:rgba(255,255,255,0.5)}
        .info-row:last-child{border:0}
        .info-val{color:rgba(255,255,255,0.85);font-family:monospace;font-size:11px;max-width:380px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
        .warning-box{background:rgba(220,38,38,0.1);border:1px solid rgba(220,38,38,0.3);border-radius:8px;padding:12px 16px;font-size:12px;color:#fca5a5;margin-top:20px}
        .step-badge{background:rgba(0,194,224,0.15);color:#00c2e0;font-size:11px;font-weight:600;padding:2px 8px;border-radius:4px;margin-right:6px}
    </style>
</head>
<body>
<div class="wrap">

    <div class="brand">IVANOS</div>
    <div class="brand-sub">Logistics &amp; Company Limited — Storage Fix Utility</div>

    <?php if (!$root): ?>
        <div class="card">
            <h2>⚠ Laravel Root Not Found</h2>
            <p style="font-size:13px;color:rgba(255,255,255,0.6);margin-bottom:12px">Could not locate <code>artisan</code>. Checked:</p>
            <?php foreach ($candidates as $c): ?>
                <div class="info-row"><span><?= htmlspecialchars($c) ?></span><span class="info-val"><?= file_exists($c.'/artisan') ? '✓ artisan found' : '✗ not found' ?></span></div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>

        {{-- Status Card --}}
        <div class="card">
            <h2>Current Status</h2>
            <div class="status-grid">
                <?php
                $symlinkOk    = is_link($symlinkPath) && is_dir($symlinkPath);
                $symlinkBroken= is_link($symlinkPath) && !is_dir($symlinkPath);
                $symlinkReal  = is_dir($symlinkPath) && !is_link($symlinkPath);
                $storageExists= is_dir($storagePub);
                $writable     = is_writable($storagePub ?: $root.'/storage');
                $htaccessOk   = file_exists($storagePub.'/.htaccess');
                $symlinkFn    = function_exists('symlink');

                $fc = 0;
                if ($storageExists) {
                    try {
                        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePub, RecursiveDirectoryIterator::SKIP_DOTS));
                        foreach ($it as $f) { if ($f->isFile() && !str_contains($f->getFilename(), '.htaccess')) $fc++; }
                    } catch (Throwable $e) {}
                }

                $items = [
                    [$symlinkOk ? 'ok' : ($symlinkBroken ? 'err' : ($symlinkReal ? 'warn' : 'err')),
                        'Symlink',
                        $symlinkOk ? 'Working' : ($symlinkBroken ? 'Broken' : ($symlinkReal ? 'Real folder (no symlink)' : 'Missing'))],
                    [$storageExists ? 'ok' : 'err', 'storage/app/public', $storageExists ? 'Exists' : 'Missing'],
                    [$writable ? 'ok' : 'err', 'Storage writable', $writable ? 'Yes' : 'No'],
                    [$htaccessOk ? 'ok' : 'warn', '.htaccess', $htaccessOk ? 'Present' : 'Missing'],
                    [$fc > 0 ? 'ok' : 'warn', 'Uploaded files', "$fc files"],
                    [$symlinkFn ? 'ok' : 'warn', 'symlink() available', $symlinkFn ? 'Yes' : 'No'],
                ];
                foreach ($items as [$status, $label, $value]):
                    ?>
                    <div class="status-item">
                        <span class="dot dot-<?= $status ?>"></span>
                        <span style="flex:1;color:rgba(255,255,255,0.6)"><?= $label ?></span>
                        <span style="font-size:12px;color:<?= $status==='ok'?'#10b981':($status==='err'?'#ef4444':'#f59e0b') ?>"><?= $value ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        {{-- Actions --}}
        <div class="card">
            <h2>Actions</h2>
            <p style="font-size:12px;color:rgba(255,255,255,0.4);margin-bottom:16px">Run these in order when deploying to cPanel for the first time.</p>
            <div class="grid">
                <a class="btn btn-green" href="<?= $base ?>&action=symlink">
                    <span class="step-badge">1</span>Create Storage Symlink
                </a>
                <a class="btn btn-blue" href="<?= $base ?>&action=permissions">
                    <span class="step-badge">2</span>Fix Permissions (775/644)
                </a>
                <a class="btn btn-amber" href="<?= $base ?>&action=htaccess">
                    <span class="step-badge">3</span>Write .htaccess to Storage
                </a>
                <a class="btn btn-purple" href="<?= $base ?>&action=cache">
                    <span class="step-badge">4</span>Clear View &amp; Config Cache
                </a>
                <a class="btn btn-gray" href="<?= $base ?>&action=test">
                    <span class="step-badge">5</span>Test Image Accessibility
                </a>
                <a class="btn btn-gray" href="<?= $base ?>">
                    ↻ Refresh Status
                </a>
            </div>
        </div>

        {{-- Log Output --}}
        <?php if (!empty($log)): ?>
            <div class="card">
                <h2>Action Output</h2>
                <div class="log">
                    <?php foreach ($log as [$type, $msg]): ?>
                        <div class="log-item <?= $type ?>">
                            <?= $type === 'ok' ? '✓' : ($type === 'err' ? '✗' : '⚠') ?>
                            <?= htmlspecialchars($msg) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        {{-- Test image result --}}
        <?php
        $testFound = null;
        if ($action === 'test' && $storageExists) {
            try {
                $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($storagePub, RecursiveDirectoryIterator::SKIP_DOTS));
                foreach ($it as $f) {
                    if ($f->isFile() && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $f->getFilename())) {
                        $testFound = $f->getPathname();
                        break;
                    }
                }
            } catch (Throwable $e) {}
        }
        if ($testFound):
            $rel    = str_replace('\\', '/', str_replace($storagePub, '', $testFound));
            $imgUrl = '/storage' . $rel;
            ?>
            <div class="card">
                <h2>Image Test</h2>
                <div class="info-row"><span>File path</span><span class="info-val"><?= htmlspecialchars($testFound) ?></span></div>
                <div class="info-row"><span>Public URL</span><span class="info-val"><a href="<?= $imgUrl ?>" target="_blank" style="color:#00c2e0"><?= $imgUrl ?></a></span></div>
                <img src="<?= htmlspecialchars($imgUrl) ?>"
                     style="max-width:260px;margin-top:16px;border-radius:8px;border:2px solid #10b981"
                     onerror="this.style.borderColor='#ef4444';this.title='FAILED — image not accessible'"
                     alt="Storage test image">
            </div>
        <?php endif; ?>

        {{-- Environment Info --}}
        <div class="card">
            <h2>Environment Info</h2>
            <?php
            $info = [
                'Script location'   => $publicDir,
                'Project root'      => $root,
                'Storage public'    => $storagePub,
                'Symlink path'      => $symlinkPath,
                'PHP version'       => PHP_VERSION,
                'Server software'   => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
                'Current user'      => function_exists('get_current_user') ? get_current_user() : 'unknown',
                'Document root'     => $_SERVER['DOCUMENT_ROOT'] ?? 'unknown',
            ];
            foreach ($info as $k => $v):
                ?>
                <div class="info-row">
                    <span><?= $k ?></span>
                    <span class="info-val"><?= htmlspecialchars($v) ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

    <div class="warning-box">
        ⚠ <strong>Security notice:</strong> Delete this file immediately after use. URL: <code><?= htmlspecialchars(__FILE__) ?></code>
    </div>

</div>
</body>
</html>
