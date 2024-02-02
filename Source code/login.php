<?php
require_once 'db_config.php';
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $connection->prepare("SELECT id, username, password_hash FROM users WHERE username = ?");
    if ($stmt === false) {
        die('Error in preparing statement: ' . $connection->error);
    }
    $stmt->bind_param("s", $username);

    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $dbUsername, $dbPassword);
        $stmt->fetch();

        if (password_verify($password, $dbPassword)) {
            session_start();
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $dbUsername;

            header('Location: Attendance.php');
            exit();
        } else {
            $error_message='Invalid username or password.';
        }
    } else {
        $error_message='Username not exists.';
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
    <div class=login>
    <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" placeholder="Username" name="username"/>
            <input type="password" placeholder="Password" name="password" />
            <button type="submit" value="Submit">Submit</button>
            <p>Haven't register?<a href="registration.php">Click here.</a></p>
        </form>
        <?php
        if (!empty($error_message)) {
            echo '<p style="color: red;">' . $error_message . '</p>';
        }
        ?>
    </div>
</body>
<footer>
            <p>&copy; 2023 Student Attendance System. All rights reserved.</p>
</footer>
</html>