<?php
session_start();
$user_id = $_SESSION["userId"];

include_once "../../connections/connection.php";
$link=new_db_connection();

$stmt= mysqli_stmt_init($link);

?>