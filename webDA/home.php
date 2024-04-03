<?php
/* Connect Server */
include("server.php");

//check userID
if ((isset($_GET['id'])) && (is_numeric($_GET['id']))) {
  $id = $_GET['id'];
} else if ((isset($_POST['id'])) && (is_numeric($_POST['id']))) {
  $id = $_POST['id'];
} else {
  echo '<p class="error">This page has been accessed in error.</p>';
  exit();
}

$q = "SELECT gameID, gameName, cover, price
FROM gameCatalog ORDER BY gameID";

$result = mysqli_query($connect, $q);

if ($result) {
  /* Define Games */
  $games = array();
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $games[] = $row;
  }
?>

  <html>

  <head>
    <title>Youxi Dian</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/topnav.css">
    <link rel="stylesheet" href="style/home.css">
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


    <div class="content">
      <!-- Games Cover -->
      <div class="w3-content" style="max-width:800px; text-align: center;">
        <?php foreach ($games as $row) { ?>
          <a href="gamePage.php?gi=<?php echo $row['gameID']; ?>&id=<?php echo $id; ?>" style="display: inline-block;">
            <img class="mySlides" src="<?php echo $row['cover']; ?>" style="max-width: 100%; height: auto;">
          </a>
        <?php } ?>
      </div>

      <!-- Next/Prev Button -->
      <div class="w3-center">
        <div class="w3-section">
          <button class="w3-button w3-light-grey" onclick="plusDivs(-1)">Prev</button>
          <button class="w3-button w3-light-grey" onclick="plusDivs(1)">Next</button>
        </div>
      </div>
    </div>

    <!-- Group games by gameID -->
    <div class="container">
      <center>
        <?php
        $groupedGames = array();
        foreach ($games as $row) {
          $gameID = $row['gameID'];
          if (!isset($groupedGames[$gameID])) {
            $groupedGames[$gameID] = array();
          }
          $groupedGames[$gameID][] = $row;
        }
        // Display each group of games in its own container
        foreach ($groupedGames as $gameID => $gameGroup) {
        ?>
          <div class="gamelib">
            <?php foreach ($gameGroup as $game) { ?>
              <div class="item">
                <a href="gamePage.php?gi=<?php echo $game['gameID']; ?>&id=<?php echo $id; ?>">
                  <img src="<?php echo $game['cover']; ?>" alt="<?php echo $game['gameName']; ?>">
                  <h3>
                    <?php echo $game['gameName']; ?>
                  </h3>
                  <p>
                    <?php echo ($game['price'] == 0) ? 'Free' : 'RM' . number_format($game['price'], 2); ?>
                  </p>
                </a>
              </div>
            <?php } ?>
          </div>
        <?php } ?>
      </center>
    </div>

    <div class="about">
      <div class="social">
        <p>FOLLOW FOR MORE</p>
        <a href="#" class="fa fa-instagram"></a>
        <a href="#" class="fa fa-youtube"></a>
      </div>
    </div>


    <!-- Script for Slides -->
    <script>
      var slideIndex = 1;
      showDivs(slideIndex);

      function plusDivs(n) {
        showDivs(slideIndex += n);
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
  </body>

  </html>

<?php
} else {
  echo '<p class="error">The current user could not be retrieved. We apologize for any inconvenience.</p>';
  echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
}
mysqli_close($connect);
?>