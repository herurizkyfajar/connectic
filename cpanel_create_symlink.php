<?php
/**
 * Create Storage Symlink for cPanel
 * 
 * ⚠️ IMPORTANT INSTRUCTIONS:
 * 
 * 1. Upload this file to: /home/username/public_html/
 * 2. Edit the paths below according to your cPanel username
 * 3. Access via browser: https://yourdomain.com/cpanel_create_symlink.php
 * 4. DELETE this file after successful symlink creation!
 * 
 * Usage:
 * - Replace 'username' with your actual cPanel username
 * - Make sure the Laravel folder name is correct (default: laravel)
 */

// ============================================
// 🔧 CONFIGURATION - EDIT THIS!
// ============================================
$cpanelUsername = 'username';  // ⚠️ CHANGE THIS to your cPanel username!
$laravelFolderName = 'laravel'; // Laravel folder name (default: laravel)

// ============================================
// Paths (will be auto-generated)
// ============================================
$target = "/home/{$cpanelUsername}/{$laravelFolderName}/storage/app/public";
$link = "/home/{$cpanelUsername}/public_html/storage";

echo "<html>";
echo "<head><title>Storage Symlink Creator</title>";
echo "<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
.success { color: green; background: #d4edda; padding: 15px; border-radius: 5px; border: 1px solid #c3e6cb; }
.error { color: red; background: #f8d7da; padding: 15px; border-radius: 5px; border: 1px solid #f5c6cb; }
.info { color: #004085; background: #cce5ff; padding: 15px; border-radius: 5px; border: 1px solid #b8daff; margin-bottom: 20px; }
.warning { color: #856404; background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffeeba; margin-top: 20px; }
h1 { color: #333; }
code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; }
</style></head>";
echo "<body>";

echo "<h1>🔗 Laravel Storage Symlink Creator</h1>";

echo "<div class='info'>";
echo "<h3>📋 Configuration:</h3>";
echo "<strong>Target (Laravel Storage):</strong><br>";
echo "<code>$target</code><br><br>";
echo "<strong>Link (Public Storage):</strong><br>";
echo "<code>$link</code>";
echo "</div>";

// Check if target exists
if (!is_dir($target)) {
    echo "<div class='error'>";
    echo "<h3>❌ Error: Target directory not found!</h3>";
    echo "<p>The Laravel storage directory doesn't exist at:<br><code>$target</code></p>";
    echo "<h4>Possible Solutions:</h4>";
    echo "<ol>";
    echo "<li>Check if your cPanel username is correct: <code>$cpanelUsername</code></li>";
    echo "<li>Check if Laravel folder name is correct: <code>$laravelFolderName</code></li>";
    echo "<li>Make sure you've uploaded the Laravel files to the server</li>";
    echo "<li>Edit this file and update the configuration at the top</li>";
    echo "</ol>";
    echo "</div>";
    echo "</body></html>";
    exit;
}

// Remove existing symlink/folder if exists
if (file_exists($link)) {
    echo "<div class='info'>";
    echo "ℹ️ Existing storage link/folder found. Removing...<br>";
    
    if (is_link($link)) {
        unlink($link);
        echo "✅ Old symlink removed successfully.<br>";
    } elseif (is_dir($link)) {
        rmdir($link);
        echo "✅ Old directory removed successfully.<br>";
    } else {
        unlink($link);
        echo "✅ Old file removed successfully.<br>";
    }
    echo "</div>";
}

// Create symlink
echo "<h3>🔄 Creating symlink...</h3>";

if (symlink($target, $link)) {
    echo "<div class='success'>";
    echo "<h3>✅ Symlink Created Successfully!</h3>";
    echo "<p>Storage symlink has been created successfully.</p>";
    echo "<p><strong>From:</strong> <code>$target</code></p>";
    echo "<p><strong>To:</strong> <code>$link</code></p>";
    echo "</div>";
    
    // Verify
    if (is_link($link)) {
        echo "<div class='success'>";
        echo "✅ Verification: Symlink is working correctly!";
        echo "</div>";
    }
} else {
    echo "<div class='error'>";
    echo "<h3>❌ Failed to Create Symlink!</h3>";
    echo "<p>Possible reasons:</p>";
    echo "<ul>";
    echo "<li>Insufficient permissions</li>";
    echo "<li>Symlinks might be disabled by your hosting</li>";
    echo "<li>Target path doesn't exist</li>";
    echo "</ul>";
    echo "<h4>Alternative Solution:</h4>";
    echo "<p>If your hosting doesn't support symlinks, you can manually copy files:</p>";
    echo "<ol>";
    echo "<li>Create folder: <code>/home/{$cpanelUsername}/public_html/storage</code></li>";
    echo "<li>Copy all files from <code>$target</code> to <code>$link</code></li>";
    echo "<li>Remember to re-copy whenever you upload new files</li>";
    echo "</ol>";
    echo "</div>";
}

echo "<div class='warning'>";
echo "<h3>⚠️ IMPORTANT: Security Notice</h3>";
echo "<p><strong>DELETE THIS FILE IMMEDIATELY!</strong></p>";
echo "<p>This file exposes your server paths. After the symlink is created successfully, delete this file:</p>";
echo "<code>rm /home/{$cpanelUsername}/public_html/cpanel_create_symlink.php</code>";
echo "<p>Or delete it via cPanel File Manager.</p>";
echo "</div>";

echo "</body></html>";

