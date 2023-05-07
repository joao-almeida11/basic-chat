<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

</head>

<body>
    <div class="chat-body__wrapper">
        <div class="chat-body">
            <div class="row no-gutters">
                <div class="col-12 settings-tray__wrapper">
                    <div class="settings-tray">
                        <div class="friend-drawer no-gutters friend-drawer--grey">
                            <img class="profile-image" src="./assets/cat_photo_01.png" alt="">
                            <div class=" text">
                                <h6>AVILA Chat</h6>
                                <p class="text-muted">brought to you by ChatPHP</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat-panel" id="chatMessages">
                    <?php
                    include_once('./components/comment_list.php');?>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="./scripts/sc_sendMessage.php">
                                <div class="chat-box-tray">
                                    <!-- <i class="material-icons">sentiment_very_satisfied</i> -->
                                    <input type="text" placeholder="Type your message here..." id="sendMessage" name="sendMessage">
                                    <!-- <i class="material-icons">mic</i> -->
                                    <button type="submit"><i class="material-icons">send</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    function loadDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("chatMessages").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "/scripts/sc_comment_list.php", true);
        xhttp.send();

    }
    window.onload = function(){
        document.getElementById('chatMessages').scrollTo(0,document.getElementById('chatMessages').scrollHeight);
        setInterval(function(){
            loadDoc();
            document.getElementById('chatMessages').scrollTo(0,document.getElementById('chatMessages').scrollHeight);
            
        }, 5000);
        
    };

</script>
</body>

</html>