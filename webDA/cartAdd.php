<?php
// Connect to server
include("server.php");

// Check gameID
if (isset($_GET['gi']) && is_numeric($_GET['gi'])) {
    $gi = $_GET['gi'];
} else if (isset($_POST['gi']) && is_numeric($_POST['gi'])) {
    $gi = $_POST['gi'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Check userID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Check if the user has already purchased the item
$purchaseQuery = "SELECT * FROM purchases WHERE userID = $id AND gameID = $gi";
$purchaseResult = mysqli_query($connect, $purchaseQuery);

if (mysqli_num_rows($purchaseResult) > 0) {
    // User already has the item purchased, display an error message
    echo '<script>alert("You have already purchased this item.");
    window.location.href="gamePage.php?id=' . $id . '&gi=' . $gi . '";</script>';
    exit();
}

// Check if the user already has the item in cart
$cartQuery = "SELECT * FROM cart WHERE userID = $id AND gameID = $gi";
$cartResult = mysqli_query($connect, $cartQuery);

if (mysqli_num_rows($cartResult) > 0) {
    // User already has the item in cart display an error message
    echo '<script>alert("This item is already in your cart.");
    window.location.href="gamePage.php?id=' . $id . '&gi=' . $gi . '";</script>';
    exit();
}

// User does not have the item wishlisted or purchased, add it to the cart
$q = "INSERT INTO cart (userID, gameID) VALUES ($id, $gi)";

if (mysqli_query($connect, $q)) {
    echo '<script>alert("New game added to the cart successfully!");
    window.location.href="gamePage.php?id=' . $id . '&gi=' . $gi . '";</script>';
} else {
    echo "Error inserting into cart: " . mysqli_error($connect);
}

mysqli_close($connect);
