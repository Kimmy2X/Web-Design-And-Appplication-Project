<?php
//call file to connect server
include("server.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $gameName = $_POST["gameName"];

    $q = "SELECT gameID FROM gameCatalog WHERE gameName = '$gameName'";

    //run the query and assign it to the variable $result
    $result = mysqli_query($connect, $q);

    if ($result) {
        //check if any row is returned
        if (mysqli_num_rows($result) > 0) {
            //fetch
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $gi = $row['gameID'];

            //redirect to game page
            header("Location: gamePage.php?id=$id&gi=$gi");
            exit();
        } else {
            //gameID not found, redirect to login page with error message
            header("Location: home.php?error=gameNotFound");
            exit();
        }
    } else {
        //query execution failed
        echo "Error: " . mysqli_error($connect);
    }
}
