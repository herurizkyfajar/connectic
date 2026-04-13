<?php
/**
 * Create Storage Symlink
 * 
 * Script untuk membuat symlink dari public/storage ke storage/app/public
 * Gunakan ini jika php artisan storage:link tidak tersedia di cPanel
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Create Storage Symlink</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .box { 
            background: white; 
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { 
            color: #28a745; 
            padding: 15px; 
            background: #d4edda; 
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin: 10px 0;
        }
        .error { 
            color: #dc3545; 
            padding: 15px; 
            background: #f8d7da; 
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            margin: 10px 0;
        }
        .info { 
            color: #004085; 
            padding: 15px; 
            background: #cce5ff; 
            border: 1px solid #b8daff;
            border-radius: 5px;
            margin: 10px 0;
        }
        .warning { 
            color: #856404; 
            padding: 15px; 
            background: #fff3cd; 
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            margin: 10px 0;
        }
        h1 { color: #333; border-bottom: 3px solid #667eea; padding-bottom: 10px; }
        code { 
            background: #f4f4f4; 
            padding: 2px 8px; 
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .step { 
            margin: 20px 0; 
            padding-left: 20px;
            border-left: 3px solid #667eea;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class='box'>
        <h1>🔗 Create Storage Symlink</h1>";

$basePath = __DIR__;
$target = $basePath . '/storage/app/public';
$link = $basePath . '/public/storage';

echo "<div class='info'>";
echo "<strong>📁 Paths:</strong><br>";
echo "Target: <code>{$target}</code><br>";
echo "Link: <code>{$link}</code>";
echo "</div>";

// Step 1: Check if target exists
echo "<div class='step'>";
echo "<h3>Step 1: Check Target Directory</h3>";
if (!file_exists($target)) {
    echo "<div class='error'>❌ Target directory does not exist: {$target}</div>";
    echo "<div class='info'>Creating target directory...</div>";
    
    if (mkdir($target, 0755, true)) {
        echo "<div class='success'>✅ Target directory created successfully!</div>";
    } else {
        echo "<div class='error'>❌ Failed to create target directory. Check permissions.</div>";
        exit;
    }
} else {
    echo "<div class='success'>✅ Target directory exists</div>";
}
echo "</div>";

// Step 2: Check if link already exists
echo "<div class='step'>";
echo "<h3>Step 2: Check Existing Link</h3>";
if (file_exists($link)) {
    if (is_link($link)) {
        $currentTarget = readlink($link);
        echo "<div class='warning'>⚠️ Symlink already exists<br>";
        echo "Current target: <code>{$currentTarget}</code></div>";
        
        if ($currentTarget === $target) {
            echo "<div class='success'>✅ Symlink is correct, no action needed!</div>";
            echo "</div></div></body></html>";
            exit;
        } else {
            echo "<div class='info'>Removing old symlink...</div>";
            if (unlink($link)) {
                echo "<div class='success'>✅ Old symlink removed</div>";
            } else {
                echo "<div class='error'>❌ Failed to remove old symlink</div>";
                echo "</div></div></body></html>";
                exit;
            }
        }
    } else {
        echo "<div class='warning'>⚠️ 'public/storage' exists but is not a symlink (it's a directory)</div>";
        echo "<div class='info'>This needs to be removed to create the symlink</div>";
        echo "<div class='error'>❌ Please manually delete the 'public/storage' directory first</div>";
        echo "<div class='info'><strong>Manual Steps:</strong><br>";
        echo "1. Go to cPanel File Manager<br>";
        echo "2. Navigate to: <code>public/storage</code><br>";
        echo "3. Delete the directory<br>";
        echo "4. Run this script again</div>";
        echo "</div></div></body></html>";
        exit;
    }
} else {
    echo "<div class='success'>✅ No existing link found, ready to create</div>";
}
echo "</div>";

// Step 3: Create symlink
echo "<div class='step'>";
echo "<h3>Step 3: Create Symlink</h3>";
if (function_exists('symlink')) {
    if (@symlink($target, $link)) {
        echo "<div class='success'>";
        echo "✅ <strong>SUCCESS!</strong> Symlink created successfully!<br><br>";
        echo "Now you can access storage files via:<br>";
        echo "<code>asset('storage/folder/file.jpg')</code>";
        echo "</div>";
        
        // Verify
        if (is_link($link)) {
            $verifyTarget = readlink($link);
            echo "<div class='success'>";
            echo "✅ Verification successful<br>";
            echo "Link: <code>{$link}</code><br>";
            echo "Points to: <code>{$verifyTarget}</code>";
            echo "</div>";
        }
    } else {
        echo "<div class='error'>";
        echo "❌ Failed to create symlink<br>";
        echo "This usually means:<br>";
        echo "1. Insufficient permissions<br>";
        echo "2. Symlink function is disabled by hosting<br>";
        echo "3. open_basedir restriction";
        echo "</div>";
        
        echo "<div class='warning'>";
        echo "<strong>⚠️ Alternative Solution:</strong><br>";
        echo "Since symlink doesn't work on this server, the application has been updated to work WITHOUT symlink.<br><br>";
        echo "<strong>Your photos will still work!</strong> They will be served via a fallback route instead.";
        echo "</div>";
        
        echo "<div class='info'>";
        echo "<strong>What to do:</strong><br>";
        echo "1. Nothing! The app is already configured to work without symlink<br>";
        echo "2. Just make sure <code>storage/app/public/anggotas/</code> has permission 755<br>";
        echo "3. Test upload and it should work";
        echo "</div>";
    }
} else {
    echo "<div class='error'>❌ symlink() function is disabled on this server</div>";
    
    echo "<div class='warning'>";
    echo "<strong>⚠️ Don't worry!</strong> The application has been updated to work WITHOUT symlink.<br><br>";
    echo "Photos will be served directly via route: <code>/anggota/foto/{id}</code>";
    echo "</div>";
    
    echo "<div class='info'>";
    echo "<strong>No action needed:</strong><br>";
    echo "✅ Upload will work without symlink<br>";
    echo "✅ Photos will be displayed correctly<br>";
    echo "✅ Everything is configured automatically";
    echo "</div>";
}
echo "</div>";

// Step 4: Security reminder
echo "<div class='step'>";
echo "<h3>Step 4: Security</h3>";
echo "<div class='warning'>";
echo "🔐 <strong>IMPORTANT:</strong> Delete this file after use!<br>";
echo "<code>rm create_symlink.php</code><br>";
echo "Or delete via cPanel File Manager";
echo "</div>";
echo "</div>";

// Next steps
echo "<div class='step'>";
echo "<h3>✅ Next Steps</h3>";
echo "<div class='info'>";
echo "1. <strong>Test upload:</strong> Login as anggota and try to upload a photo<br>";
echo "2. <strong>Verify storage:</strong> Check if file appears in <code>storage/app/public/anggotas/</code><br>";
echo "3. <strong>Check display:</strong> Photo should appear in profile page<br>";
echo "4. <strong>Delete this script:</strong> Remove create_symlink.php from server";
echo "</div>";
echo "</div>";

echo "</div>"; // Close box
echo "</body></html>";

