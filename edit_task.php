<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$task_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority_id = $_POST['priority_id'];

    $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, due_date = :due_date, priority_id = :priority_id WHERE id = :task_id");
    $stmt->execute(['title' => $title, 'description' => $description, 'due_date' => $due_date, 'priority_id' => $priority_id, 'task_id' => $task_id]);

    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :task_id");
$stmt->execute(['task_id' => $task_id]);
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
    <title>Update Task</title>
    <!-- Inline CSS -->
    <style>
        body {
            background-color: #ddd; /* Dark background */
            color: #f0f0f0; /* Light text color */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #e74c3c; /* Bright red background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 400px;
        }

        input[type="text"],
        textarea,
        input[type="date"],
        select {
            display: block;
            width: calc(100% - 20px);
            margin: 10px auto;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
        }

        textarea {
            height: 100px;
            resize: vertical; /* Allow vertical resizing */
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #333; /* Dark button background */
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #555; /* Darker button on hover */
        }

        option {
            color: #333; /* Dark text color for options */
        }
    </style>
</head>
<body>
    <form method="POST">
        <label>Title : </label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        <label>Description :</label>
        <textarea name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
        <label>Due Date :</label>
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
         <label>Priority :</label>
        <select name="priority_id">
            <option value="1" <?php echo $task['priority_id'] == 1 ? 'selected' : ''; ?>>High</option>
            <option value="2" <?php echo $task['priority_id'] == 2 ? 'selected' : ''; ?>>Medium</option>
            <option value="3" <?php echo $task['priority_id'] == 3 ? 'selected' : ''; ?>>Low</option>
        </select>
        <input type="submit" value="Update Task">
    </form>
</body>
</html>
