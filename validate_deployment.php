<?php

declare(strict_types=1);

/**
 * Quick Deployment Validation
 * Validates all critical deployment parameters
 */

echo "🧪 Export Platform - Quick Deployment Validation\n";
echo "===============================================\n\n";

$errors = [];
$warnings = [];
$passed = [];

// Test 1: PHP Version
$phpVersion = PHP_VERSION;
if (version_compare($phpVersion, '8.3', '>=')) {
    $passed[] = "✅ PHP Version: $phpVersion";
} else {
    $errors[] = "❌ PHP Version: $phpVersion (requires 8.3+)";
}

// Test 2: Required Extensions
$requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'gd', 'zip', 'curl', 'openssl'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        $passed[] = "✅ Extension: $ext";
    } else {
        $errors[] = "❌ Extension: $ext (missing)";
    }
}

// Test 3: Required Files
$requiredFiles = [
    '.htaccess' => 'Web server configuration',
    'index.php' => 'Main entry point',
    'composer.json' => 'Dependencies',
    'app/public_api.php' => 'REST API',
    'public/admin/index.html' => 'Admin panel',
    'public/sse.php' => 'Real-time updates',
    'scripts/migrate_db.php' => 'Database setup'
];

foreach ($requiredFiles as $file => $desc) {
    if (file_exists($file)) {
        $passed[] = "✅ File: $file ($desc)";
    } else {
        $errors[] = "❌ File: $file missing ($desc)";
    }
}

// Test 4: Directory Structure
$requiredDirs = [
    'storage/logs' => 'Log storage',
    'public/uploads' => 'File uploads',
    'app/Core' => 'Core classes'
];

foreach ($requiredDirs as $dir => $desc) {
    if (is_dir($dir)) {
        $passed[] = "✅ Directory: $dir ($desc)";
    } else {
        $warnings[] = "⚠️  Directory: $dir missing ($desc) - will be created";
    }
}

// Test 5: File Permissions
if (file_exists('.env')) {
    $perms = fileperms('.env') & 0777;
    if ($perms === 0600) {
        $passed[] = "✅ .env permissions secure";
    } else {
        $warnings[] = "⚠️  .env permissions: " . sprintf('%o', $perms) . " (recommend 600)";
    }
}

// Test 6: Environment Configuration
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    $requiredVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'APP_SECRET'];
    
    foreach ($requiredVars as $var) {
        if (strpos($envContent, "$var=") !== false) {
            $passed[] = "✅ Environment: $var configured";
        } else {
            $warnings[] = "⚠️  Environment: $var not configured";
        }
    }
} else {
    $warnings[] = "⚠️  .env file missing (copy from .env.example)";
}

// Test 7: Memory and Upload Limits
$memoryLimit = ini_get('memory_limit');
$uploadLimit = ini_get('upload_max_filesize');

$memoryBytes = (int) filter_var($memoryLimit, FILTER_SANITIZE_NUMBER_INT) * (1024 * 1024);
if ($memoryBytes >= 256 * 1024 * 1024) {
    $passed[] = "✅ Memory limit: $memoryLimit";
} else {
    $warnings[] = "⚠️  Memory limit: $memoryLimit (recommend 256M+)";
}

$uploadBytes = (int) filter_var($uploadLimit, FILTER_SANITIZE_NUMBER_INT) * (1024 * 1024);
if ($uploadBytes >= 10 * 1024 * 1024) {
    $passed[] = "✅ Upload limit: $uploadLimit";
} else {
    $warnings[] = "⚠️  Upload limit: $uploadLimit (recommend 10M+)";
}

// Display Results
echo "📋 Validation Results:\n";
echo "=====================\n\n";

if (!empty($passed)) {
    echo "✅ PASSED TESTS:\n";
    foreach ($passed as $test) {
        echo "$test\n";
    }
    echo "\n";
}

if (!empty($warnings)) {
    echo "⚠️  WARNINGS:\n";
    foreach ($warnings as $warning) {
        echo "$warning\n";
    }
    echo "\n";
}

if (!empty($errors)) {
    echo "❌ CRITICAL ERRORS:\n";
    foreach ($errors as $error) {
        echo "$error\n";
    }
    echo "\n";
}

// Summary
$totalTests = count($passed) + count($warnings) + count($errors);
$score = round((count($passed) / max($totalTests, 1)) * 100, 1);

echo "📊 SUMMARY:\n";
echo "===========\n";
echo "✅ Passed: " . count($passed) . "\n";
echo "⚠️  Warnings: " . count($warnings) . "\n";
echo "❌ Errors: " . count($errors) . "\n";
echo "📈 Score: $score%\n\n";

if (empty($errors)) {
    echo "🎉 READY FOR DEPLOYMENT!\n";
    echo "All critical requirements are met. Review warnings for optimization.\n\n";
    
    echo "📋 NEXT STEPS:\n";
    echo "1. Copy .env.example to .env and configure database\n";
    echo "2. Upload files to your web hosting\n";
    echo "3. Run: php scripts/migrate_db.php\n";
    echo "4. Access: https://yourdomain.com/public/admin/\n";
    echo "5. Login: admin / admin123 (change immediately!)\n";
} else {
    echo "❌ NOT READY FOR DEPLOYMENT\n";
    echo "Please fix critical errors before proceeding.\n";
}

echo "\n🔗 For detailed deployment guide, see DEPLOYMENT_GUIDE.md\n";
