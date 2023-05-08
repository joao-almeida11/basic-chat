
    <?php

    session_start();

    // to console.log to the JavaScript console
    function debugToConsole($msg)
    {
        echo "<script>console.log(" . json_encode($msg) . ")</script>";
    }

    // INSERE AQUI O ID DA TUA EQUIPA
    $_SESSION["userId"] = "PHP Masters"; // TODO: make this dynamic
    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];

        // the file path is relative to index.php where this file is included
        require_once "connections/connection.php";

        // Create a new DB connection
        $link = new_db_connection();

        /* create a prepared statement */
        $stmt = mysqli_stmt_init($link);

        $query = "SELECT `id_messages`, `message`, `time`, messages.ref_id_recetor, messages.ref_id_emissor FROM `messages`
    INNER JOIN teams
    ON teams.username = messages.ref_id_recetor
    WHERE messages.ref_id_recetor = ? OR messages.ref_id_emissor = ?
    ORDER BY `messages`.`time`";

        if (mysqli_stmt_prepare($stmt, $query)) {
            /* Bind paramenters */
            mysqli_stmt_bind_param($stmt, "ss", $userId, $userId);
            /* execute the prepared statement */
            if (mysqli_stmt_execute($stmt)) {
                /* bind result variables */
                mysqli_stmt_bind_result($stmt, $id_messages, $message, $time, $recetor, $emissor);
                /* fetch values */
                while (mysqli_stmt_fetch($stmt)) {
                    // if the emissor is the user logged in then its is own messages
                    if ($emissor == $_SESSION["userId"]) {
                        // message right
                        echo
                        '
                    <div class="row no-gutters">
        <div class="col-sm-9 offset-sm-3">
            <div class="chat-bubble--right"><div class="message__list">
            <p class="message__author-name">' . htmlspecialchars($emissor) . '</p>
                <p class="chat-bubble">' . htmlspecialchars($message) . '</p>
                <p class="message__author-name">' . htmlspecialchars($time) . '</p>
            </div>
            </div>
        </div>
    </div>
                ';
                 
                    // if the recetor is the user logged in then the logged user is seeing the message that the mentor is sending to him/her
                    } else if ($recetor == $_SESSION["userId"]) {
                        
                        // message left
                        echo
                        '
                    <div class="row no-gutters">
        <div class="col-sm-6">
            <div class="chat-bubble--left">
                <div class="message">
                    <div class="message__avatar">
                        <img class="profile-image" src="./assets/cat_photo_01.png" />
                    </div>
                    <div class="message__list">
                        <p class="message__author-name">' . htmlspecialchars($emissor) . '</p>
                   <p class="chat-bubble">' . htmlspecialchars($message) . '</p>
                   <p class="message__author-name">' . htmlspecialchars($time) .
                        '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                ';
                    }
                }
            } else {
                // Action on error
                echo "Error:" . mysqli_stmt_error($stmt);
            }
            /* close statement */
            mysqli_stmt_close($stmt);
        } else {
            echo ("Error description: " . mysqli_error($link));
        }
        /* close connection */
        mysqli_close($link);

    }
    ?>