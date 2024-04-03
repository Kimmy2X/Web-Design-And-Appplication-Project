<html>

<head>
    <title>Update User</title>
    <link rel="stylesheet" href="style/update.css">
</head>

<body>
    <?php
    //connect to server
    include("server.php");

    //initialize an error array
    $errors = [];

    //look for a valid user id, either through GET or POST
    if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
    } else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
        $id = $_POST['id'];
    } else {
        echo '<p class="error">This page has been accessed in error.</p>';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //check for username
        if (empty($_POST['userName'])) {
            $errors[] = 'You forgot to enter your name.';
        } else {
            $userName = mysqli_real_escape_string($connect, trim($_POST['userName']));
        }

        //check for userPhoneNo
        if (empty($_POST['userPhoneNo'])) {
            $errors[] = 'You forgot to enter your phone number.';
        } else {
            $userPhoneNo = mysqli_real_escape_string($connect, trim($_POST['userPhoneNo']));
        }

        //check for userEmail
        if (empty($_POST['userEmail'])) {
            $errors[] = 'You forgot to enter your email.';
        } else {
            $userEmail = mysqli_real_escape_string($connect, trim($_POST['userEmail']));
        }

        //check for an userBday
        if (empty($_POST['userBday'])) {
            $errors[] = 'You forgot to enter your birthdate.';
        } else {
            $userBday = mysqli_real_escape_string($connect, trim($_POST['userBday']));
        }

        $userAdmin = 'No';

        //if no problem occurred
        if (empty($errors)) {
            $query = "UPDATE user SET userName='$userName', userPhoneNo='$userPhoneNo', userEmail='$userEmail', userBday='$userBday', userAdmin='$userAdmin' WHERE userID='$id'";

            $result = mysqli_query($connect, $query);

            if ($result) {
                echo '<script>alert("The user has been edited");
                        window.location.href="userAccount.php?id=' . $id . '";</script>';
                exit(); // Exit to prevent further execution
            } else {
                echo '<p class="error">The user has not been edited due to a system error. We apologize for any inconvenience.</p>';
                echo '<p>' . mysqli_error($connect) . '<br>query:' . $query . '</p>';
            }
        } else {
            // Display error messages
            echo '<p class="error">The following error(s) occurred: <br>';
            foreach ($errors as $msg) {
                echo "- $msg<br>";
            }
            echo 'Please try again.</p>';
        }
    }

    $query = "SELECT * FROM user WHERE userID=$id";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    ?>
        <!-- create the form -->
        <h2>Edit User</h2>
        <form action="userUpdate.php" method="POST">
            <label class="label" for="userName">Username*:</label><br>
            <input type="text" id="userName" name="userName" size="30" maxlength="50" value="<?php echo $row['userName'] ?>" required><br>

            <label class="label" for="userPhoneNo">User Phone No.*:</label><br>
            <input type="tel" pattern="[0-9]{3}-[0-9]{7,}" id="userPhoneNo" name="userPhoneNo" size="15" maxlength="20" value="<?php echo $row['userPhoneNo'] ?>" required><br>

            <label class="label" for="userEmail">User Email*:</label><br>
            <input type="email" id="userEmail" name="userEmail" size="30" maxlength="50" value="<?php echo $row['userEmail'] ?>" required><br>

            <label class="label" for="userBday">User BirthDate*:</label><br>
            <input type="text" id="userBday" name="userBday" size="30" maxlength="50" required value="<?php echo $row['userBday'] ?>"><br>

            <input type="submit" id="submit" name="submit" value="Update">
            <input type="hidden" name="id" value="<?php echo $id ?>">
        </form>
    <?php
    } else {
        //if it didn't run
        echo '<p class="error">This page has been accessed in error</p>';
    }
    mysqli_close($connect);
    ?>
</body>

</html>