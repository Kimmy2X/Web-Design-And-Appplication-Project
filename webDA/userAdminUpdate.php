<html>

<head>
    <title>Management System</title>
    <link rel="stylesheet" href="style/update.css">
</head>

<body>
    <?php
    //connect to server
    include("server.php");
    ?>

    <h2>Edit User Record</h2>

    <?php
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
        $error = array(); //initialize an error array

        //check for username
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
            $error[] = print('You forgot to enter your birthdate.');
        } else {
            $bd = mysqli_real_escape_string($connect, trim($_POST['userBday']));
        }

        //check for userAdmin
        if (!isset($_POST['userAdmin']) || $_POST['userAdmin'] === '') {
            $error[] = 'You forgot to choose user admin status.';
        } else {
            $ua = mysqli_real_escape_string($connect, $_POST['userAdmin']);
        }

        //echo error messages
        foreach ($error as $msg) {
            echo "-$msg<br>\n";
        }

        //if no problem occured
        if (empty($error)) {
            $q = "SELECT userID FROM user WHERE userName= '$n' AND userID != $id";

            $result = @mysqli_query($connect, $q); //run the query

            if (mysqli_num_rows($result) == 0) {
                $q = "UPDATE user SET userName='$n', userPhoneNo='$ph', userEmail='$e', userBday='$bd', userAdmin='$ua'
                    WHERE userID='$id' LIMIT 1";

                $result = @mysqli_query($connect, $q); //run the query

                if (mysqli_affected_rows($connect) == 1) {
                    echo '<script>alert("The user has been edited");
                        window.location.href="userList.php";</script>';
                } else {
                    echo '<p class="error">The user has not been edited due to the system error.
                        We apologize for any inconvenience.</p>';
                    echo '<p>' . mysqli_error($connect) . '<br>query:' . $q . '</p>';
                }
            } else {
                echo '<p class="error">The id had been registered </p>';
            }
        } else {
            echo '<p class="error">The following error(s) occured: <br>';
            foreach ($error as $msg) {
                echo "-msg<br>\n";
            }
            echo '<p>Please try again.</p>';
        }
    }

    $q = "SELECT userName, userPhoneNo, userEmail, userBday, userAdmin
        FROM user WHERE userID=$id";

    $result = @mysqli_query($connect, $q); //run the query

    if (mysqli_num_rows($result) == 1) {

        //get admin information
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
    ?>
        <!-- create the form -->
        <form action="userAdminUpdate.php" method="POST">
            <p><label class="label" for="userName">User Name*:</label>
                <input type="text" id="userName" name="userName" size="30" maxlength="50" value="<?php echo $row[0] ?>">
            </p>

            <p><br><label class="label" for="userPhoneNo">User Phone No.*:</label>
                <input type="tel" pattern="[0-9]{3}-[0-9]{7,}" id="userPhoneNo" name="userPhoneNo" size="15" maxlength="20" value="<?php echo $row[1] ?>">
            </p>

            <p><br><label class="label" for="userEmail">User Email*:</label>
                <input type="text" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="userEmail" name="userEmail" size="30" maxlength="50" required value="<?php echo $row[2] ?>">
            </p>

            <p><br><label class="label" for="userBday">User BirthDate*:</label>
                <input type="text" id="userBday" name="userBday" size="30" maxlength="50" required value="<?php echo $row[3] ?>">
            </p>

            <p><br><label class="label" for="userAdmin">Is user Admin?:</label>
                <select name="userAdmin" id="userAdmin">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </p>

            <br>
            <p><input type="submit" id="submit" name="submit" value="Update"></p>
            <br><input type="hidden" name="id" value="<?php echo $id ?>" />

            </a>
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