<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch priorities from the database
$stmt = $pdo->prepare("SELECT * FROM priorities");
$stmt->execute();
$priorities = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <style>
        body {
            background-color: #ddd;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #333;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: 0 auto;
        }

        input, textarea, select {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <form action="process_task.php" method="POST">
        <h1>Add New Task</h1>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <label for="due_date">Due Date:</label>
        <input type="date" id="due_date" name="due_date" required>

        <label for="priority">Priority:</label>
        <select id="priority" name="priority" required>
            <?php foreach ($priorities as $priority): ?>
                <option value="<?php echo $priority['id']; ?>"><?php echo htmlspecialchars($priority['name']); ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Add Task</button>
    </form>
</body>
</html>
