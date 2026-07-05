<?php
require_once '../config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $stmt = $pdo->query("SELECT p.* FROM projects p ORDER BY p.id DESC");
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } else if ($method === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? 'New Project';
        $status = $data['status'] ?? 'Active';
        $health = $data['health'] ?? 100;
        $duration = $data['duration'] ?? null;
        
        $stmt = $pdo->prepare('INSERT INTO projects (name, status, health, duration) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $status, $health, $duration]);
        echo json_encode(['status' => 'success', 'message' => 'Project added']);
    } else if ($method === 'PUT') {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $status = $data['status'] ?? 'Active';
        
        $stmt = $pdo->prepare('UPDATE projects SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
        echo json_encode(['status' => 'success', 'message' => 'Project updated']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
