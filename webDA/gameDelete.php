<html>

<head>
    <title>Delete Game</title>
</head>

<body>
    <?php
    //connect to server
    include("server.php");
    ?>

    <h2>Delete Game Record</h2>

    <?php
    // Check the gameID 
    if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
        $id = $_GET['id'];
    } else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
        $id = $_POST['id'];
    } else {
        echo '<p class="error">This page has been accessed in error.</p>';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['sure'] == 'Yes') {
            $q = "DELETE FROM gameCatalog WHERE gameID=$id LIMIT 1";
            $result = @mysqli_query($connect, $q);

            if (mysqli_affected_rows($connect) == 1) {
                echo '<script>alert("The game has been deleted");
                    window.location.href="gameList.php";</script>';
            } else {
                echo '<p class="error">The record could not be deleted.<br>
                    Probably because it does not exist or due to a system error.</p>';

                echo '<p>' . mysqli_error($connect) . '<br> Query:' . $q . '</p>';
            }
        } else {
            echo '<script> alert("The game has NOT been deleted");
                window.location.href="gameList.php";</script>';
        }
    } else {
        $q = "SELECT gameName FROM gameCatalog WHERE gameID=$id";
        $result = @mysqli_query($connect, $q);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo "<h3>Are you sure want to permanently delete $row[0]? </h3>";
            echo '<form action="gameDelete.php" method="POST">
                <input type="submit" id="submit-no" name="sure" value="Yes">
                <input type="submit" id="submit-no" name="sure" value="No">
                <input type="hidden" name="id" value="' . $id . '">
                </form>';
        } else {
            echo '<p class="error">This page has been accessed in error.</p>';
            echo '<p>$nbsp</p>';
        }
    }

    // Close the database connection
    mysqli_close($connect);
    ?>
</body>

</html>