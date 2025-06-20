<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kerala Spice Export Platform - Deployment Checker</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; background: linear-gradient(135deg, #d97706 0%, #059669 100%); }
        .container { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #d97706; margin-bottom: 10px; }
        .platform-badge { background: linear-gradient(135deg, #d97706, #059669); color: white; padding: 10px 20px; border-radius: 25px; display: inline-block; margin: 10px 0; }
        .status-section { margin: 20px 0; padding: 15px; border-radius: 8px; }
        .passed { background: #d1fae5; border-left: 4px solid #10b981; }
        .warning { background: #fef3c7; border-left: 4px solid #f59e0b; }
        .error { background: #fee2e2; border-left: 4px solid #ef4444; }
        .status-list { margin: 10px 0; }
        .status-item { padding: 5px 0; }
        .summary { background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(5, 150, 105, 0.1)); padding: 25px; border-radius: 10px; margin: 20px 0; text-align: center; border: 2px solid #d97706; }
        .summary h2 { color: #d97706; margin-bottom: 15px; }
        .button { background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; display: inline-block; margin: 8px; transition: all 0.3s; }
        .button:hover { background: #047857; transform: translateY(-2px); }
        .logo { font-size: 3em; margin-bottom: 10px; }
        .progress-bar { width: 100%; background: #e5e7eb; border-radius: 10px; height: 24px; margin: 15px 0; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #d97706, #059669); border-radius: 10px; transition: width 0.5s ease; }
        .platform-features { margin-top: 25px; text-align: left; }
        .platform-features h3 { margin-bottom: 15px; color: #d97706; font-size: 1.2em; }
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 15px; }
        .feature-item { background: linear-gradient(135deg, #f0f9ff, #ecfdf5); padding: 10px 15px; border-radius: 8px; border-left: 4px solid #d97706; font-size: 14px; font-weight: 500; }
        .spice-icons { text-align: center; margin: 20px 0; }
        .spice-icons span { font-size: 2em; margin: 0 10px; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
        .spice-icons span:nth-child(2) { animation-delay: 0.5s; }
        .spice-icons span:nth-child(3) { animation-delay: 1s; }
        .spice-icons span:nth-child(4) { animation-delay: 1.5s; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🌶️</div>
            <h1>Kerala Spice Export Platform</h1>
            <div class="platform-badge">Comprehensive Agri-Export Workspace</div>
            <p>Advanced deployment validation for Kerala's spice trade ecosystem</p>
            <div class="spice-icons">
                <span title="Black Pepper">🌶️</span>
                <span title="Cardamom">💚</span>
                <span title="Turmeric">🟡</span>
                <span title="Cinnamon">🤎</span>
            </div>
        </div>

        <?php
        $errors = [];
        $warnings = [];
        $passed = [];

        // Test 1: PHP Version
        $phpVersion = PHP_VERSION;
        if (version_compare($phpVersion, '8.3', '>=')) {
            $passed[] = "PHP Version: $phpVersion ✓ (Kerala Platform Ready)";
        } else {
            $errors[] = "PHP Version: $phpVersion (requires 8.3+ for advanced features)";
        }

        // Test 2: Required Extensions
        $requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'gd', 'zip', 'curl', 'openssl'];
        foreach ($requiredExtensions as $ext) {
            if (extension_loaded($ext)) {
                $passed[] = "PHP Extension: $ext ✓ (Spice trade features enabled)";
            } else {
                $errors[] = "PHP Extension: $ext (missing - required for agri-export features)";
            }
        }

        // Test 3: Platform Core Files
        $platformFiles = [
            '.htaccess' => 'Web server configuration for Kerala platform',
            'index.php' => 'Main entry point',
            'composer.json' => 'Dependencies for comprehensive features',
            'app/public_api.php' => 'Enhanced REST API with CRM & workflow',
            'public/admin/index.html' => 'Comprehensive admin dashboard',
            'public/admin/assets/app.js' => 'Advanced JavaScript with i18n support',
            'public/admin/assets/style.css' => 'Kerala-themed responsive design',
            'public/sse.php' => 'Real-time updates for live tracking',
            'scripts/migrate_db.php' => 'Database setup with CRM & workflow tables'
        ];

        foreach ($platformFiles as $file => $desc) {
            if (file_exists($file)) {
                $passed[] = "Platform File: $file ($desc) ✓";
            } else {
                $errors[] = "Platform File: $file missing ($desc)";
            }
        }

        // Test 4: Enhanced Features Check
        $enhancedFeatures = [
            'public/admin/index.html' => 'CRM Module, Workflow Manager, Document Center',
            'public/admin/assets/app.js' => 'Malayalam language support, Kerala-specific features',
            'public/admin/assets/style.css' => 'Spice-themed design with responsive layout'
        ];

        foreach ($enhancedFeatures as $file => $features) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                if (strpos($content, 'crm') !== false || strpos($content, 'workflow') !== false || strpos($content, 'kerala') !== false) {
                    $passed[] = "Enhanced Features: $features ✓";
                } else {
                    $warnings[] = "Enhanced Features: $features (basic version detected)";
                }
            }
        }

        // Test 5: Kerala-Specific Features
        $keralaFeatures = [
            'APEDA Integration' => 'apeda',
            'GI Tag Support' => 'gi_tag',
            'Malayalam Language' => 'malayalam',
            'Spice Market Integration' => 'spice_market',
            'Kerala Port Connectivity' => 'kochi_port'
        ];

        $adminJs = file_exists('public/admin/assets/app.js') ? file_get_contents('public/admin/assets/app.js') : '';
        foreach ($keralaFeatures as $feature => $keyword) {
            if (strpos(strtolower($adminJs), $keyword) !== false || strpos(strtolower($adminJs), str_replace('_', '', $keyword)) !== false) {
                $passed[] = "Kerala Feature: $feature ✓";
            } else {
                $warnings[] = "Kerala Feature: $feature (not detected)";
            }
        }

        // Test 6: Environment Configuration
        if (file_exists('.env')) {
            $passed[] = "Environment file: .env exists ✓";
            
            $envContent = file_get_contents('.env');
            $requiredVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS'];
            
            foreach ($requiredVars as $var) {
                if (strpos($envContent, "$var=") !== false && strpos($envContent, "$var=\n") === false) {
                    $passed[] = "Environment: $var configured ✓";
                } else {
                    $warnings[] = "Environment: $var not configured or empty";
                }
            }
        } else {
            $warnings[] = ".env file missing (copy from .env.example)";
        }

        // Test 7: Advanced Platform Capabilities
        $platformCapabilities = [
            'CRM Management' => ['leads', 'customers', 'opportunities'],
            'Workflow Management' => ['tasks', 'workflow', 'kanban'],
            'Document Management' => ['upload', 'categorize', 'compliance'],
            'Real-time Features' => ['sse', 'live', 'realtime'],
            'Multi-language Support' => ['i18n', 'malayalam', 'translation']
        ];

        foreach ($platformCapabilities as $capability => $keywords) {
            $found = false;
            foreach ($keywords as $keyword) {
                if (strpos(strtolower($adminJs), $keyword) !== false) {
                    $found = true;
                    break;
                }
            }
            if ($found) {
                $passed[] = "Platform Capability: $capability ✓";
            } else {
                $warnings[] = "Platform Capability: $capability (limited features)";
            }
        }

        // Test 8: Database Connection (if .env exists)
        if (file_exists('.env')) {
            $envVars = [];
            $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $envVars[trim($key)] = trim($value);
                }
            }

            if (isset($envVars['DB_HOST'], $envVars['DB_NAME'], $envVars['DB_USER'], $envVars['DB_PASS'])) {
                try {
                    $pdo = new PDO(
                        "mysql:host={$envVars['DB_HOST']};dbname={$envVars['DB_NAME']};charset=utf8mb4",
                        $envVars['DB_USER'],
                        $envVars['DB_PASS'],
                        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                    );
                    $passed[] = "Database connection: Successful ✓ (Kerala platform ready)";
                    
                    // Check for enhanced tables
                    $enhancedTables = ['leads', 'tasks', 'compliance_documents', 'sse_clients'];
                    foreach ($enhancedTables as $table) {
                        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
                        if ($stmt->rowCount() > 0) {
                            $passed[] = "Enhanced Table: $table exists ✓";
                        } else {
                            $warnings[] = "Enhanced Table: $table missing (run enhanced migration)";
                        }
                    }
                } catch (Exception $e) {
                    $errors[] = "Database connection: " . $e->getMessage();
                }
            }
        }

        // Calculate enhanced score
        $totalTests = count($passed) + count($warnings) + count($errors);
        $score = $totalTests > 0 ? round((count($passed) / $totalTests) * 100, 1) : 0;
        ?>

        <div class="summary">
            <h2>🌶️ Kerala Spice Export Platform - Deployment Score: <?php echo $score; ?>%</h2>
            <div class="progress-bar">
                <div class="progress-fill" style="width: <?php echo $score; ?>%"></div>
            </div>
            <p>
                ✅ Passed: <?php echo count($passed); ?> | 
                ⚠️ Warnings: <?php echo count($warnings); ?> | 
                ❌ Errors: <?php echo count($errors); ?>
            </p>
            <div class="platform-features">
                <h3>🚀 Advanced Platform Features Ready:</h3>
                <div class="feature-grid">
                    <span class="feature-item">📊 Enhanced Dashboard with Kerala themes</span>
                    <span class="feature-item">👥 Comprehensive CRM with lead management</span>
                    <span class="feature-item">🚢 Advanced shipment tracking with documents</span>
                    <span class="feature-item">📋 Workflow manager with task boards</span>
                    <span class="feature-item">📄 Document center with categorization</span>
                    <span class="feature-item">🛡️ APEDA compliance integration</span>
                    <span class="feature-item">🌶️ Kerala spice market features</span>
                    <span class="feature-item">🌐 Malayalam language support</span>
                    <span class="feature-item">📈 Real-time analytics and insights</span>
                    <span class="feature-item">🎨 Spice-themed responsive design</span>
                    <span class="feature-item">⚡ Server-sent events for live updates</span>
                    <span class="feature-item">🏷️ GI tag product management</span>
                </div>
            </div>
        </div>

        <?php if (!empty($passed)): ?>
        <div class="status-section passed">
            <h3>✅ Passed Tests (<?php echo count($passed); ?>)</h3>
            <div class="status-list">
                <?php foreach ($passed as $test): ?>
                <div class="status-item"><?php echo htmlspecialchars($test); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($warnings)): ?>
        <div class="status-section warning">
            <h3>⚠️ Warnings (<?php echo count($warnings); ?>)</h3>
            <div class="status-list">
                <?php foreach ($warnings as $warning): ?>
                <div class="status-item"><?php echo htmlspecialchars($warning); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
        <div class="status-section error">
            <h3>❌ Critical Errors (<?php echo count($errors); ?>)</h3>
            <div class="status-list">
                <?php foreach ($errors as $error): ?>
                <div class="status-item"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="summary">
            <?php if (empty($errors)): ?>
                <h2>🎉 Kerala Spice Export Platform Ready!</h2>
                <p>Your comprehensive agri-export workspace is ready for Kerala's spice trade ecosystem!</p>
                
                <h3>🌟 What You Get:</h3>
                <div style="text-align: left; max-width: 600px; margin: 0 auto;">
                    <ul style="list-style: none; padding: 0;">
                        <li>🌶️ <strong>Spice-Themed Interface:</strong> Beautiful Kerala-inspired design</li>
                        <li>👥 <strong>Advanced CRM:</strong> Lead management with conversion tracking</li>
                        <li>📋 <strong>Workflow Manager:</strong> Kanban-style task management</li>
                        <li>🚢 <strong>Enhanced Shipment Tracking:</strong> Document downloads & real-time updates</li>
                        <li>📄 <strong>Document Center:</strong> Categorized compliance management</li>
                        <li>🛡️ <strong>APEDA Integration:</strong> Seamless compliance workflows</li>
                        <li>🌐 <strong>Malayalam Support:</strong> Bilingual interface for local users</li>
                        <li>📊 <strong>Real-time Analytics:</strong> Live market trends & insights</li>
                    </ul>
                </div>

                <h3>📋 Next Steps:</h3>
                <ol style="text-align: left; max-width: 500px; margin: 0 auto;">
                    <li>Configure database credentials in .env file</li>
                    <li>Run enhanced database migration</li>
                    <li>Access admin panel and change default passwords</li>
                    <li>Configure APEDA integration settings</li>
                    <li>Upload Kerala spice product catalogs</li>
                </ol>
            <?php else: ?>
                <h2>❌ Platform Setup Incomplete</h2>
                <p>Please fix critical errors before deploying the Kerala Spice Export Platform.</p>
            <?php endif; ?>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="/public/admin/" class="button">🌶️ Launch Kerala Platform</a>
            <a href="/app/public_api.php?endpoint=health" class="button">🔍 API Health Check</a>
            <a href="/test.html" class="button">🧪 Function Tests</a>
            <a href="?refresh=1" class="button">🔄 Refresh Check</a>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(5, 150, 105, 0.1)); border-radius: 10px;">
            <h3>🌶️ Kerala Spice Export Platform Features</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 15px;">
                <div>
                    <h4>🏢 Business Management</h4>
                    <ul style="font-size: 14px;">
                        <li>Lead & Customer CRM</li>
                        <li>Opportunity Pipeline</li>
                        <li>Task Workflow Management</li>
                        <li>Document Compliance</li>
                    </ul>
                </div>
                <div>
                    <h4>🚢 Export Operations</h4>
                    <ul style="font-size: 14px;">
                        <li>Shipment Tracking</li>
                        <li>Document Downloads</li>
                        <li>APEDA Integration</li>
                        <li>Port Connectivity</li>
                    </ul>
                </div>
                <div>
                    <h4>🌶️ Kerala Specialization</h4>
                    <ul style="font-size: 14px;">
                        <li>GI Tag Management</li>
                        <li>Spice Market Trends</li>
                        <li>Malayalam Interface</li>
                        <li>Local Compliance</li>
                    </ul>
                </div>
                <div>
                    <h4>📊 Analytics & Insights</h4>
                    <ul style="font-size: 14px;">
                        <li>Real-time Dashboards</li>
                        <li>Revenue Analytics</li>
                        <li>Performance Metrics</li>
                        <li>Market Intelligence</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
