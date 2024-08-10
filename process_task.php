<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the form data is set
if (isset($_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['priority'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $priority_id = intval($_POST['priority']);
    $user_id = $_SESSION['user_id'];

    // Validate data
    if (!empty($title) && !empty($description) && !empty($due_date) && $priority_id > 0) {
        // Insert task into the database
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, due_date, priority_id, user_id) VALUES (:title, :description, :due_date, :priority_id, :user_id)");
        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'due_date' => $due_date,
            'priority_id' => $priority_id,
            'user_id' => $user_id
        ]);

        header("Location: dashboard.php"); // Redirect to dashboard after success
        exit;
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Missing form data.";
}
?>
