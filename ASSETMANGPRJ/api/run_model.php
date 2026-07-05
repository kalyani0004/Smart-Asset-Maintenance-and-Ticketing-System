<?php
require_once '../config.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
	
    
    // Command to execute python script - Use absolute paths for XAMPP
    $pythonPath = 'C://Users//kalya//AppData//Local//Programs//Python//Python313//python.exe';
    $scriptPath = __DIR__ . '/../predict_risk.py';
    
    $descriptorspec = [
        0 => ["pipe", "r"], // stdin
        1 => ["pipe", "w"], // stdout
        2 => ["pipe", "w"]  // stderr
    ];

    $process = proc_open("$pythonPath " . escapeshellarg($scriptPath), $descriptorspec, $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], $data);
        fclose($pipes[0]);

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($process);

        if ($output) {
            $decoded = json_decode($output, true);
            if ($decoded) {
                echo $output;
            } else {
                echo json_encode(["status" => "error", "message" => "Python script output invalid JSON.", "raw" => $output, "stderr" => $stderr]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Python script execution failed.", "stderr" => $stderr]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to start Python process."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Only POST allowed."]);
}
?>
