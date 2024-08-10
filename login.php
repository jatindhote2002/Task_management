<?php
include 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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

        form {
            background-color: #2c3e50; /* Darker background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
            width: 300px;
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #ecf0f1; /* Light gray text for labels */
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #e74c3c; /* Bright red background */
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

        button {
            background-color: #fff; /* White background */
            color: #e74c3c; /* Bright red text */
            border: 2px solid #e74c3c; /* Red border */
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
            width: 100%;
        }

        button:hover {
            background-color: #e74c3c; /* Red background on hover */
            color: #fff; /* White text on hover */
            transform: translateY(-2px); /* Lift effect */
        }

        button:active {
            background-color: #c0392b; /* Darker red when pressed */
            transform: translateY(1px); /* Pressed effect */
        }
    </style>
</head>
<body>
    <form method="POST" action="login.php">
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Verify the provided password against the hashed password
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Invalid credentials";
    }
}
?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
        <button onclick="window.location.href='register.php'">Register Now</button>
    </form>
</body>
</html>
