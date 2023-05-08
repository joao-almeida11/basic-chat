
    <?php

    session_start();

    $_SESSION["userId"] = ""; // WRITE HERE YOUR TEAM USERNAME
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];

        // the file path is relative to index.php where this file is included
        require_once "connections/connection.php";

        // Create a new DB connection
        $link = new_db_connection();

        /* create a prepared statement */
        $stmt = mysqli_stmt_init($link);

        $query = "";

        // WITH THE HTML PROVIDED (IN THIS FOLDER) ITERATE THE MESSAGES BETWEEN YOU AND THE MENTOR :) GOOD LUCK!

    }
    ?>