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
    <title>Student Attendance System</title>
    <link rel="stylesheet" href="styleHome.css">
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
                        // Check if the user is logged in
                        if (isset($_SESSION['user_id'])) {
                            echo '<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>';
                        } else {
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
        <section class="content">
        <section class="htu">
            <h1><i class="fa fa-lightbulb-o" style="font-size: 25px"></i> User Guide</h1>
            <section class="htu-content">
            <h4>Step 1: On the top left hand side of the homepage, click the <b>menu button</b> <i class="fas fa-bars" style="font-size: 18px"></i> .</h4>
            <h4>Step 2: Then, click "<b>Attendance</b>".</h4>
            <h4>Step 3: Use your device to <b>scan the QR code</b> and take your attendance.</h4>
            <h4>Step 4: Check the attendance status in the attendance list below the page.</h4>
            </section>
            <iframe allow="fullscreen;" width="570" height="330" src="https://www.youtube.com/embed/Y03DlrEyVvs?autoplay=1&mute=0">
            </iframe>
        </section>

        <div class="announcement">
        <section class="acctotal">
        <section class="acc1">
                <h3>Graduation Ceremony Opened!</h3>
                <h5>* Only for Graduated Student 2023.</h5>
                <h5>* Date: 16th DEC 2023 (Saturday)</h5>
                <h5>* Time: 9.00 am - 1.00 pm</h5>
                <h5>* Venue: Chen Jiageng Memorial Hall</h5>
        </section>
        <section class="acc2">
                <h3>Scholarships and study grants available!</h3>    
                <h5>* For Undergraduate Programmes Only.</h5>      
                <h5>* 1st Batch: 2nd JAN until 31st JAN 2024</h5>
                <h5>* 2nd Batch: 1st FEB until 28th FEB 2024</h5>
                <h5>* Apply online at <a href="https://www.ptptn.gov.my/ionline/#/login"> https//www.ptptn.gov.my/ionline</a></h5>

        </section>
        <section class="acc3">
            <h3>Campus Career Fair 2023 Upcoming!</h3>
            <h5>"INTERNSHIP" & "JOB PLACEMENT", explore opportunities with LEADING COMPANIES!</h5>
            <h5>* Date : 29th NOV 2023 (Wednesday)</h5>
            <h5>* Time : 10.00 am - 4.00 pm</h5>
            <h5>* Venue : Block A3 - G Floor</h5>
        </section>
        <section class="acc4">
            <h3>Student Helpers Required For IT Department</h3>
            <h5>* XMUM IT department is recruiting for student helpers soon, up to 5 new vacancies is available.</h5>
            <h5>* To know more details, please refer to this file: <a href="Student Helpers for IT Department.pdf" download>Student Helper for IT.pdf</a></h5>
            <h5>* For interested candidates, please submit your resume to IT by <mark style="color:red;">25th DEC 2023(Friday)</mark>.</h5>
        </section>
        <section class="acc5">
            <h3>Blood Angel 3.0 Event Day!</h3>
            <h5>Here is a collaborative blood donation campaign brought to you!!</h5>
            <h5>* Date : 1st NOV 2023 (Wednesday)</h5>
            <h5>* Time : 10.00 am - 4.00 pm</h5>
            <h5>* Venue: B1 Old Library</h5>
        </section>
        </section>
        </div>

        </section>
        <section class="rules">
            <h1>Why Attendance is Important?</h1>
            <h4>
            <ul>
                <li>The <b>minimum attendance</b> requirement for each course is <b>80%</b>. Students who <b>fail to meet this requirement</b> without valid reasons accepted by the university or without prior permission from the Academic Affairs Office will <b>be barred from taking the final examination</b> for that course.</li>
                <li>Students who have been barred from sitting for a final examination in any course will receive a <b>Grade F</b>. They may ><b>need to retake the course</b>.</li>
                <li>Students are required to ensure attendance in all assessment components, and <b>any absences must be reported immediately</b> to the respective lecturer for consideration. </li>
                <li>Students are reminded <b>to be punctual</b> for lessons and all other learning activities. Late admission and attendance are at the discretion of the lecturer.</li>
                <li>It is the responsibility of students to ensure that their attendance is propoerly recorded.</li>
            </ul>
            </h4>
        </section> 
        <script>
        //clock
        function updateClock() {
                var now = new Date();
                var date = now.toLocaleDateString();
                var time = now.toLocaleTimeString();
                document.getElementById('date-time').innerHTML = '<i class="fas fa-clock"></i> ' +  time;
            }

            // Update the clock every second
            setInterval(updateClock, 1000);
        </script>
        <footer>
            <p>&copy; 2023 Student Attendance System. All rights reserved.</p>
        </footer>
    </div>

</body>

</html>