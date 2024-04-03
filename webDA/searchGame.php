<html>

<head>
    <title></title>
    <link rel="stylesheet" href="style/list.css">
</head>

<body>
    <?php
    include("server.php");
    ?>
    <h2>Search Result</h2>
    <?php
    $in = $_POST['gameName'];
    $gn = mysqli_real_escape_string($connect, $in);

    //make the query
    $q = "SELECT * FROM gameCatalog WHERE gameName='$gn' ORDER BY gameID";

    //run the query and assign it to the variable $result
    $result = @mysqli_query($connect, $q);
    if ($result) { ?>
        <a href="adminConsole.html"> Menu </a>
        <table border="2">
            <tr>
                <td align="center"><strong>Game ID</strong></td>
                <td align="center"><strong>Game Name</strong></td>
                <td align="center"><strong>Cover</strong></td>
                <td align="center"><strong>Video</strong></td>
                <td align="center"><strong>First Image</strong></td>
                <td align="center"><strong>Second Image</strong></td>
                <td align="center"><strong>Background Image</strong></td>
                <td align="center"><strong>Mp3</strong></td>
                <td align="center"><strong>Description</strong></td>
                <td align="center"><strong>Developer</strong></td>
                <td align="center"><strong>Publisher</strong></td>
                <td align="center"><strong>Released Date</strong></td>
                <td align="center"><strong>Update</strong></td>
                <td align="center"><strong>Delete</strong></td>
            </tr>

            <!-- fetch and print all the records -->
            <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td>
                        <?php echo $row['gameID']; ?>
                    </td>
                    <td>
                        <?php echo $row['gameName']; ?>
                    </td>
                    <td>
                        <?php echo $row['cover']; ?>
                    </td>
                    <td>
                        <?php echo $row['vid']; ?>
                    </td>
                    <td>
                        <?php echo $row['img1']; ?>
                    </td>
                    <td>
                        <?php echo $row['img2']; ?>
                    </td>
                    <td>
                        <?php echo $row['backImg']; ?>
                    </td>
                    <td>
                        <?php echo $row['mp3']; ?>
                    </td>
                    <td>
                        <?php echo $row['descript']; ?>
                    </td>
                    <td>
                        <?php echo $row['developer']; ?>
                    </td>
                    <td>
                        <?php echo $row['publisher']; ?>
                    </td>
                    <td>
                        <?php echo $row['releasedDate']; ?>
                    </td>
                    <td align="center"><a href="gameUpdate.php?id=<?php echo $row['gameID']; ?>">Update</a></td>
                    <td align="center"><a href="gameDelete.php?id=<?php echo $row['gameID']; ?>">Delete</a></td>
                </tr>
        <?php }
            //close the table
            echo '</table>';

            //free up the resources
            mysqli_free_result($result);
        } else {
            echo '<p class="error">If no record is shown, this is because you had an incorrect or missing
                entry in search form.<br>Click the back button on the browser and try again.</p>';

            echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
        }
        mysqli_close($connect);
        ?>
</body>

</html>