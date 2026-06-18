<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
require_once 'database.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'getInitData':
        try {
            // Fetch configuration settings
            $stmt = $pdo->query("SELECT * FROM settings WHERE id = 1");
            $settings = $stmt->fetch();
            if (!$settings) {
                $settings = [
                    'maintenance' => 0, 'telegramLink' => '', 'adsterraHeader' => '',
                    'adsterraFooter' => '', 'adsterraDetail' => '', 'adsterraSidebar' => '',
                    'adsterraNative' => '', 'adsterraPopunder' => '', 'adsterraSocialBar' => ''
                ];
            } else {
                $settings['maintenance'] = (bool)$settings['maintenance'];
            }

            // Fetch list of apps
            $stmt = $pdo->query("SELECT * FROM apps ORDER BY createdAt DESC LIMIT 100");
            $apps = $stmt->fetchAll();
            foreach ($apps as &$app) {
                $app['rating'] = floatval($app['rating']);
                $app['downloads'] = intval($app['downloads']);
                $app['badges'] = !empty($app['badges']) ? explode(',', $app['badges']) : [];
            }

            // Fetch list of news articles
            $stmt = $pdo->query("SELECT * FROM news ORDER BY createdAt DESC LIMIT 15");
            $news = $stmt->fetchAll();

            echo json_encode([
                "status" => "success",
                "settings" => $settings,
                "apps" => $apps,
                "news" => $news
            ]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        break;

    case 'logVisit':
        try {
            $today = date('Y-m-d');
            
            // Increment global traffic count
            $pdo->query("UPDATE analytics SET total_visits = total_visits + 1 WHERE id = 1");
            
            // Increment daily traffic count
            $stmt = $pdo->prepare("INSERT INTO daily_analytics (visit_date, visit_count) VALUES (?, 1) ON DUPLICATE KEY UPDATE visit_count = visit_count + 1");
            $stmt->execute([$today]);

            echo json_encode(["status" => "success"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        break;

    case 'logDownload':
        try {
            $appId = isset($_GET['appId']) ? intval($_GET['appId']) : 0;
            if ($appId > 0) {
                $stmt = $pdo->prepare("UPDATE apps SET downloads = downloads + 1 WHERE id = ?");
                $stmt->execute([$appId]);
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        break;

    case 'getComments':
        try {
            $appId = isset($_GET['appId']) ? intval($_GET['appId']) : 0;
            if ($appId > 0) {
                $stmt = $pdo->prepare("SELECT * FROM comments WHERE appId = ? ORDER BY createdAt DESC");
                $stmt->execute([$appId]);
                echo json_encode(["status" => "success", "comments" => $stmt->fetchAll()]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }
        break;

    case 'addComment':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $raw = file_get_contents('php://input');
                $data = json_decode($raw, true);
                
                $appId = isset($data['appId']) ? intval($data['appId']) : 0;
                $author = isset($data['author']) ? trim($data['author']) : '';
                $email = isset($data['email']) ? trim($data['email']) : '';
                $text = isset($data['text']) ? trim($data['text']) : '';

                if ($appId > 0 && !empty($author) && !empty($email) && !empty($text)) {
                    $stmt = $pdo->prepare("INSERT INTO comments (appId, author, email, text) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$appId, $author, $email, $text]);
                    echo json_encode(["status" => "success"]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Missing required form fields."]);
                }
            } catch (Exception $e) {
                echo json_encode(["status" => "error", "message" => $e->getMessage()]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "POST method required."]);
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Endpoint routing invalid."]);
        break;
}
?>