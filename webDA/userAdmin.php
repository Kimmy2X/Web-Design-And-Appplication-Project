<?php
//call file to connect server
include("server.php");

// Check if id is set and numeric in either GET or POST
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

if ($id) {
    // Retrieve userAdmin
    $q = "SELECT userAdmin FROM user WHERE userID=$id";

    $result = mysqli_query($connect, $q);

    //get userID
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $ua = $row['userAdmin'];

    if ($ua == 'Yes') {
        //start the session
        session_start();

        $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
        header("Location: adminConsole.html");

        exit();

        mysqli_free_result($result);
        mysqli_close($connect);
        //no match was made
    } else {
        header("Location: home.php?id=$id");
    }
}
//if there was a problem
else {
    echo '<p class = "error"> Please try again. </p>';
}
mysqli_connect($connect);
