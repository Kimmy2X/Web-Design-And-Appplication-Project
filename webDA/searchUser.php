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
    $in = $_POST['userName'];
    $in = mysqli_real_escape_string($connect, $in);

    //make the query
    $q = "SELECT * FROM user WHERE userName='$in' ORDER BY userID";

    //run the query and assign it to the variable $result
    $result = @mysqli_query($connect, $q);
    if ($result) { ?>
        <a href="adminConsole.html"> Menu </a>
        <table border="2">
            <tr>
                <td align="center"><strong>ID</strong></td>
                <td align="center"><strong>NAME</strong></td>
                <td align="center"><strong>PHONE NO.</strong></td>
                <td align="center"><strong>EMAIL</strong></td>
                <td align="center"><strong>BIRTHDATE</strong></td>
                <td align="center"><strong>ADMIN(?)</strong></td>
                <td align="center"><strong>UPDATE</strong></td>
                <td align="center"><strong>DELETE</strong></td>
            </tr>

            <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                <tr>
                    <td>
                        <?php echo $row['userID'] ?>
                    </td>
                    <td>
                        <?php echo $row['userName'] ?>
                    </td>
                    <td>
                        <?php echo $row['userPhoneNo'] ?>
                    </td>
                    <td>
                        <?php echo $row['userEmail'] ?>
                    </td>
                    <td>
                        <?php echo $row['userBday'] ?>
                    </td>
                    <td>
                        <?php echo $row['userAdmin'] ?>
                    </td>
                    <td align="center"><a href="userAdminUpdate.php?id=<?php echo $row['userID'] ?>">Update</a></td>
                    <td align="center"><a href="userDelete.php?id=<?php echo $row['userID'] ?>">Delete</a></td>
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