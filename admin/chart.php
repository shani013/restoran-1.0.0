<?php
include 'db-connection.php';
session_start();

// Initialize arrays for monthly sales data and day-specific data
$monthly_sales = array();
$day_sales = array();

// Query to get the bills and dates from the orders table
$query = "SELECT bill, date FROM orders";
$result = mysqli_query($conn, $query);

// Process each row of data
while ($chart_data = mysqli_fetch_assoc($result)) {
    // Format the date to get the month and year (e.g., "2024-11")
    $month = date('Y-m', strtotime($chart_data['date']));
    $day = date('M j', strtotime($chart_data['date'])); // Format date to "Month Day"
    $bill = $chart_data['bill'];

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

// Combine both monthly sales data and day-specific data into a single array
$response_data = array(
    'monthly_sales' => $monthly_data,
    'day_sales' => $day_sales
);

// Encode the data into JSON format and output it
echo json_encode($response_data);
?>

