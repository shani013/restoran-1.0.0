<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db-connection.php";
session_start();

if (isset($_POST['confirm-order']) && isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    // Get the address from POST
    $address = $_POST['address'];

    // Remove newline and carriage return characters
    $address = str_replace(array("\r", "\n"), '', $address);

    // Escape special characters for safe SQL insertion
    $address = mysqli_real_escape_string($conn, $address);

    // Concatenate the address components into one variable
    $full_address = $city . ', ' . $province . ', ' . $address;

    $bill =  $_POST['bill'];  // Sanitize the bill value
    $details = $_POST['details']; // Use the raw JSON string directly

    $status = 'N';  // Default status for new order

    // Set the time zone to Asia/Karachi
    date_default_timezone_set('Asia/Karachi');
    $date = date("Y-m-d");  // Current date
    $time = date("H:i:s");  // Current time

    // Insert into orders table
    $sql = "INSERT INTO orders (user_id, bill, details, status, date, time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt === false) {
        die("Error preparing statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, 'idssss', $user_id, $bill, $details, $status, $date, $time);

    if (mysqli_stmt_execute($stmt)) {
        // Get the last inserted order ID
        $order_id = mysqli_insert_id($conn);

        // Insert the address into the customers table
        $address_sql = "INSERT INTO customers (user_id, address) VALUES (?, ?)";
        $address_stmt = mysqli_prepare($conn, $address_sql);
        if ($address_stmt === false) {
            die("Error preparing address statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($address_stmt, 'is', $user_id, $full_address);

        if (mysqli_stmt_execute($address_stmt)) {
            // Set order ID in the session
            $_SESSION['order-id'] = $order_id;

            // Clear session variables related to the cart
            unset($_SESSION['cart-items']);
            unset($_SESSION['total_qty']);

            // Redirect to index.php
            header("Location: index.php");
            exit();
        } 
        else {
                die("Order not found.");
            }
    } 
    else {
        echo "Error inserting order: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}   
else{
    header("Location: login.php");
    exit();
}

?>
