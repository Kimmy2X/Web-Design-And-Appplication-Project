<?php
/* Connect Server */
include("server.php");

// Function to check if the user has purchased the game
function hasPurchased($connect, $gi, $id)
{
    $query = "SELECT * FROM purchases WHERE gameID = $gi AND userID = $id";
    $result = mysqli_query($connect, $query);
    return mysqli_num_rows($result) > 0;
}

// Check gameID
if ((isset($_GET['gi'])) && (is_numeric($_GET['gi']))) {
    $gi = $_GET['gi'];
} else if ((isset($_POST['gi'])) && (is_numeric($_POST['gi']))) {
    $gi = $_POST['gi'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Check userID
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// If the user has purchased the game, continue displaying game details
$q = "SELECT * FROM gameCatalog WHERE gameID = $gi";

// Run the query and assign it to the variable $result
$result = @mysqli_query($connect, $q);

if ($result) {
    // Fetch
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

    <head>
        <link rel="stylesheet" href="style/topnav.css">
        <link rel="stylesheet" href="style/purchased.css">
        <title>Purchase
            <?php echo $row['gameName']; ?>
        </title>
    </head>

    <body>
        <!-- Navigation Bar -->
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

        <div class="container">
            <?php
            // Check if the user has purchased the game
            if (!hasPurchased($connect, $gi, $id)) {
            ?>
                <p>Please submit proof of purchase to access this game.</p>

                <img src="images/qr.jpg" height="500px" width="500px">

                <form action="submitProof.php" method="post" enctype="multipart/form-data">
                    <label for="proof">Submit Proof:</label>
                    <input type="file" id="proof" name="proof" required><br>
                    <input type="hidden" name="gi" value="<?php echo $gi; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" value="Submit">
                </form>

                <div class="details">
                    <center>
                        <div class="img" style="padding-top: 10px; border: 1px white;">
                            <img src="<?php echo $row['cover']; ?>" height="auto" width="70%">
                        </div>
                        <!-- Price -->
                        <p style="position: right;">
                            <?php
                            if ($row['price'] == 0) {
                                echo 'FREE';
                            } else {
                                echo 'RM' . $row['price'];
                            }
                            ?>
                        </p>
                        <!-- Game Information -->
                        <div class="info" style="height: 300px;">
                            <hr>
                            <p>Developer:
                                <?php echo $row['developer']; ?>
                            </p>
                            <hr>
                            <p>Publisher:
                                <?php echo $row['publisher']; ?>
                            </p>
                            <hr>
                            <p>Released Date:
                                <?php echo $row['releasedDate']; ?>
                            </p>
                        </div>
                    </center>
                </div>
            <?php
                exit();
            } else {
                // Display a pop-up window indicating the game has been purchased
                echo '<script>alert("You already purchased the game!");
                window.location.href="gamePage.php?id=' . $id . '&gi=' . $gi . '";</script>';
            }
            ?>
        </div>
    </body>
<?php
} else {
    // Error message
    echo '<p class="error">The current user could not be retrieved. We apologize for any inconvenience.</p>';
    // Debugging message
    echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
}
// Close the database connection
mysqli_close($connect);
?>