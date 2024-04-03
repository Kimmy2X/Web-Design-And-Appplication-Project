<!DOCTYPE html>

<html>

<head>
    <title>Wishlist</title>
    <link rel="stylesheet" href="style/cart.css">
    <link rel="stylesheet" href="style/topnav.css">
</head>

<?php
//connect to server
include("server.php");
?>

<?php
// Check userID
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}
?>

<body>
    <!-- Navigation menu -->
    <div class="topnav">
        <a class="active" href="home.php?id=<?php echo $id ?>">Home</a>
        <a href="gameLibrary.php?id=<?php echo $id ?>">Game Library</a>
        <a class="active" style="float:right" href="userAccount.php?id=<?php echo $id ?>">Account</a>
        <a style="float:right" href="wishlist.php?id=<?php echo $id ?>">Wishlist</a>
        <a style="float:right" href="cart.php?id=<?php echo $id ?>">Cart</a>
        <form action="gameFound.php" method="post">
            <input type="text" placeholder="Search Game.." id="gameName" name="gameName" value="<?php if (isset($_POST['gameName'])) {
                                                                                                    echo $_POST['gameName'];
                                                                                                } ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <?php
    // Query to fetch wishlisted items for the user
    $q = "SELECT * FROM purchases WHERE userID = $id";
    $result = mysqli_query($connect, $q);

    // Check if there are wishlisted items
    if (mysqli_num_rows($result) > 0) {
    ?>



        <!-- Container to display wishlisted items -->
        <div class="container">
            <?php
            /* Loop through wishlisted items and display them */
            while ($row = mysqli_fetch_assoc($result)) {
                $gameID = $row['gameID'];

                /* Query to fetch details of the game */
                $q_game = "SELECT * FROM gameCatalog WHERE gameID = $gameID";
                $result_game = mysqli_query($connect, $q_game);
                $row_game = mysqli_fetch_assoc($result_game);
            ?>
                <!-- Display game details -->
                <a href="gamePage.php?gi=<?php echo $row_game['gameID']; ?>&id=<?php echo $id; ?>">
                    <div class="item">
                        <img src="<?php echo $row_game['cover']; ?>" alt="<?php echo $row_game['gameName']; ?>">
                        <h3>
                            <?php echo $row_game['gameName']; ?>
                        </h3>
                        <a href="#">Play</a>
                    </div>
                </a>
            <?php }
        } else { ?>


            <h1>No game in your library.</h1>
        <?php }

        // Close database connection
        mysqli_close($connect);
        ?>


</body>

</html>