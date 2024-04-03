<?php
// Connect to server
include("server.php");

// Check gameID
if (isset($_GET['gi']) && is_numeric($_GET['gi'])) {
    $gi = $_GET['gi'];
} else if ((isset($_POST['gi'])) && (is_numeric($_POST['gi']))) {
    $id = $_POST['gi'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Check userID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

// Delete item from cart
$q_delete = "DELETE FROM cart WHERE userID = $id AND gameID = $gi";

if (mysqli_query($connect, $q_delete)) {
    echo '<script>alert("Item removed from cart successfully!");
    window.location.href="cart.php?id=' . $id . '";</script>';
} else {
    echo "Error deleting item from cart: " . mysqli_error($connect);
}

mysqli_close($connect);
