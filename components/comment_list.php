<div class="chat-panel">
    <?php
    session_start();
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
                // echo "<ul>";

                $messages_list = array();
                /* fetch values */
                while (mysqli_stmt_fetch($stmt)) {
                    array_push($messages_list, array(
                        'id' => $id_messages,
                        'message' => $message,
                        'time' => $time,
                        'recetor' => $recetor,
                        'emissor' => $emissor
                    ));
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

        // var_dump($messages_list);
        function debugToConsole($msg)
        {
            echo "<script>console.log(" . json_encode($msg) . ")</script>";
        }
        // debugToConsole($messages_list);

        $messages_list_formatted = array();
        foreach ($messages_list as $single_message) {
            $found_match = false;
            $last_index = count($messages_list_formatted) - 1;

            if ($last_index >= 0 && $messages_list_formatted[$last_index]['recetor'] === $single_message['recetor'] && $messages_list_formatted[$last_index]['emissor'] === $single_message['emissor']) {
                array_push($messages_list_formatted[$last_index]['messages_list_same_person'], $single_message['message']);
                $found_match = true;
            }

            if (!$found_match) {
                array_push($messages_list_formatted, array(
                    'id' => $single_message['id'],
                    'time' => $single_message['time'],
                    'recetor' => $single_message['recetor'],
                    'emissor' => $single_message['emissor'],
                    'messages_list_same_person' => array($single_message['message'])
                ));
            }
        }

        debugToConsole($messages_list_formatted);

        foreach ($messages_list_formatted as $single_message_list) {
            if ($single_message_list['emissor'] == $_SESSION["userId"]) {
                // message right
                echo
                '
                    <div class="row no-gutters">
        <div class="col-sm-9 offset-sm-3">
            <div class="chat-bubble--right"><div class="message__list">
            <p class="message__author-name">' . htmlspecialchars($single_message_list['emissor']) . '</p>
            ';
                foreach ($single_message_list['messages_list_same_person'] as $single_message_value) {
                    echo ' <p class="chat-bubble">' . htmlspecialchars($single_message_value) . '</p>';
                }
                echo
                '
                <p class="message__author-name">' . htmlspecialchars($single_message_list['time']) . '</p>
            </div>
            </div>
        </div>
    </div>
                ';
            } else if ($single_message_list['recetor'] == $_SESSION["userId"]) {
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
                        <p class="message__author-name">' . htmlspecialchars($single_message_list['emissor']) . '</p>';

                foreach ($single_message_list['messages_list_same_person'] as $single_message_value) {
                    echo ' <p class="chat-bubble">' . htmlspecialchars($single_message_value) . '</p>';
                }

                echo
                '
                   <p class="message__author-name">' . htmlspecialchars($single_message_list['time']) . '</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                ';
            }
        }
    }
    ?>
</div>