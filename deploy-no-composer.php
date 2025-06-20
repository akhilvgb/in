<?php

/**
 * Simple Deployment Script - No Composer Required
 * For Hostinger deployment without composer dependencies
 */

echo "🚀 Deploying Indian Trade Platform (No Composer)...\n\n";

// Create simple autoloader
$autoloaderContent = '<?php

/**
 * Simple PSR-4 Autoloader for Indian Trade Platform
 */

spl_autoload_register(function ($class) {
    $prefix = "ExportPlatform\\\\";
    $baseDir = __DIR__ . "/app/";
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace("\\\\", "/", $relativeClass) . ".php";
    
    if (file_exists($file)) {
        require $file;
    }
});
';

file_put_contents('autoload.php', $autoloaderContent);
echo "✅ Created simple autoloader\n";

// Update public_api.php to use simple autoloader
$apiContent = '<?php

declare(strict_types=1);

// Simple autoloader instead of composer
require_once __DIR__ . "/../autoload.php";

// Production API for Indian Import/Export Trading Platform
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Handle preflight requests
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

// Simple environment loader
function loadEnv(string $filePath): array
{
    if (!file_exists($filePath)) {
        return [];
    }

    $env = [];
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        if (strpos(trim($line), "#") === 0) {
            continue;
        }

        if (strpos($line, "=") !== false) {
            [$key, $value] = explode("=", $line, 2);
            $key = trim($key);
            $value = trim($value, " \\t\\n\\r\\0\\x0B\"\'");
            $env[$key] = $value;
            $_ENV[$key] = $value;
        }
    }

    return $env;
}

// Load environment variables
if (file_exists(__DIR__ . "/../.env")) {
    loadEnv(__DIR__ . "/../.env");
}

class IndianTradeApiController
{
    private array $response = [];
    private int $statusCode = 200;
    private ?PDO $db = null;

    public function __construct()
    {
        $this->initDatabase();
    }

    private function initDatabase(): void
    {
        try {
            $host = $_ENV["DB_HOST"] ?? "localhost";
            $dbname = $_ENV["DB_NAME"] ?? "indian_trade_platform";
            $username = $_ENV["DB_USER"] ?? "root";
            $password = $_ENV["DB_PASS"] ?? "";

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            $this->db = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            $this->db = null;
        }
    }

    public function handleRequest(): void
    {
        try {
            $method = $_SERVER["REQUEST_METHOD"];
            $endpoint = $_GET["endpoint"] ?? "";
            $segments = explode("/", trim($endpoint, "/"));

            match ([$method, $segments[0]]) {
                ["GET", "health"] => $this->healthCheck(),
                ["GET", "stats"] => $this->getStats(),
                ["GET", "shipments"] => $this->getShipments($segments),
                ["POST", "shipments"] => $this->createShipment(),
                ["GET", "tracking"] => $this->trackShipment($segments),
                ["GET", "leads"] => $this->getLeads(),
                ["POST", "leads"] => $this->createLead(),
                ["GET", "tasks"] => $this->getTasks(),
                ["POST", "tasks"] => $this->createTask(),
                default => $this->notFound()
            };

        } catch (Exception $e) {
            $this->error($e->getMessage(), 500);
        }

        $this->sendResponse();
    }

    private function healthCheck(): void
    {
        $dbStatus = $this->db ? "connected" : "disconnected";
        
        $this->success([
            "status" => "healthy",
            "timestamp" => time(),
            "database" => $dbStatus,
            "version" => "2.0.0",
            "platform" => "Indian Import/Export Trading Platform"
        ]);
    }

