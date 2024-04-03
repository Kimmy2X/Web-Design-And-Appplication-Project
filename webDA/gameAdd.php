<?php
include("server.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gameName = mysqli_real_escape_string($connect, $_POST['gameName']);
    $descript = mysqli_real_escape_string($connect, $_POST['descript']);
    $price = mysqli_real_escape_string($connect, $_POST['price']);
    $developer = mysqli_real_escape_string($connect, $_POST['developer']);
    $publisher = mysqli_real_escape_string($connect, $_POST['publisher']);
    $releasedDate = mysqli_real_escape_string($connect, $_POST['releasedDate']);


    // File upload handling
    $cover = uploadFile('cover', 'covers/');
    $logo = uploadFile('logo', 'logos/');
    $img1 = uploadFile('img1', 'images/');
    $img2 = uploadFile('img2', 'images/');
    $backImg = uploadFile('backImg', 'images/');
    $mp3 = uploadFile('mp3', 'audio/');

    // Check if video file is uploaded
    if (isset($_FILES['vid']) && $_FILES['vid']['error'] == UPLOAD_ERR_OK) {
        // Handle video file upload
        $vid = uploadFile('vid', 'videos/');
    } else {
        // If no video file is uploaded
        $vid = '';
    }

    // Insert data into the database
    $q = "INSERT INTO gameCatalog (gameID, gameName, cover, logo, vid, img1, img2, backImg, mp3, descript, price, developer, publisher, releasedDate) 
              VALUES ('', '$gameName', '$cover', '$logo', '$vid', '$img1', '$img2', '$backImg', '$mp3', '$descript', '$price','$developer', '$publisher', '$releasedDate')";

    if (mysqli_query($connect, $q)) {
        echo '<script>alert("Game Addded successfully!"); window.location="gameList.php";</script>';
        exit();
    } else {
        echo "Error: " . $q . "<br>" . mysqli_error($connect);
        exit();
    }
}

mysqli_close($connect);

function uploadFile($fileInputName, $targetDirectory)
{
    $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif", "mp4", "webp", "mp3");
    if (!in_array($fileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG, GIF, MP4, WebP, and MP3 files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<html>

<head>
    <title>Add New Game</title>
    <link rel="stylesheet" href="style/addGame.css">
</head>

<body>
    <h2>Add New Game</h2>
    <form action="gameAdd.php" method="post" enctype="multipart/form-data">
        <label for="gameName">Game Name:</label>
        <input type="text" id="gameName" name="gameName" required><br>

        <label for="cover">Cover:</label>
        <input type="file" id="cover" name="cover" required><br>

        <label for="logo">Logo:</label>
        <input type="file" id="logo" name="logo" required><br>

        <label for="vid">Video:</label>
        <input type="file" id="vid" name="vid" required><br>

        <label for="img1">First Image:</label>
        <input type="file" id="img1" name="img1" required><br>

        <label for="img2">Second Image:</label>
        <input type="file" id="img2" name="img2" required><br>

        <label for="backImg">Background Image:</label>
        <input type="file" id="backImg" name="backImg" required><br>

        <label for="mp3">Mp3:</label>
        <input type="file" id="mp3" name="mp3" required><br>

        <label for="descript">Description:</label>
        <textarea id="descript" name="descript" required></textarea><br>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br>

        <label for="developer">Developer:</label><br>
        <input type="text" id="developer" name="developer" required><br>

        <label for="publisher">Publisher:</label><br>
        <input type="text" id="publisher" name="publisher" required><br>

        <label for="releasedDate">Released Date:</label><br>
        <input type="text" id="releasedDate" name="releasedDate" required><br>

        <input type="submit" value="Add Game">
    </form>
</body>

</html>