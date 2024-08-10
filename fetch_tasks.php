<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Get the page number from the request, default to 1 if not provided
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Define how many tasks to display per page
$tasksPerPage = 5;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $tasksPerPage;

// Fetch tasks from the database with limit and offset for pagination
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY due_date ASC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindValue(':limit', $tasksPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate the HTML for the tasks
$output = '';
foreach ($tasks as $task) {
    $output .= '<tr class="priority-' . strtolower(htmlspecialchars($task['priority'])) . '">';
    $output .= '<td>' . htmlspecialchars($task['title']) . '</td>';
    $output .= '<td>' . htmlspecialchars($task['due_date']) . '</td>';
    $output .= '<td>' . htmlspecialchars($task['status']) . '</td>';
    $output .= '<td>' . htmlspecialchars($task['priority']) . '</td>';
    $output .= '<td>
                    <a href="edit_task.php?id=' . $task['id'] . '">Edit</a>
                    <a href="delete_task.php?id=' . $task['id'] . '" onclick="return confirm(\'Are you sure you want to delete this task?\');">Delete</a>
                    <a href="view_task.php?id=' . $task['id'] . '">View</a>
                </td>';
    $output .= '</tr>';
}

// Return the tasks HTML as a JSON response
echo json_encode(['success' => true, 'data' => $output]);
?>
<script>
function loadTasks(page) {
    $.ajax({
        url: 'fetch_tasks.php',
        type: 'GET',
        data: { page: page },
        success: function(response) {
            if (response.success) {
                $('#task-table tbody').html(response.data);
            } else {
                $('#task-table tbody').html('<tr><td colspan="5">No tasks found.</td></tr>');
            }
        },
        error: function() {
            $('#task-table tbody').html('<tr><td colspan="5">An error occurred while loading tasks.</td></tr>');
        }
    });
}

</script>