    private function getStats(): void
    {
        if (!$this->db) {
            $this->success($this->getEmptyStats());
            return;
        }

        try {
            $stmt = $this->db->query("
                SELECT 
                    COUNT(*) as total,
                    COUNT(CASE WHEN type = \'export\' THEN 1 END) as exports,
                    COUNT(CASE WHEN type = \'import\' THEN 1 END) as imports,
                    COUNT(CASE WHEN type = \'trading\' THEN 1 END) as trading,
                    COUNT(CASE WHEN type = \'domestic\' THEN 1 END) as domestic,
                    COUNT(CASE WHEN status = \'pending\' THEN 1 END) as pending,
                    COUNT(CASE WHEN status = \'processing\' THEN 1 END) as processing,
                    COUNT(CASE WHEN status = \'shipped\' THEN 1 END) as shipped,
                    COUNT(CASE WHEN status = \'in_transit\' THEN 1 END) as in_transit,
                    COUNT(CASE WHEN status = \'customs\' THEN 1 END) as customs,
                    COUNT(CASE WHEN status = \'delivered\' THEN 1 END) as delivered,
                    COUNT(CASE WHEN status = \'cancelled\' THEN 1 END) as cancelled,
                    COALESCE(SUM(total_value), 0) as total_value,
                    COALESCE(AVG(total_value), 0) as avg_value
                FROM shipments 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
            ");
            
            $stats = $stmt->fetch();
            $this->success($stats ?: $this->getEmptyStats());
        } catch (PDOException $e) {
            $this->success($this->getEmptyStats());
        }
    }

    private function getEmptyStats(): array
    {
        return [
            "total" => 0,
            "exports" => 0,
            "imports" => 0,
            "trading" => 0,
            "domestic" => 0,
            "pending" => 0,
            "processing" => 0,
            "shipped" => 0,
            "in_transit" => 0,
            "customs" => 0,
            "delivered" => 0,
            "cancelled" => 0,
            "total_value" => 0,
            "avg_value" => 0
        ];
    }

    private function getShipments(array $segments): void
    {
        if (!$this->db) {
            $this->success(["shipments" => [], "pagination" => ["total" => 0, "limit" => 20, "offset" => 0]]);
            return;
        }

        try {
            $stmt = $this->db->query("SELECT * FROM shipments ORDER BY created_at DESC LIMIT 20");
            $shipments = $stmt->fetchAll();

            $this->success([
                "shipments" => array_map([$this, "formatShipment"], $shipments),
                "pagination" => ["total" => count($shipments), "limit" => 20, "offset" => 0]
            ]);
        } catch (PDOException $e) {
            $this->success(["shipments" => [], "pagination" => ["total" => 0, "limit" => 20, "offset" => 0]]);
        }
    }

    private function createShipment(): void
    {
        $input = $this->getJsonInput();
        
        if (!$input || !isset($input["customer_name"], $input["type"])) {
            $this->error("Invalid input data. Required: customer_name, type", 400);
            return;
        }

        if (!$this->db) {
            $this->error("Database not available", 503);
            return;
        }

        $trackingNumber = $this->generateTrackingNumber($input["type"]);
        
        try {
            $stmt = $this->db->prepare("
                INSERT INTO shipments (
                    tracking_number, type, status, customer_name, customer_email,
                    origin_country, destination_country, total_value, currency
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $trackingNumber,
                $input["type"],
                "pending",
                $input["customer_name"],
                $input["customer_email"] ?? "",
                $input["origin_country"] ?? "India",
                $input["destination_country"] ?? "",
                $input["total_value"] ?? 0,
                $input["currency"] ?? "USD"
            ]);

            $shipmentId = $this->db->lastInsertId();
            
            $this->success([
                "id" => (int) $shipmentId,
                "tracking_number" => $trackingNumber,
                "message" => "Shipment created successfully"
            ], 201);
        } catch (PDOException $e) {
            $this->error("Failed to create shipment", 500);
        }
    }

    private function trackShipment(array $segments): void
    {
        if (!isset($segments[1])) {
            $this->error("Tracking number required", 400);
            return;
        }

        if (!$this->db) {
            $this->error("Tracking service not available", 503);
            return;
        }

        $trackingNumber = $segments[1];
        
        try {
            $stmt = $this->db->prepare("SELECT * FROM shipments WHERE tracking_number = ?");
            $stmt->execute([$trackingNumber]);
            $shipment = $stmt->fetch();

            if (!$shipment) {
                $this->error("Shipment not found", 404);
                return;
            }

            $this->success($this->formatShipment($shipment));
        } catch (PDOException $e) {
            $this->error("Tracking service error", 500);
        }
    }

    private function getLeads(): void
    {
        if (!$this->db) {
            $this->success(["leads" => []]);
            return;
        }

        try {
            $stmt = $this->db->query("SELECT * FROM leads ORDER BY created_at DESC LIMIT 100");
            $leads = $stmt->fetchAll();
            $this->success(["leads" => $leads]);
        } catch (PDOException $e) {
            $this->success(["leads" => []]);
        }
    }

    private function createLead(): void
    {
        $input = $this->getJsonInput();
        
        if (!$input || !isset($input["name"], $input["email"])) {
            $this->error("Invalid input data. Required: name, email", 400);
            return;
        }

        if (!$this->db) {
            $this->error("Database not available", 503);
            return;
        }

        try {
            $stmt = $this->db->prepare("
                INSERT INTO leads (name, email, phone, company, country, product_interest, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $input["name"],
                $input["email"],
                $input["phone"] ?? null,
                $input["company"] ?? null,
                $input["country"] ?? "",
                $input["product_interest"] ?? null,
                "new"
            ]);

            $leadId = $this->db->lastInsertId();
            
            $this->success([
                "id" => (int) $leadId,
                "message" => "Lead created successfully"
            ], 201);
        } catch (PDOException $e) {
            $this->error("Failed to create lead", 500);
        }
    }

    private function getTasks(): void
    {
        if (!$this->db) {
            $this->success(["tasks" => []]);
            return;
        }

        try {
            $stmt = $this->db->query("SELECT * FROM tasks ORDER BY created_at DESC LIMIT 100");
            $tasks = $stmt->fetchAll();
            $this->success(["tasks" => $tasks]);
        } catch (PDOException $e) {
            $this->success(["tasks" => []]);
        }
    }

    private function createTask(): void
    {
        $input = $this->getJsonInput();
        
        if (!$input || !isset($input["title"])) {
            $this->error("Invalid input data. Required: title", 400);
            return;
        }

        if (!$this->db) {
            $this->error("Database not available", 503);
            return;
        }

        try {
            $stmt = $this->db->prepare("
                INSERT INTO tasks (title, description, type, status, priority) 
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $input["title"],
                $input["description"] ?? null,
                $input["type"] ?? "general",
                "pending",
                $input["priority"] ?? "medium"
            ]);

            $taskId = $this->db->lastInsertId();
            
            $this->success([
                "id" => (int) $taskId,
                "message" => "Task created successfully"
            ], 201);
        } catch (PDOException $e) {
            $this->error("Failed to create task", 500);
        }
    }

    private function generateTrackingNumber(string $type): string
    {
        $prefix = match($type) {
            "export" => "IEX",
            "import" => "IIM",
            "trading" => "ITR",
            "domestic" => "IDM",
            default => "ITR"
        };
        
        return $prefix . date("ymd") . str_pad((string)rand(1, 9999), 4, "0", STR_PAD_LEFT);
    }

    private function formatShipment(array $shipment): array
    {
        return [
            "id" => (int) $shipment["id"],
            "tracking_number" => $shipment["tracking_number"],
            "type" => [
                "value" => $shipment["type"],
                "display_name" => ucfirst($shipment["type"])
            ],
            "status" => [
                "value" => $shipment["status"],
                "display_name" => ucwords(str_replace("_", " ", $shipment["status"])),
                "color" => $this->getStatusColor($shipment["status"])
            ],
            "customer" => [
                "name" => $shipment["customer_name"],
                "email" => $shipment["customer_email"]
            ],
            "route" => [
                "origin" => ["country" => $shipment["origin_country"]],
                "destination" => ["country" => $shipment["destination_country"]]
            ],
            "value" => [
                "amount" => (float) $shipment["total_value"],
                "currency" => $shipment["currency"]
            ],
            "created_at" => $shipment["created_at"]
        ];
    }

    private function getStatusColor(string $status): string
    {
        return match($status) {
            "pending" => "#fbbf24",
            "processing" => "#3b82f6", 
            "shipped" => "#8b5cf6",
            "in_transit" => "#06b6d4",
            "customs" => "#f59e0b",
            "delivered" => "#10b981",
            "cancelled" => "#ef4444",
            default => "#6b7280"
        };
    }

    private function getJsonInput(): array
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        return $data ?? [];
    }

    private function success(array $data, int $code = 200): void
    {
        $this->response = [
            "success" => true,
            "data" => $data,
            "timestamp" => time()
        ];
        $this->statusCode = $code;
    }

    private function error(string $message, int $code = 400): void
    {
        $this->response = [
            "success" => false,
            "error" => $message,
            "timestamp" => time()
        ];
        $this->statusCode = $code;
    }

    private function notFound(): void
    {
        $this->error("Endpoint not found", 404);
    }

    private function sendResponse(): void
    {
        http_response_code($this->statusCode);
        echo json_encode($this->response, JSON_PRETTY_PRINT);
    }
}

// Initialize and handle request
$controller = new IndianTradeApiController();
$controller->handleRequest();
';

file_put_contents('app/public_api.php', $apiContent);
echo "✅ Updated API to use simple autoloader\n";

echo "\n🎉 Deployment ready without composer dependencies!\n";
echo "📁 Upload all files to Hostinger\n";
echo "🔧 Run /scripts/migrate_db.php to setup database\n";
echo "🌐 Access at /public/admin/\n";
