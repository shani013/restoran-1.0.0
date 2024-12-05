<?php
include "db-connection.php";
session_start();
if(!isset($_SESSION['role'] ) || $_SESSION['role'] !='-1')
{
    header("Location: ../404.php");
    exit;
}
elseif(isset($_POST['review_id']) && $_SESSION['role']=='-1')
{
    $review_id = mysqli_real_escape_string($conn, $_POST['review_id']);
    $query = "DELETE FROM reviews WHERE id = '$review_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: reviews.php"); // Redirect after success
        exit();
    }
}
?>