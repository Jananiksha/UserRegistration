<?php

$host = "localhost";
$db = "user_registration";
$user = "root";
$pass = "";

$connection = mysqli_connect($host, $user, $pass, $db);

if (mysqli_connect_errno()) {
    die("Failed to connect to the database: " . mysqli_connect\_error());
}


if (isset($_POST['submit'])) {
  
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    if (!empty($username) && !empty($email) && !empty($password)) {
       
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 0) {
       
            $hashed_password = password\_hash($password, PASSWORD\_DEFAULT);

            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

            if (mysqli_query($connection, $query)) {
                echo "You have been registered successfully!";
            } else {
                echo "Error: " . mysqli\_error($connection);
            }
        } else {
            echo "That email is already in use.";
        }
    } else {
        echo "All fields are required.";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h1>Register</h1>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email"><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password"><br>

        <input type="submit" name="submit" value="Register">
    </form>
</body>
</html>
