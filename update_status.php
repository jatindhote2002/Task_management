<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if (isset($_POST['id'], $_POST['status'])) {
    $task_id = intval($_POST['id']);
    $status = trim($_POST['status']);

    $stmt = $pdo->prepare("UPDATE tasks SET status = :status WHERE id = :id AND user_id = :user_id");
    $result = $stmt->execute([
        'status' => $status,
        'id' => $task_id,
        'user_id' => $_SESSION['user_id']
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Task status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update task status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing data']);
}
?>
