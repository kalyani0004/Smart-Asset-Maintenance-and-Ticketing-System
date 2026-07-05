<?php
require 'api/../config.php';
$stmt = $pdo->query("SELECT * FROM tickets");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($data, JSON_PRETTY_PRINT);
?>
