<!DOCTYPE html>

<?php
//connect server
include("server.php");
?>

<?php
//check gameID
if ((isset($_GET['gi'])) && (is_numeric($_GET['gi']))) {
    $gi = $_GET['gi'];
} else if ((isset($_POST['gi'])) && (is_numeric($_POST['gi']))) {
    $gi = $_POST['gi'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

//check userID
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
    $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
    $id = $_POST['id'];
} else {
    echo '<p class="error">This page has been accessed in error.</p>';
    exit();
}

$q = "SELECT * FROM gameCatalog WHERE gameID = $gi";

//run the query and assign it to the variable $result
$result = @mysqli_query($connect, $q);

if ($result) {
    //fetch
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>
    <html>

    <head>
        <link rel="stylesheet" href="style/game.css">
        <link rel="stylesheet" href="style/topnav.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>
            <?php echo $row['gameName']; ?>
        </title>
    </head>

    <body>
        <style>
            body {
                background-image: url('<?php echo $row['backImg']; ?>');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: 100% 100%;
            }
        </style>

        <!-- Background Audio -->
        <audio autoplay loop id="myaudio">
            <source src="<?php echo $row['mp3']; ?>" type="audio/mp3">
        </audio>

        <script>
            var audio = document.getElementById("myaudio");
            audio.volume = 0.1;
        </script>

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

        <center>
            <!-- Header -->
            <div class="header">
                <center>
                    <img src="<?php echo $row['logo']; ?>">
                </center>
            </div>

            <!-- Gameplay/Screenshot -->
            <div class="container">
                <div class="gameplay">
                    <!-- Gameplay/Screenshot -->
                    <center>
                        <div class="vid">
                            <!-- Games Footage/Screenshot -->
                            <div class="w3-content" style="max-width:800px">
                                <a><video autoplay muted loop class="mySlides" src="<?php echo $row['vid']; ?>" style="width:100%; height:60%"></a>
                                <a><img class="mySlides" src="<?php echo $row['img1']; ?>" style="width:100%; height:60%"></a>
                                <a><img class="mySlides" src="<?php echo $row['img2']; ?>" style="width:100%; height:60%"></a>
                            </div>

                            <!-- Next/Prev Button -->
                            <div class="w3-center">
                                <div class="w3-section">
                                    <button class="w3-button w3-light-grey" onclick="plusDivs(-1)">Prev</button>
                                    <button class="w3-button w3-light-grey" onclick="plusDivs(1)">Next</button>
                                </div>

                                <!-- Change content image -->
                                <button class="w3-button demo" onclick="currentDiv(1)">1</button>
                                <button class="w3-button demo" onclick="currentDiv(2)">2</button>
                                <button class="w3-button demo" onclick="currentDiv(3)">3</button>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="summary">
                            <p style="font-size: 20px;">
                                <?php echo $row['descript']; ?>
                            </p>
                        </div>
                    </center>
                </div>

                <div class="payment">
                    <center>
                        <div class="img" style="padding-top: 10px; border: 1px white;">
                            <img src="<?php echo $row['cover']; ?>" height="70%" width="70%">
                        </div>

                        <!-- Price -->
                        <p style="position: right;">
                            <?php echo ($row['price'] == 0) ? 'Free' : 'RM' . number_format($row['price'], 2); ?>
                        </p>

                        <!--Purchase  -->
                        <a href="gamePurchased.php?gi=<?php echo $gi; ?>&id=<?php echo $id; ?>&c='No'">GET</a>
                        <hr>
                        <a href="wishlistAdd.php?gi=<?php echo $gi; ?>&id=<?php echo $id; ?>">ADD TO WISHLIST</a>
                        <hr>
                        <a href="cartAdd.php?gi=<?php echo $gi; ?>&id=<?php echo $id; ?>">ADD TO CART</a>
                        <hr>

                        <!-- Game Information -->
                        <div class="info">
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
            </div>

            <script>
                var slideIndex = 1;
                showDivs(slideIndex);

                function plusDivs(n) {
                    showDivs(slideIndex += n);
                }

                function currentDiv(n) {
                    showDivs(slideIndex = n);
                }

                function showDivs(n) {
                    var i;
                    var x = document.getElementsByClassName("mySlides");
                    var dots = document.getElementsByClassName("demo");
                    if (n > x.length) {
                        slideIndex = 1
                    }
                    if (n < 1) {
                        slideIndex = x.length
                    }
                    for (i = 0; i < x.length; i++) {
                        x[i].style.display = "none";
                    }
                    for (i = 0; i < dots.length; i++) {
                        dots[i].className = dots[i].className.replace(" w3-red", "");
                    }
                    x[slideIndex - 1].style.display = "block";
                    dots[slideIndex - 1].className += " w3-red";
                }
            </script>
        </center>
    </body>

    </html>
<?php
} else {
    echo '<p class="error">The current user could not be retrieved. We apologize for any inconvenience.</p>';
    echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
}
//close the database connection
mysqli_close($connect);
?>