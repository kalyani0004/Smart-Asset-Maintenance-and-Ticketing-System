<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [
    'status' => 'success',
    'data' => [
        'asset_health' => ['healthy' => 0, 'at_risk' => 0, 'critical' => 0],
        'ticket_priority' => ['critical' => 0, 'high' => 0, 'normal' => 0],
        'estimated_repair_costs' => '0'
    ]
];

try {
    require_once '../config.php';
    if (!isset($pdo)) throw new Exception("Database connection not established.");

    // 1. Asset Health Distribution - Using non-resolved tickets for current health
    $healthQuery = "SELECT 
        COUNT(CASE WHEN max_p >= 40 THEN 1 END) as critical,
        COUNT(CASE WHEN max_p >= 20 AND max_p < 40 THEN 1 END) as at_risk,
        COUNT(CASE WHEN max_p < 20 THEN 1 END) as healthy
        FROM (SELECT a.id, 
            MAX(CASE WHEN LOWER(t.status) = 'open' AND LOWER(t.priority) = 'critical' THEN 40 
                     WHEN LOWER(t.status) = 'open' AND LOWER(t.priority) = 'high' THEN 20 
                     WHEN LOWER(t.status) = 'open' AND LOWER(t.priority) = 'normal' THEN 10 
                     ELSE 0 END) as max_p
            FROM assets a LEFT JOIN tickets t ON a.id = t.asset_id GROUP BY a.id) as ah";
    
    $stmt = $pdo->query($healthQuery);
    if ($stmt) {
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stats) {
            $response['data']['asset_health'] = [
                'healthy' => (int)($stats['healthy'] ?? 0),
                'at_risk' => (int)($stats['at_risk'] ?? 0),
                'critical' => (int)($stats['critical'] ?? 0)
            ];
        }
    }

    // 2. Ticket Stats - Unified Query for Priority & Open Status
    $stmt = $pdo->query("SELECT priority, COUNT(*) as count FROM tickets WHERE LOWER(status) = 'open' GROUP BY priority");
    $priorityCounts = ['critical' => 0, 'high' => 0, 'normal' => 0];
    if ($stmt) {
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $p = strtolower($row['priority']);
            if (isset($priorityCounts[$p])) {
                $priorityCounts[$p] = (int)$row['count'];
            }
        }
    }
    $response['data']['ticket_priority'] = $priorityCounts;
    
    // 3. Total Logged Repair Costs
    $stmt = $pdo->query("SELECT SUM(repair_cost) as total FROM tickets");
    $totalCost = 0;
    if ($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalCost = $row['total'] ?? 0;
    }
    $response['data']['estimated_repair_costs'] = (string)$totalCost;

} catch (Exception $e) {
    // If we fail, we still return the zeroed response with a warning
    // instead of a 500 error to keep the dashboard running.
    $response['message'] = $e->getMessage();
    $response['status'] = 'warning';
}

echo json_encode($response);
?>
