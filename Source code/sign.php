<?php
require_once 'db_config.php';
$class_code = $_GET['class_code'];
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    $stmt = $connection->prepare("SELECT studentID FROM students WHERE studentID = ?");
    $stmt->bind_param("s", $student_id);

    $stmt->execute();
    $stmt->store_result();

    $stmt2 = $connection->prepare("SELECT class_code FROM classes WHERE class_code = ?");
    $stmt2->bind_param("s", $class_code);

    $stmt2->execute();
    $stmt2->store_result();

    if ($stmt->num_rows > 0 && $stmt2->num_rows > 0) {
        $stmt = $connection->prepare("INSERT INTO attendance (studentID, class_code) VALUES (?, ?)");
        if ($stmt === false) {
            die('Error in preparing statement: ' . $connection->error);
        }
        $studentID = ucwords($student_id);
        $classCode = ucwords($class_code);
        $stmt->bind_param("ss", $studentID, $classCode);
        if ($stmt->execute()) {
            header('Location: Attendance.php');
            exit();
        } else {
            echo $stmt->error;
            $error_message = 'Failed. Please try again.';
        }
    } else {
        $error_message = 'Wrong student ID or class code.';
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
        <h1>Attendance Form</h1>
        <input type="text" placeholder="Student ID" name="student_id" />
        <button type="submit" value="Submit">Submit</button>
        <?php
        if (!empty($error_message)) {
            echo '<p style="color: red;">' . $error_message . '</p>';
        }
        ?>
    </form>
</body>
<footer>
            <p>&copy; 2023 Student Attendance System. All rights reserved.</p>
</footer>
</html>