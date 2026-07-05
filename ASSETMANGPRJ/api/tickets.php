<?php
require_once '../config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('php://input'), true) ?? [];

try {
    function recalculateProjectHealth($pdo, $project_id) {
        if (!$project_id) return;
        $stmt = $pdo->prepare("
            UPDATE projects p
            SET health = (
                100 - LEAST(
                    COALESCE((
                        SELECT SUM(
                            CASE 
                                WHEN priority = 'Critical' THEN 40
                                WHEN priority = 'High' THEN 20 
                                WHEN priority = 'Normal' THEN 10 
                                ELSE 0 
                            END
                        ) 
                        FROM tickets 
                        WHERE project_id = p.id AND status != 'Resolved'
                    ), 0), 
                100)
            )
            WHERE id = ?
        ");
        $stmt->execute([$project_id]);
    }

    if ($method === 'GET') {
        $stmt = $pdo->query('SELECT t.*, p.name as project_name, a.name as asset_name 
                             FROM tickets t 
                             LEFT JOIN projects p ON t.project_id = p.id 
                             LEFT JOIN assets a ON t.asset_id = a.id 
                             ORDER BY t.id DESC');
        echo json_encode(['status' => 'success', 'data' => $stmt->fetchAll()]);
    } else if ($method === 'POST') {
        $asset_id = (int)($data['asset_id'] ?? 0);
        $project_id = (int)($data['project_id'] ?? 0);
        $description = $data['description'] ?? '';
        $priority = $data['priority'] ?? 'Normal';
        $age = (int)($data['age'] ?? 0);
        $breakdowns = (int)($data['breakdown_count'] ?? 0);
        $cost = (float)($data['repair_cost'] ?? 0);
        $downtime = (int)($data['downtime_hours'] ?? 0);
        
        $stmt = $pdo->prepare('INSERT INTO tickets (asset_id, project_id, description, priority, status, age, breakdown_count, repair_cost, downtime_hours) VALUES (?, ?, ?, ?, "Open", ?, ?, ?, ?)');
        $stmt->execute([$asset_id, $project_id, $description, $priority, $age, $breakdowns, $cost, $downtime]);
        
        recalculateProjectHealth($pdo, $project_id);
        
        echo json_encode(['status' => 'success', 'message' => 'Ticket created']);
    } else if ($method === 'PUT') {
        // Handle Technician status update
        $id = (int)($data['id'] ?? 0);
        $status = $data['status'] ?? 'Open';
        $added_cost = (float)($data['add_cost'] ?? 0);
        
        // Ensure updated_at updates automatically if we update status or cost.
        $stmt = $pdo->prepare('UPDATE tickets SET status = ?, repair_cost = repair_cost + ? WHERE id = ?');
        $stmt->execute([$status, $added_cost, $id]);
        
        $stmtProj = $pdo->prepare('SELECT project_id FROM tickets WHERE id = ?');
        $stmtProj->execute([$id]);
        $ticketRow = $stmtProj->fetch();
        if ($ticketRow && $ticketRow['project_id']) {
            recalculateProjectHealth($pdo, $ticketRow['project_id']);
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Ticket updated']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
