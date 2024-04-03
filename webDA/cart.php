<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style/cart.css">
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

    // Initialize variables for price and total price
    $price = 0;
    $total = 0;

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
        <?php
        // Check if there are cart items
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $gameID = $row['gameID'];

                // Query to fetch details of the cart item
                $q_game = "SELECT * FROM gameCatalog WHERE gameID = $gameID";
                $result_game = mysqli_query($connect, $q_game);
                $row_game = mysqli_fetch_assoc($result_game);

                // Add the price of the item to the total
                $price += $row_game['price'];

                // Display the price of each item in the sidebar
        ?>
                <a href="gamePage.php?gi=<?php echo $row_game['gameID']; ?>&id=<?php echo $id; ?>">
                    <div class="item">
                        <img src="<?php echo $row_game['cover']; ?>" alt="<?php echo $row_game['gameName']; ?>">
                        <h3>
                            <?php echo $row_game['gameName']; ?>
                        </h3>
                        <p>
                            <?php
                            if ($row_game['price'] == 0) {
                                echo 'Free'; // If the price is 0, display "Free"
                            } else {
                                echo 'RM' . number_format($row_game['price'], 2); // If the price is not 0, display the price preceded by "RM"
                            }
                            ?>
                        </p>
                        <a href="cartDelete.php?id=<?php echo $id ?>&gi=<?php echo $row['gameID']; ?>">Remove</a>
                    </div>
                </a>
            <?php
            }
            ?>
            <div class="sidebar">
                <h2>Cart Summary</h2>
                <?php
                // Display total price in the sidebar
                ?>
                <p>Total: RM
                    <?php echo number_format($price, 2); ?>
                    <a href="cartPurchase.php?id=<?php echo $id ?>">GET</a>
                </p>
            </div>
        <?php
        } else {
        ?>
            <br>
            <h1>No items in your cart.</h1>
        <?php
        }
        ?>
    </div>
</body>

</html>