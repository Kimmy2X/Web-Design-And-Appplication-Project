<!DOCTYPE html>
<html>

<head>
    <title>Purchase Cart</title>
    <link rel="stylesheet" href="style/cartPurchased.css">
    <link rel="stylesheet" href="style/topnav.css">
</head>

<body>
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

    // Query to fetch cart items for the user
    $q = "SELECT * FROM cart WHERE userID = $id";
    $result = mysqli_query($connect, $q);

    // Initialize variables for total price
    $price = 0;

    ?>
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

    <!-- Container to display cart items -->
    <div class="container">
        <!-- Message and form for submitting proof of purchase -->
        <p>Please submit proof of purchase to access this game.</p>
        <img src="images/qr.jpg" height="500px" width="500px">
        <form action="submitProofCart.php" method="post" enctype="multipart/form-data">
            <label for="proof">Submit Proof:</label>
            <input type="file" id="proof" name="proof" required><br>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Submit">
        </form>

        <!-- Sidebar for displaying cart summary -->
        <div class="sidebar">
            <h2>Cart Summary</h2>
            <?php
            // Check if there are items in the cart
            if (mysqli_num_rows($result) > 0) {
                // Loop through cart items
                while ($row = mysqli_fetch_assoc($result)) {
                    $gameID = $row['gameID'];
                    // Query to fetch game details
                    $q_game = "SELECT * FROM gameCatalog WHERE gameID = $gameID";
                    $result_game = mysqli_query($connect, $q_game);
                    $row_game = mysqli_fetch_assoc($result_game);
                    // Calculate total price
                    $price += $row_game['price'];
            ?>
                    <!-- Display cart item -->
                    <div class="item">
                        <h3>
                            <?php echo $row_game['gameName']; ?>
                        </h3>
                        <p>
                            <?php
                            // Display price
                            if ($row_game['price'] == 0) {
                                echo 'Free';
                            } else {
                                echo 'RM' . number_format($row_game['price'], 2) . ' +';
                            }
                            ?>
                        </p>
                    </div>
                <?php
                }
                ?>
                <!-- Display total price -->
                <hr>
                <p>Total: RM
                    <?php echo number_format($price, 2); ?>
                </p>
        </div>
    <?php
            } else {
                // If cart is empty, display a message
                echo '<script>alert("New game added to wishlist successfully!");
                window.location.href="cart.php?id=' . $id . '";</script>';
            }
    ?>
    </div>
</body>

</html>