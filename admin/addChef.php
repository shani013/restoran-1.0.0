<?php
include_once 'db-connection.php';
session_start();

if (isset($_POST['add-chef'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);

    $target_dir = "../uploads/chefs/";

    // Generate a unique file name to prevent overwriting
    $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert the name, price, image URL, and description into the database
        $sql = "INSERT INTO chefs (name,designation,image) VALUES ('$name','$designation','$target_file')";
        $result = mysqli_query($conn, $sql);
        header('Location: chefDetails.php');
        exit();
    }

}
?>