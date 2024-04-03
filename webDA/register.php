<html>

<head>
    <link rel="stylesheet" href="style/loginRegister.css">
    <title>Register</title>
</head>

<body>
    <?php
    //call file to connect server
    include("server.php");
    ?>

    <?php

    //This query inserts a record in the table
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $error = array(); //initialize an error array

        //check for userPassword
        if (empty($_POST['userPassword'])) {
            $error[] = 'You forgot to enter the password';
        } else {
            $p = mysqli_real_escape_string($connect, trim($_POST['userPassword']));
        }

        //check for userName
        if (empty($_POST['userName'])) {
            $error[] = 'You forgot to enter your name.';
        } else {
            $n = mysqli_real_escape_string($connect, trim($_POST['userName']));
        }

        //check for userPhoneNo
        if (empty($_POST['userPhoneNo'])) {
            $error[] = 'You forgot to enter your phone number.';
        } else {
            $ph = mysqli_real_escape_string($connect, trim($_POST['userPhoneNo']));
        }

        //check for userEmail
        if (empty($_POST['userEmail'])) {
            $error[] = 'You forgot to enter your email.';
        } else {
            $e = mysqli_real_escape_string($connect, trim($_POST['userEmail']));
        }

        //check for userBday
        if (empty($_POST['userBday'])) {
            $error[] = 'You forgot to enter your email.';
        } else {
            $bd = mysqli_real_escape_string($connect, trim($_POST['userBday']));
        }

        //default user not admin
        $ua = 'No';

        //register the user in the database
        $q = "INSERT INTO user (userID, userPassword, userName, userPhoneNo, userEmail, userBday, userAdmin)
            VALUES ('', '$p', '$n', '$ph', '$e', '$bd', '$ua')";
        $result = @mysqli_query($connect, $q); //run the query

        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            echo '<h1>System Error!</h1>';

            echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        }
        mysqli_close($connect);
        exit();
    }
    ?>


    <div class="main">
        <h1>Register User</h1>
        <h4>*required field</h4>
        <form action="register.php" method="POST">
            <div>
                <label for="userName">Name*:</label>
                <input type="text" id="userName" name="userName" size="30" maxlength="50" required value="<?php if (isset($_POST['userName']))
                                                                                                                echo $_POST['userName']; ?>">
            </div>

            <div>
                <label for="userPassword">Password*:</label>
                <input type="password" id="userPassword" name="userPassword" size="15" maxlength="60" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and
                    one uppercase and lowercase letter, and at least 8 or more characters" required value="<?php if (isset($_POST['userPassword']))
                                                                                                                echo $_POST['userPassword']; ?>">
            </div>

            <div>
                <label for="userPhoneNo">Phone Number*:</label>
                <input type="tel" pattern="[0-9]{3}-[0-9]{7,}" id="userPhoneNo" name="userPhoneNo" size="15" maxlength="20" required value="<?php if (isset($_POST['userPhoneNo']))
                                                                                                                                                echo $_POST['userPhoneNo']; ?>">
            </div>

            <div>
                <label for="userEmail">User Email*:</label>
                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="userEmail" name="userEmail" size="30" maxlength="50" required value="<?php if (isset($_POST['userEmail']))
                                                                                                                                                                    echo $_POST['userEmail']; ?>">
            </div>

            <div>
                <label for="userBday">User BirthDate*:</label>
                <input type="text" id="userBday" name="userBday" size="30" maxlength="50" required value="<?php if (isset($_POST['userBday']))
                                                                                                                echo $_POST['userBday']; ?>">
            </div>

            <div>
                <button type="submit">Register</button>
                <button type="reset">Clear All</button>
            </div>

            <div>
                <label>Have an account?
                    <a style="color: white;" href="login.php">Sign In</a>
                </label>
            </div>
        </form>
    </div>
</body>

</html>