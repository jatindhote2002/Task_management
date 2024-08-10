<?php
include 'config.php';
session_start();

// Check if 'id' parameter is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Task ID is missing.";
    exit;
}

$task_id = intval($_GET['id']); // Convert to integer to avoid SQL injection

// Fetch the specific task from the database, joining the priorities table
$stmt = $pdo->prepare("SELECT tasks.*, priorities.name AS priority_name 
                       FROM tasks 
                       JOIN priorities ON tasks.priority_id = priorities.id 
                       WHERE tasks.id = :id AND tasks.user_id = :user_id");
$stmt->execute(['id' => $task_id, 'user_id' => $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task) {
    echo "Task not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Task</title>
    <style>
        body {
            background-color: #ecf0f1; /* Dark background */
            color: #f0f0f0; /* Light text color */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #2c3e50; /* Darker background for the container */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            color: #e74c3c; /* Bright red for the header */
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            margin: 10px 0;
            font-size: 18px;
        }

        strong {
            color: #ecf0f1; /* Light gray for labels */
        }

        .priority-high {
            color: #e74c3c; /* Red for high priority */
        }

        .priority-medium {
            color: #e67e22; /* Orange for medium priority */
        }

        .priority-low {
            color: #2ecc71; /* Green for low priority */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Task Details</h1>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($task['title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($task['description']); ?></p>
        <p><strong>Due Date:</strong> <?php echo htmlspecialchars($task['due_date']); ?></p>
        <p><strong>Priority:</strong> 
            <span class="<?php echo 'priority-' . strtolower($task['priority']); ?>">
                <?php echo htmlspecialchars($task['priority_name']); ?>
            </span>
        </p>
    </div>
</body>
</html>

