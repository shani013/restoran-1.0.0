<?php

    session_start();

    // Check if product ID is provided
    if (isset($_GET['product_id'])) {
        $productId = intval($_GET['product_id']); // Sanitize product ID

        // Initialize cart if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add product to the cart
        if (!in_array($productId, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $productId;
        }

       

        // Redirect back to the product page
        header("Location: index.php");
        exit();
    }

?>