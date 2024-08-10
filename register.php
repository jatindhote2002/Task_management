<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<form method="POST" action="register.php">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email']; // Ensure email is captured
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    // Check if the username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "Username or email already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $password_hash]);
        
        // Redirect to login page or show a success message
        header("Location: login.php");
        exit;
    }
}
?>


    <label>Username:</label>
    <input type="text" name="username" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <input type="submit" value="Register">
</form>

</body>
<style>
    /* style.css */
body {
    background-color: #333;
    color: #fff;
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
    background-color: #ff4c4c; /* Bright red background */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    width: 300px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
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
    padding: 10px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 18px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #555;
}

</style>
</html>
