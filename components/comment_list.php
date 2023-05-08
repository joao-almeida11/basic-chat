
    <?php

    session_start();

    // INSERT YOUR TEAM ID HERE 
    $_SESSION["userId"] = " "; // INSERT YOUR TEAM USERNAME HERE
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];

        // the file path is relative to index.php where this file is included
        require_once "connections/connection.php";

        // Create a new DB connection
        $link = new_db_connection();

        /* create a prepared statement */
        $stmt = mysqli_stmt_init($link);

        $query = "";
        // CONTINUE THE EXERCISE HERE USING THE HTML IN THIS FOLDER :)

    }
    ?>