<?php
    ob_start();
    session_start();
    require_once 'db_config.php';
    // Check if the user is logged in
    ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleAttendance.css">
    <title>Student Attendance System</title>
    <script src="https://kit.fontawesome.com/bdc497c85f.js"></script>
</head>

<body>
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fas fa-bars" id="btn"></i>
        <i class="fas fa-times" id="cancel"></i>
    </label>
    <div class="sidebar">
        <header>Menu</header>
        <ul>
            <li><a href="Home.php"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fa fa-calendar"></i>Calendar</a></li>
            <li><a href="Attendance.php"><i class="fas fa-qrcode"></i>Attendance</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>Contact Us</a></li>
        </ul>
    </div>

    <div class="main">
        <div class="headbar">
            <div class="headbarLogo">
                <img src="logo.png" alt="logoImage">
            </div>
            <div class="searchbox">
                <input type="text" placeholder="Search...">
                <a href="#">
                    <i class="fas fa-search"></i>
                </a>
            </div>
            <div class="Headbaricons">
                <div class="dropdown">
                    <i class="fas fa-user-circle" id="userDropdownBtn" style="font-size: 33px; color: white;"></i>
                    <div class="dropdown-content">
                    <?php
                        if (isset($_SESSION['user_id'])) {
                        echo '<a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>';
                        }else {
                        echo '<a href="login.php"><i class="fas fa-sign-in-alt"></i>Login</a>';
                        echo '<a href="registration.php"><i class="fas fa-id-card"></i>Register</a>';
                    }
                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!--clock-->
        <div class="clock-container">
            <p id="date-time"></p>
        </div>

        <div class="generator-report-container">
            <div class="container">
                <div class="header">
                    <h1>Attendance QR Code Generator</h1>
                </div>
                <div class="container-content">
                    <div class="input-form">
                        <p>Enter Course Code:<input type="text" class="qr-input" placeholder="e.g CST307"></p>
                        <button class="generate-btn">Generate QR Code</button>
                    </div>
                    <div class="qr-code">
                        <img src="image/qrcode.png" class="qr-image">
                        <div class="qr-expiry-text" style="display: none;">
                            <h5>This QR code is not valid after 3 minutes.</h5>
                        </div>
                    </div>
                </div><!--.container-content-->
            </div><!--.container-->

            <div class="chart-container">
                <h2>Weekly Report</h2>
                <div class="pieclass">
                    <div class="pie1">
                        <div class="pie animate" style="--p:80;--c:lightgreen">80%</div>
                        <p>Present</p>
                    </div>
                    <div class="pie2">
                        <div class="pie animate" style="--p:15;--c:orange">15%</div>
                        <p>Late</p>
                    </div>
                    <div class="pie3">
                        <div class="pie animate" style="--p:5;--c:red">5%</div>
                        <p>Absent</p>
                    </div>
                </div>
            </div>
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

            var container = document.querySelector(".container");
            var generateBtn = document.querySelector(".generate-btn");
            var qrInput = document.querySelector(".qr-input");
            var qrImg = document.querySelector(".qr-image");

            generateBtn.onclick = function() {
                if (qrInput.value.length > 0) {
                    fetch('check_login.php')
                        .then(response => response.json())
                        .then(data => {
                            if (data.loggedIn) {
                                generateQRCode();
                            } else {
                                alert('User not logged in. Please log in first.');
                            }
                        })
                        .catch(error => console.error('Error checking login:', error));
                }
            }
            
            qrImg.onclick = function() {
                var url = "sign.php?class_code=" + encodeURIComponent(qrInput.value);
                window.location.href = url;
            }

            function generateQRCode() {
                generateBtn.innerText = "Generating QR Code...";
                qrImg.src = "https://api.qrserver.com/v1/create-qr-code/?size=170x170&data=" + "https://studentattendancesystemcst2104044.000webhostapp.com/sign.php?class_code=" + qrInput.value;

                qrImg.onload = function() {
                    container.classList.add("active");
                    generateBtn.innerText = "QR Code Generated Successfully!";

                    // Show the QR expiry text
                    document.querySelector(".qr-expiry-text").style.display = "block";
                };
            }
            function scanQRCode() {
                const scanner = new Instascan.Scanner({
                    video: video
                });
                scanner.addListener("scan", function(content) {
                    const scanner = new Instascan.Scanner({
                    video: video
                });
                });

                Instascan.Camera.getCameras()
                    .then(function(cameras) {
                        if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            console.error("No cameras found.");
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }
            scanQRCode();
        </script>
        <div class="attendance">
            <h1>Student Attendance List</h1>
            <form method="POST">
                <h3>Please select a date: <input type="date" name="myDate" id="myDate" value="<?php echo isset($_POST['myDate']) ? $_POST['myDate'] : 'default'; ?>"><button type="submit">Filter</button></h3>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Class Code</th> 
                        <th>Date</th>
                        <th>Scan time</th>
                        <th>Attendance Status</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once 'db_config.php';

                    //Filter by data if a date is selected
                    $dateFilter = "";
                    if (isset($_POST['myDate'])) {
                        $selectedDate = date("Y-m-d", strtotime($_POST['myDate']));
                        $dateFilter = "WHERE date = ?";
                    }

                    //read all row from database table
                    $sql = "SELECT * FROM attendance JOIN students ON attendance.studentID = students.studentID $dateFilter";

                    $stmt = $connection->prepare($sql);


                    if (!$stmt) {
                        die("Error in preparing statement: " . $connection->error);
                    }

                    if (isset($_POST['myDate'])) {
                        $stmt->bind_param("s", $selectedDate);
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }

                    //read data of each row
                    if ($result->num_rows === 0) {
                        echo "<tr><td colspan='7'>No class for the selected date</td></tr>";
                    } else {
                        while ($row = $result->fetch_assoc()) {

                            echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["studentID"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["class_code"] . "</td>
                        <td>" . $row["DATE"] . "</td>
                        <td>" . $row["scan_time"] . "</td>
                        <td>" . "Present" . "</td>
                        <td>" . $row["email"] . "</td>
                    </tr>";
                        }
                    }
                    $stmt->close();

                    ?>
                </tbody>
            </table>
        </div>
    <footer>
        <p>&copy; 2023 Student Attendance System. All rights reserved.</p>
    </footer>
    </div>
</body>

</html>