<?php
session_start();
$user_id = $_SESSION["userId"];

echo $_SESSION["userId"];
echo $_POST['sendMessage'];

if(isset($_POST['sendMessage'])){

    $message=htmlspecialchars($_POST['sendMessage']);
    $recetor = "mentorAVILA";
    $user_id = $_SESSION["userId"];

    include_once "../connections/connection.php";
    $link=new_db_connection();

    $stmt= mysqli_stmt_init($link);
    $query="INSERT INTO messages (message, ref_id_emissor, ref_id_recetor) VALUES(?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) { // Prepare the statement
        echo 'hey';

        mysqli_stmt_bind_param($stmt, "sss", $message, $user_id, $recetor);


        if(mysqli_stmt_execute($stmt)){
            header("Location: ../index.php");
        }else{
            echo $recetor;
            echo $user_id;
            echo "Error:" . mysqli_stmt_error($stmt); // Error here
        }


        mysqli_stmt_close($stmt); // Close statement
    } else {
        echo"erro";
        echo("Error description: " . mysqli_error($link));
    }

    mysqli_close($link); // Close connection
    //header("Location: ../index.php");
    
}else{
    header("Location: ../index.php");
};
?>