<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $student_id = $_POST['student_id'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("INSERT INTO students (studentID, name, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $student_id, $student_name, $email);
    $stmt->execute();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $connection->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        echo '<p style="color: red;">Registration failed. Please try again.</p>';
    }

    $stmt->close();
}

$connection->close();
?>

<html>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login:Student Attendance System</title>
    <link rel="stylesheet" href="stylelogin.css">
    <script src="https://kit.fontawesome.com/bdc497c85f.js"></script>
</head>

<body>
    <div class="headbar">
            <div class="headbarLogo">
                <img src="logo.png" alt="logoImage">
            </div>
    </div>
        <!--clock-->
        <div class="clock-container">
        <p id="date-time"></p>
    </div>
    <script>
            //clock
            function updateClock() {
                var now = new Date();
                var date = now.toLocaleDateString();
                var time = now.toLocaleTimeString();
                document.getElementById('date-time').innerHTML = '<i class="fas fa-clock"></i> ' + time;
            }

            // Update the clock every second
            setInterval(updateClock, 1000);
    </script>
    <form class="login" method="POST" action="">
        <h1>Registration</h1>        
        <input type="text" placeholder="Student ID" name="student_id" />
        <input type="text" placeholder="Student Name" name="student_name" />
        <input type="text" placeholder="Email" name="email" />
        <input type="text" placeholder="Username" name="username" />
        <input type="password" placeholder="Password" name="password" />
        <button type="submit" value="Submit">Submit</button>
        <p>Already have an account?<a href="login.php">Chick here to login.</a></p>
    </form>
</body>
<footer>
            <p>&copy; 2023 Student Attendance System. All rights reserved.</p>
</footer>
</html>