<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$task_id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :task_id");
$stmt->execute(['task_id' => $task_id]);

header("Location: dashboard.php");
exit;
?>
