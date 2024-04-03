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

// Function to remove the game from the user's cart
function removeFromCart($connect, $gi, $id)
{
    $query = "DELETE FROM cart WHERE gameID = $gi AND userID = $id";
    mysqli_query($connect, $query);
}

// Function to remove the game from the user's wishlist
function removeFromWishlist($connect, $gi, $id)
{
    $query = "DELETE FROM wishlist WHERE gameID = $gi AND userID = $id";
    mysqli_query($connect, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES['proof']) && isset($_POST['gi']) && isset($_POST['id'])) {
        $gi = $_POST['gi'];
        $id = $_POST['id'];


        if (!hasPurchased($connect, $gi, $id)) {

            $file_name = $_FILES['proof']['name'];
            $file_tmp = $_FILES['proof']['tmp_name'];
            $file_type = $_FILES['proof']['type'];


            $target_dir = "proofs/";


            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if (strtolower($file_extension) === 'pdf') {

                if (move_uploaded_file($file_tmp, $target_dir . $file_name)) {

                    $proof_path = $target_dir . $file_name;

                    $query = "INSERT INTO purchases (userID, gameID, proofOfPurchase) VALUES ($id, $gi, '$proof_path')";
                    $result = mysqli_query($connect, $query);

                    if ($result) {
                        removeFromCart($connect, $gi, $id);
                        removeFromWishlist($connect, $gi, $id);

                        header("Location: home.php?id=$id&success=true");
                        exit();
                    } else {
                        echo "<p>Error: Unable to submit proof of purchase. Please try again later.</p>";
                    }
                } else {
                    echo "<p>Error: There was an issue uploading your file. Please try again.</p>";
                }
            } else {
                echo "<p>Error: Please upload a PDF file.</p>";
            }
        } else {
            $id = $_POST['id'];
            header("Location: home.php?id=$id");
            exit();
        }
    } else {
        echo "<p>Error: All required fields are not filled.</p>";
    }
} else {
    echo "<p>Error: Form not submitted properly.</p>";
}

mysqli_close($connect);
