<!DOCTYPE html>
<html>
    <head>
        <title>ContactUs: Student Attendance System</title>
        <style>
             .container{
                border-radius: 10px;
                background-color: rgba(0, 0, 0, 0.096);
                padding: 20px;
                align-content: center;
                text-align: center;
             }
             input[type=text], input[type=range]{
                margin-bottom: 20px;
                margin-left: 0px;
             }
        </style>
    </head>
    <body>
    <h1>Send Us Your Comments</h2>
    <p>Required fields marked with an asterisk *</p>

    <div class="container">
        <form action="/action_page.php">
        <label for="fname">*Name:</label>
        <input type="text" id="fname" name="fname" placeholder="your first and last name"><br>

        <label for="lname">*E-mail:</label>
        <input type="text" id="lname" name="lname" placeholder="you@yourdomain.com"><br>

        <label for="ratings">Rating(1-10):</label>
        <input type="range" id="ratings" name="ratings" min="1" max="10"><br>
        
        <label for="lname">*Comments:</label>
        <input type="text" id="comments" name="comments" placeholder="write something..." style="height: 60px;width: 200px"><br>
        <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>