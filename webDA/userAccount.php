<?php
//connect server
include("server.php");
?>

<?php
//check userID
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

//Get user Info
$q = "SELECT userID, userName, userPhoneNo, userEmail, userBday
    FROM user WHERE userID = $id";

//run the query and assign it to the variable $result
$result = @mysqli_query($connect, $q);

if ($result) {
    //fetch
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

    <head>
        <link rel="stylesheet" href="style/topnav.css">
        <link rel="stylesheet" href="style/account.css">
        <title>User Account</title>
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

        <!-- HTML to display user info -->
        <div class="info">
            <h2>User Information</h2>
            <p><strong>Username:</strong>
                <?php echo $row['userName']; ?>
            </p>
            <p><strong>Phone Number:</strong>
                <?php echo $row['userPhoneNo']; ?>
            </p>
            <p><strong>Email:</strong>
                <?php echo $row['userEmail']; ?>
            </p>
            <p><strong>Birthday:</strong>
                <?php echo $row['userBday']; ?>
            </p>
            <a href="userUpdate.php?id=<?php echo $row['userID']; ?>">Update</a>
            <a href="login.php">Logout</a>
        </div>
    </body>

<?php
} else {
    //error message
    echo '<p class="error">The current user could not be retrieved.
        We apologize for any inconvenience.</p>';

    //debugging message
    echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
} //end of if($result)
//close the database connection
mysqli_close($connect);
?>