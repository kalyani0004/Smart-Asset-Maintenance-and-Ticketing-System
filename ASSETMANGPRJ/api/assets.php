<?php
require_once '../config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $stmt = $pdo->query('SELECT * FROM assets ORDER BY id DESC');
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } else if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? 'New Asset';
        $age = (int)($data['age'] ?? 0);
        $risk_level = $data['risk_level'] ?? 'Low';
        
        $stmt = $pdo->prepare('INSERT INTO assets (name, age, breakdown_count, repair_cost, risk_level) VALUES (?, ?, 0, 0, ?)');
        $stmt->execute([$name, $age, $risk_level]);
        echo json_encode(['status' => 'success', 'message' => 'Asset created']);
    } else if ($method === 'DELETE') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $stmt = $pdo->prepare('DELETE FROM assets WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success', 'message' => 'Asset deleted']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
