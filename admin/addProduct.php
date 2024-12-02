<?php
include_once 'db-connection.php';
session_start();

if (isset($_POST['add-product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $target_dir = "../uploads/products/";

    // Generate a unique file name to prevent overwriting
    $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert the name, price, image URL, and description into the database
        $sql = "INSERT INTO products (name,description,image,price) VALUES ('$name','$description','$target_file','$price')";
        $result = mysqli_query($conn, $sql);
        header('location:index.php');
        exit();
    }

}
?>