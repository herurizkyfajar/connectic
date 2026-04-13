<?php
/**
 * Create Storage Symlink for app.rtikcmh.com
 * 
 * INSTRUCTIONS:
 * 1. Upload file ini ke: /home/wmsb4692/public_html/app.rtikcmh.com/
 * 2. Akses via browser: https://app.rtikcmh.com/create_symlink_for_app_rtikcmh_com.php
 * 3. DELETE file ini setelah berhasil!
 */

$target = '/home/wmsb4692/simrtik/storage/app/public';
$link = '/home/wmsb4692/public_html/app.rtikcmh.com/storage';

echo "<html><head><title>Create Storage Symlink</title>";
echo "<style>
body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
.success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; }
.error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; }
.info { background: #cce5ff; padding: 15px; border-radius: 5px; margin: 15px 0; }
.warning { background: #fff3cd; padding: 15px; border-radius: 5px; margin: 15px 0; color: #856404; }
</style></head><body>";

echo "<h1>🔗 Storage Symlink Creator</h1>";

echo "<div class='info'>";
echo "<strong>Target:</strong> $target<br>";
echo "<strong>Link:</strong> $link";
echo "</div>";

// Check if target exists
if (!is_dir($target)) {
    echo "<div class='error'>";
    echo "<h3>❌ Error: Target directory not found!</h3>";
    echo "<p>Laravel storage folder tidak ditemukan di:<br><code>$target</code></p>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ol>";
    echo "<li>Pastikan folder 'simrtik' sudah diupload ke <code>/home/wmsb4692/simrtik/</code></li>";
    echo "<li>Pastikan struktur folder benar</li>";
    echo "</ol>";
    echo "</div>";
    echo "</body></html>";
    exit;
}

// Remove existing symlink/folder
if (file_exists($link)) {
    echo "<p>ℹ️ Removing existing storage link...</p>";
    if (is_link($link)) {
        unlink($link);
        echo "<p>✅ Old symlink removed</p>";
    } elseif (is_dir($link)) {
        rmdir($link);
        echo "<p>✅ Old directory removed</p>";
    }
}

// Create symlink
if (symlink($target, $link)) {
    echo "<div class='success'>";
    echo "<h3>✅ Symlink Created Successfully!</h3>";
    echo "<p>Storage symlink has been created.</p>";
    echo "<p><strong>From:</strong> $target</p>";
    echo "<p><strong>To:</strong> $link</p>";
    echo "</div>";
    
    // Verify
    if (is_link($link)) {
        echo "<div class='success'>";
        echo "<p>✅ Verification: Symlink is working!</p>";
        echo "</div>";
    }
} else {
    echo "<div class='error'>";
    echo "<h3>❌ Failed to Create Symlink!</h3>";
    echo "<p>Symlink creation failed. Possible reasons:</p>";
    echo "<ul>";
    echo "<li>Insufficient permissions</li>";
    echo "<li>Symlinks disabled by hosting</li>";
    echo "</ul>";
    echo "<p><strong>Alternative:</strong> Manually copy files from storage to public</p>";
    echo "</div>";
}

echo "<div class='warning'>";
echo "<h3>⚠️ SECURITY NOTICE</h3>";
echo "<p><strong>DELETE THIS FILE NOW!</strong></p>";
echo "<p>File location: <code>$link</code></p>";
echo "</div>";

echo "</body></html>";


