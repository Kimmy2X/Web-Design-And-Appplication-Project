<html>

<head>
    <title>User List</title>
    <link rel="stylesheet" href="style/list.css">
</head>

<body>
    <?php
    //call file to connect server eleave
    include("server.php");
    ?>

    <h2>List of Users</title>
        <?php
        //make the query
        $q = "SELECT * FROM user ORDER BY userID";

        //run the query and assign it to the variable $result
        $result = @mysqli_query($connect, $q);

        if ($result) { ?>
            <br>
            <a href="adminConsole.html"> Menu </a>
            <form action="searchUser.php" method="post">
                <input type="text" placeholder="Search user.." id="userName" name="userName" value="<?php if (isset($_POST['userName'])) {
                                                                                                        echo $_POST['userName'];
                                                                                                    } ?>">
            </form>

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
                //error message
                echo '<p class="error">The current user could not be retrieved.
                We apologize for any inconvenience.</p>';

                //debugging message
                echo '<p>' . mysqli_error($connect) . '<br><br>Query:' . $q . '</p>';
            } //end of if($result)
            //close the database connection
            mysqli_close($connect);
            ?>
</body>

</html>