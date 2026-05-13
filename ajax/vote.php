<?php
require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_id = (int)($_POST['team_id'] ?? 0);

    // Support JSON input as well
    if ($team_id === 0) {
        $json = json_decode(file_get_contents('php://input'), true);
        $team_id = (int)($json['team_id'] ?? 0);
    }

    if ($team_id > 0) {
        $stmt = $pdo->prepare("UPDATE teams SET votes = votes + 1 WHERE id = ?");
        $stmt->execute([$team_id]);

        echo json_encode(['success' => true, 'message' => 'Vote recorded!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid team ID.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>
