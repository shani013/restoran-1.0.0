<?php
include "db-connection.php";
if(isset($_POST['chef_id']) && $_SESSION['role'] =='-1')
{
    $chef_id = mysqli_real_escape_string($conn, $_POST['chef_id']);
    $query = "DELETE FROM chefs WHERE id = '$chef_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: chefDetails.php"); // Redirect after success
        exit();
    }
}
else{
    
    header("Location: ../404.php");
    exit();

}
?>