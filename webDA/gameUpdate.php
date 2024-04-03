<?php
include("server.php");

// Look for a valid user id, either through GET or POST
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gameName = mysqli_real_escape_string($connect, $_POST['gameName']);
    $descript = mysqli_real_escape_string($connect, $_POST['descript']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $developer = mysqli_real_escape_string($connect, $_POST['developer']);
    $publisher = mysqli_real_escape_string($connect, $_POST['publisher']);
    $releasedDate = mysqli_real_escape_string($connect, $_POST['releasedDate']);

    // Update data in the database
    $q = "UPDATE gameCatalog SET 
        gameName='$gameName', 
        descript='$descript', 
        price='$price', 
        developer='$developer', 
        publisher='$publisher', 
        releasedDate='$releasedDate' 
        WHERE gameID='$id'";

    if (mysqli_query($connect, $q)) {
        echo '<script>alert("The user has been edited");
        window.location.href="gameList.php";</script>';
    } else {
        echo "Error: " . $q . "<br>" . mysqli_error($connect);
    }

    mysqli_close($connect);
} else {

?>

    <html>

    <head>
        <title>Update Game</title>
        <link rel="stylesheet" href="style/update.css">
    </head>


    <?php
    $q = "SELECT * FROM gameCatalog WHERE gameID=$id";
    $result = mysqli_query($connect, $q);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    ?>

        <body>
            <h2>Update Game</h2>
            <form action="gameUpdate.php" method="post" enctype="multipart/form-data">
                <label style="color: black;" for="gameName">Game Name:</label><br>
                <input type="text" id="gameName" name="gameName" required value="<?php echo $row['gameName'] ?>"><br>

                <label style="color: black;" for="descript">Description:</label><br>
                <textarea id="descript" name="descript" required><?php echo $row['descript'] ?></textarea><br>

                <label style="color: black;" for="price">Price:</label><br>
                <input type="text" id="price" name="price" required value="<?php echo $row['price'] ?>"><br>

                <label style="color: black;" for="developer">Developer:</label><br>
                <input type="text" id="developer" name="developer" required value="<?php echo $row['developer'] ?>"><br>

                <label style="color: black;" for="publisher">Publisher:</label><br>
                <input type="text" id="publisher" name="publisher" required value="<?php echo $row['publisher'] ?>"><br>

                <label style="color: black;" for="releasedDate">Released Date:</label><br>
                <input type="text" id="releasedDate" name="releasedDate" required value="<?php echo $row['releasedDate'] ?>"><br>

                <input type="hidden" name="id" value="<?php echo $id ?>">
                <input type="submit" value="Update Game">
            </form>
    <?php
    } else {
        echo '<p class="error">This page has been accessed in error.</p>';
    }
}
    ?>
        </body>

    </html>