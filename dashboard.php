<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch tasks from the database
$stmt = $pdo->prepare("SELECT tasks.*, priorities.name AS priority_name 
                       FROM tasks 
                       JOIN priorities ON tasks.priority_id = priorities.id 
                       WHERE tasks.user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$tasks = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            background-color: #ddd;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        button:hover {
            background-color: #c0392b;
        }

        h2 {
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            color: #000;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        td {
            color: #000;
        }

        .priority-high {
            background-color: #e74c3c;
            color: #fff;
        }

        .priority-medium {
            background-color: #f39c12;
            color: #fff;
        }

        .priority-low {
            background-color: #2ecc71;
            color: #fff;
        }

        a {
            color: #fff;
            text-decoration: none;
            padding: 0 5px;
        }

        a:hover {
            text-decoration: underline;
        }

        #pagination {
            text-align: center;
            margin-top: 20px;
        }

        #pagination a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }

        #pagination a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button onclick="window.location.href='add_task.php'">Add Task</button>
    <h2 style="color: #000;">Task List's</h2>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr class="priority-<?php echo strtolower($task['priority_name']); ?>">
                    <td><?php echo htmlspecialchars($task['title']); ?></td>
                    <td><?php echo htmlspecialchars($task['due_date']); ?></td>
                    <td>
                        <select class="status-update" data-task-id="<?php echo $task['id']; ?>">
                            <option value="Pending" <?php echo $task['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Completed" <?php echo $task['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </td>
                    <td><?php echo htmlspecialchars($task['priority_name']); ?></td>
                    <td>
                        <a href="edit_task.php?id=<?php echo $task['id']; ?>">Edit</a>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task?');">Delete</a>
                        <a href="view_task.php?id=<?php echo $task['id']; ?>">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="pagination">
        <a href="#" id="prev-page" style="color:#000">&laquo; Previous</a>
        <a href="#" id="next-page" style="color:#000">Next &raquo;</a>
    </div>

    <script>
$(document).ready(function() {
    $('.status-update').change(function() {
        let taskId = $(this).data('task-id');
        let newStatus = $(this).val();

        $.ajax({
            url: 'update_status.php',
            type: 'POST',
            data: { id: taskId, status: newStatus },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error updating task status.');
            }
        });
    });

    // Pagination handling
    let currentPage = 1;

    function loadTasks(page) {
        $.ajax({
            url: 'fetch_tasks.php',
            type: 'GET',
            data: { page: page },
            success: function(data) {
                $('#task-table tbody').html(data);
                updatePagination(page);
            }
        });
    }

    function updatePagination(page) {
        $('#prev-page').toggle(page > 1);
        // Add more logic if needed
    }

    $('#prev-page').click(function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            loadTasks(currentPage);
        }
    });

    $('#next-page').click(function(e) {
        e.preventDefault();
        currentPage++;
        loadTasks(currentPage);
    });

    // Load initial tasks
    loadTasks(currentPage);
});

    </script>
</body>
</html>
