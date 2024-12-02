<?php
include 'db-connection.php';
session_start();

// Initialize arrays for sales, statuses, and product details
$monthly_sales = array();
$day_sales = array();
$order_statuses = array(); // To store the status of each order
$product_sales = array(); // To store sales data for products

// Query to get the bill, date, status, and details from the orders table
$query = "SELECT bill, date, status, details FROM orders";
$result = mysqli_query($conn, $query);

// Fetch product names from the products table
$product_query = "SELECT id, name FROM products";
$product_result = mysqli_query($conn, $product_query);

// Map product IDs to product names
$product_names = array();
while ($product = mysqli_fetch_assoc($product_result)) {
    $product_names[$product['id']] = $product['name'];
}

// Process each row of order data
while ($chart_data = mysqli_fetch_assoc($result)) {
    // Format the date to get the month and year (e.g., "2024-11")
    $month = date('Y-m', strtotime($chart_data['date']));
    $day = date('M j', strtotime($chart_data['date'])); // Format date to "Month Day"
    $bill = $chart_data['bill'];
    $status = $chart_data['status']; // Get the status of the order
    $details = $chart_data['details']; // Get the order details (e.g., '[{"id":1,"qty":2},{"id":2,"qty":4}]')

    // Calculate monthly sales
    if (isset($monthly_sales[$month])) {
        $monthly_sales[$month] += $bill;
    } else {
        $monthly_sales[$month] = $bill;
    }

    // Store day-specific data
    $day_sales[] = [
        'bill' => $bill,
        'date' => $day
    ];

    // Store the status of the order
    $order_statuses[] = $status;

    // Process the product details
    // Decode the JSON details string into an array
    $details_array = json_decode($details, true); // Decode JSON into an associative array
    if ($details_array) {
        foreach ($details_array as $item) {
            $product_id = $item['id']; // Get the product ID
            $quantity = intval($item['qty']); // Get the quantity

            // Update the product sales array
            if (isset($product_sales[$product_id])) {
                $product_sales[$product_id]['qty'] += $quantity;
            } else {
                $product_sales[$product_id] = [
                    'name' => $product_names[$product_id] ?? 'Unknown Product', // Get product name or default
                    'qty' => $quantity
                ];
            }
        }
    }
}

// Prepare the data for monthly sales (formatted to "Month Year")
$monthly_data = array();
foreach ($monthly_sales as $month => $total_sales) {
    $formatted_month = date('M Y', strtotime($month));
    $monthly_data[] = [
        'bill' => $total_sales,
        'date' => $formatted_month
    ];
}

// Combine all data into a single array
$response_data = array(
    'monthly_sales' => $monthly_data,
    'day_sales' => $day_sales,
    'order_statuses' => $order_statuses,
    'product_sales' => array_values($product_sales) // Flatten product sales to a simple array
);

// Encode the data into JSON format and output it
echo json_encode($response_data);
?>
