<?php
// Connect to the server
include("server.php");

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // File upload handling
    if (isset($_FILES['proof'])) {
        $file_name = $_FILES['proof']['name'];
        $file_tmp = $_FILES['proof']['tmp_name'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Specify the directory where the file will be stored
        $target_dir = "proofs/";

        if (strtolower($file_extension) === 'pdf') {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file_tmp, $target_dir . $file_name)) {
                // File uploaded successfully, now update the database
                $proof_path = $target_dir . $file_name;

                // Get cart items for the user
                $cartQuery = "SELECT * FROM cart WHERE userID = $id";
                $cartResult = mysqli_query($connect, $cartQuery);

                if ($cartResult) {
                    // Loop through each cart item and insert into purchases table
                    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
                        $gi = $cartItem['gameID'];

                        // Insert cart item into purchases table
                        $insertQuery = "INSERT INTO purchases (userID, gameID, proofOfPurchase) VALUES ('$id', '$gi', '$proof_path')";

                        if (!mysqli_query($connect, $insertQuery)) {
                            echo "Error inserting cart item into purchases: " . mysqli_error($connect);
                        }
                    }

                    // Delete cart items after they have been inserted into purchases
                    $deleteCartQuery = "DELETE FROM cart WHERE userID = $id";
                    if (!mysqli_query($connect, $deleteCartQuery)) {
                        echo "Error deleting cart items: " . mysqli_error($connect);
                    }

                    $deleteWishQuery = "DELETE FROM wishlist WHERE userID = $id";
                    if (!mysqli_query($connect, $deleteWishQuery)) {
                        echo "Error deleting wishlist items: " . mysqli_error($connect);
                    }

                    // Redirect back to the cart page
                    echo '<script>alert("New games  have been added to the library!");
                    window.location.href="cart.php?id=' . $id . '";</script>';
                    exit();
                } else {
                    echo "Error retrieving cart items: " . mysqli_error($connect);
                }
            } else {
                echo "<p>Error: There was an issue uploading your file. Please try again.</p>";
            }
        } else {
            echo "<p>Error: Please upload a PDF file.</p>";
        }
    } else {
        echo "<p>Error: No file uploaded.</p>";
    }
} else {
    echo '<p class="error">Invalid userID.</p>';
}
