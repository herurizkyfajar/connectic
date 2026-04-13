<?php
/**
 * Interactive Setup for Online Database
 * This script will help you configure online database access
 */

echo "\n";
echo "╔════════════════════════════════════════════════════╗\n";
echo "║   Online Database Setup - Interactive Tool        ║\n";
echo "╚════════════════════════════════════════════════════╝\n";
echo "\n";

// Current configuration
echo "📋 Current Database Configuration:\n";
echo "─────────────────────────────────────────────────────\n";
echo "Database: wmsb4692_simrtik\n";
echo "Username: wmsb4692_simrtik\n";
echo "Password: 224589herU!\n";
echo "Host:     localhost (❌ THIS WON'T WORK FOR ONLINE DB!)\n";
echo "\n";

echo "⚠️  IMPORTANT:\n";
echo "To access online database from your local computer, you need:\n";
echo "1. Correct DB_HOST (server address)\n";
echo "2. Remote MySQL enabled in cPanel\n";
echo "3. Your IP whitelisted\n";
echo "\n";

echo "─────────────────────────────────────────────────────\n";
echo "Choose an option:\n";
echo "─────────────────────────────────────────────────────\n";
echo "[1] I know my DB_HOST - Let me enter it\n";
echo "[2] Test multiple common hosts automatically\n";
echo "[3] Show me how to find DB_HOST in cPanel\n";
echo "[4] Download database to use locally (recommended)\n";
echo "[0] Exit\n";
echo "\n";
echo "Enter your choice (0-4): ";

$choice = trim(fgets(STDIN));

switch ($choice) {
    case '1':
        echo "\n🔧 Enter Database Configuration:\n";
        echo "─────────────────────────────────────────────────────\n";
        
        echo "DB_HOST (e.g., mysql.yourdomain.com): ";
        $host = trim(fgets(STDIN));
        
        echo "DB_PORT [3306]: ";
        $port = trim(fgets(STDIN));
        $port = empty($port) ? '3306' : $port;
        
        echo "\nTesting connection...\n";
        
        try {
            $dsn = "mysql:host=$host;port=$port;dbname=wmsb4692_simrtik;charset=utf8mb4";
            $pdo = new PDO($dsn, 'wmsb4692_simrtik', '224589herU!', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);
            
            echo "✅ Connection successful!\n\n";
            
            // Get info
            $version = $pdo->query('SELECT VERSION()')->fetchColumn();
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            
            echo "MySQL Version: $version\n";
            echo "Tables found: " . count($tables) . "\n\n";
            
            echo "💾 Update .env file with this configuration:\n";
            echo "─────────────────────────────────────────────────────\n";
            echo "DB_HOST=$host\n";
            echo "DB_PORT=$port\n";
            echo "─────────────────────────────────────────────────────\n\n";
            
            echo "Update .env now? (y/n): ";
            $update = trim(fgets(STDIN));
            
            if (strtolower($update) === 'y') {
                $envPath = __DIR__ . '/.env';
                $envContent = file_get_contents($envPath);
                $envContent = preg_replace('/DB_HOST=.+/', "DB_HOST=$host", $envContent);
                $envContent = preg_replace('/DB_PORT=.+/', "DB_PORT=$port", $envContent);
                file_put_contents($envPath, $envContent);
                
                echo "✅ .env updated successfully!\n";
                echo "\nRun these commands:\n";
                echo "  php artisan config:clear\n";
                echo "  php artisan serve\n";
            }
            
        } catch (PDOException $e) {
            echo "❌ Connection failed!\n";
            echo "Error: " . $e->getMessage() . "\n\n";
            
            echo "Common solutions:\n";
            echo "1. Enable Remote MySQL in cPanel\n";
            echo "2. Whitelist your IP in cPanel\n";
            echo "3. Check if host address is correct\n";
        }
        break;
        
    case '2':
        echo "\n🔍 Running automatic host detection...\n";
        echo "This may take a few minutes.\n\n";
        include 'test_multiple_hosts.php';
        break;
        
    case '3':
        echo "\n📖 How to Find DB_HOST in cPanel:\n";
        echo "─────────────────────────────────────────────────────\n";
        echo "1. Login to your cPanel account\n";
        echo "2. Search for 'Remote MySQL' or 'MySQL Databases'\n";
        echo "3. Look for 'Access Host' or connection information\n";
        echo "4. Common formats:\n";
        echo "   • localhost (if same server)\n";
        echo "   • mysql.yourdomain.com\n";
        echo "   • 123.456.789.10 (IP address)\n";
        echo "   • server1.yourhosting.com\n\n";
        
        echo "📞 Or contact your hosting support:\n";
        echo "Ask: 'What is the hostname for remote MySQL access?'\n\n";
        
        echo "Read full guide: find_db_host.md\n";
        break;
        
    case '4':
        echo "\n💡 Recommended: Use Local Database\n";
        echo "─────────────────────────────────────────────────────\n";
        echo "For development, it's better to work with local database:\n\n";
        
        echo "STEP 1: Export database from cPanel\n";
        echo "  1. Login to cPanel → phpMyAdmin\n";
        echo "  2. Select database: wmsb4692_simrtik\n";
        echo "  3. Click 'Export' tab\n";
        echo "  4. Click 'Go' to download SQL file\n\n";
        
        echo "STEP 2: Import to local database\n";
        echo "  1. Open http://localhost/phpmyadmin\n";
        echo "  2. Create new database: simrtik\n";
        echo "  3. Click 'Import' tab\n";
        echo "  4. Choose downloaded SQL file\n";
        echo "  5. Click 'Go'\n\n";
        
        echo "STEP 3: Update .env for local\n";
        echo "  DB_HOST=127.0.0.1\n";
        echo "  DB_DATABASE=simrtik\n";
        echo "  DB_USERNAME=root\n";
        echo "  DB_PASSWORD=\n\n";
        
        echo "STEP 4: Clear cache and test\n";
        echo "  php artisan config:clear\n";
        echo "  php artisan serve\n\n";
        
        echo "Read full guide: DATABASE_ONLINE_SETUP.md\n";
        break;
        
    case '0':
        echo "👋 Goodbye!\n";
        break;
        
    default:
        echo "❌ Invalid choice!\n";
}

echo "\n";
?>

