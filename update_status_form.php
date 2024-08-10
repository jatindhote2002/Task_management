<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Task Status</title>
    <style>
        body {
            background-color: #1a1a1a; /* Dark background */
            color: #f0f0f0; /* Light text color */
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #e74c3c; /* Bright red */
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #2c3e50; /* Darker background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #ecf0f1; /* Light gray text */
            text-align: left;
            width: 100%;
            text-align: left;
        }

        input[type="text"],
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

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #e74c3c; /* Bright red button */
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #c0392b; /* Darker red on hover */
        }
    </style>
</head>
<body>
    <form method="POST" action="update_status.php">
    <h1>Update Task Status</h1>

        <label for="task_id">Task ID:</label>
        <input type="text" id="task_id" name="id" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
            <option value="in_progress">In Progress</option>
        </select>

        <input type="submit" value="Update Status">
    </form>
</body>
</html>
