<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch priorities from the database
try {
    $stmt = $pdo->query("SELECT * FROM priorities");
    $priorities = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Priorities</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Priorities List</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($priorities as $priority): ?>
                <tr>
                    <td><?php echo htmlspecialchars($priority['id']); ?></td>
                    <td><?php echo htmlspecialchars($priority['name']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
