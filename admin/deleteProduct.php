<?php
include "db-connection.php";
if(isset($_POST['product_id']) && $_SESSION['role']=='-1')
{
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $query = "DELETE FROM products WHERE id = '$product_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: productDetails.php"); // Redirect after success
        exit();
    }
}
else{
    
    header("Location: ../404.php"); 
    exit();
}
?>