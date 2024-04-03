<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="style/loginRegister.css">
</head>

<?php
//call file to connect server eleave
include("server.php");
?>

<?php
//Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //validate the userEmail
    if (!empty($_POST['userEmail'])) {
        $e = mysqli_real_escape_string($connect, $_POST['userEmail']);
    } else {
        $e = FALSE;
        echo '<p class = "error"> You forgot to enter your ID.</p>';
    }
    //validate the userPassword
    if (!empty($_POST['userPassword'])) {
        $p = mysqli_real_escape_string($connect, $_POST['userPassword']);
    } else {
        $p = FALSE;
        echo '<p class="error"> You forgot to enter your password.</p>';
    }

    //if no problem
    if ($e && $p) {
        $q = "SELECT userID, userPassword, userName, userPhoneNo, userEmail, userBday, userAdmin
            FROM user WHERE (userEmail='$e' AND userPassword='$p')";

        $result = mysqli_query($connect, $q);

        if (@mysqli_num_rows($result) == 1) {
            session_start();

            $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
            //get userID
            $id = $_SESSION['userID'];
            header("Location: userAdmin.php?id=$id");

            exit();

            mysqli_free_result($result);
            mysqli_close($connect);
        } else {
            echo '<script>alert("The userEmail and userPassword entered do not match our records
            <br> perhaps you need to register, just click the Register button");
            window.location.href="login.php";</script>';
        }
    } else {
        echo '<script>alert(" Please try again. ");
        window.location.href="login.php";</script>';
    }
    mysqli_connect($connect);
}
?>

<body>
    <div class="main">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <div>
                <label for="userEmail">User Email:</label>
                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="userEmail" name="userEmail" size="30" maxlength="50" required value="<?php if (isset($_POST['userEmail']))
                                                                                                                                                                    echo $_POST['userEmail']; ?>">
            </div>

            <div>
                <label for="userPassword">Password:</label>
                <input type="password" id="userPassword" name="userPassword" size="15" maxlength="60" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and
                one uppercase and lowercase letter, and at least 8 or more characters" required value="<?php if (isset($_POST['userPassword']))
                                                                                                            echo $_POST['userPassword']; ?>">
            </div>

            <div>
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </div>

            <div>
                <label>Don't have an account?
                    <a style="color: white;" href="register.php">Sign Up</a>
                </label>
            </div>
        </form>
    </div>
</body>

</html>