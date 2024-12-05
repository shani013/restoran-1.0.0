<?php
    include 'db-connection.php';
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['add-to-cart'])) {
            // Get POST values
        $product_id = $_POST['product-id'];
        $product_qty = (int)$_POST['product-qty'];

        // Check if the 'cart-items' session array exists
        if (isset($_SESSION['cart-items'])) {
            // Loop through existing cart items
            foreach ($_SESSION['cart-items'] as &$items) {
                if ($items['id'] == $product_id) {
                    // Update the quantity if the item exists in the cart
                    $items['qty'] += $product_qty;
                    break; // Exit loop once item is found
                }
            }
        } 
        else {
            // If cart doesn't exist, initialize it
            $_SESSION['cart-items'] = [];
        }

        // Add new item if it's not already in the cart
        $found = false;
        foreach ($_SESSION['cart-items'] as $item) {
            if ($item['id'] == $product_id) {
                $found = true;
                break;
            }
        }

        // If the product isn't in the cart, add it
        if (!$found) {
            $_SESSION['cart-items'][] = [
                'id' => $product_id,
                'qty' => $product_qty
            ];
        }
       
        $_SESSION['total_qty'] = 0; // Reset total quantity
        foreach ($_SESSION['cart-items'] as $item) {
            $_SESSION['total_qty'] += $item['qty'];
        }
        header('location:menu.php');
        exit();
    }

    // Step 1: Recalculate total quantity at the start of the script
    if (!isset($_SESSION['total_qty'])) {
        $_SESSION['total_qty'] = 0; // Initialize total quantity if not set
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove-id']) && isset($_POST['r_id'])) {
        $remove_id = $_POST['r_id'];  // The product ID to remove from the cart

        // Step 2: Remove the item from the cart
        foreach ($_SESSION['cart-items'] as $key => $item) {
            if ($item['id'] == $remove_id) {
                // Remove the item from the cart
                unset($_SESSION['cart-items'][$key]);
                // Re-index the array to fix any gaps in the indices
                $_SESSION['cart-items'] = array_values($_SESSION['cart-items']);
                break;  // Exit the loop after removing the item
            }
        }

        // Step 3: Recalculate the total quantity after removing the item
        $_SESSION['total_qty'] = 0; // Reset the total quantity
        foreach ($_SESSION['cart-items'] as $item) {
            $_SESSION['total_qty'] += $item['qty']; // Add up the quantities
        }

        // Step 4: Redirect the user back to the cart page (or wherever needed)
        header('Location: cart.php');
        exit();  // Don't forget to call exit() after header redirection
    }
    $orderItems=array();
    $total = 0;
    if (isset($_SESSION['cart-items']) && count($_SESSION['cart-items']) > 0) {
        foreach ($_SESSION['cart-items'] as $items) {
            $id = $items['id'];
            $query = "SELECT * FROM products WHERE id=$id";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);

            // Add product price * quantity to the total
            $total += $product['price'] * $items['qty'];
            // Add item to the orderItems array in the desired format
            $orderItems[] = array(
            'id' => $id,
            'qty' => $items['qty']);
        }
    }
    //$orderItems = json_encode($orderItems);

    // Step 3: Calculate delivery charges (can be static or dynamic)
    $delivery_charge = 5.00; // Fixed delivery charge. You can adjust it or make it dynamic.

    // Step 4: Calculate grand total (Total + Delivery Charges)
    $grand_total = $total + $delivery_charge;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'headerlinks.php'; ?>
    <title>Cart</title>
     <style>
        .modal-content {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-center {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid position-relative vh-100">
        <!-- Background Image -->
        <div class="position-absolute top-0 start-0 w-100 h-100">
            <img src="bg-hero.jpg" alt="Background" class="w-100 h-100 object-fit-cover" style="opacity: 0.4;">
        </div>

        <!-- Cart Form -->
        <div class="container d-flex flex-column justify-content-between position-relative mx-auto h-100" 
            style="max-width: 600px; background-color: rgba(0, 0, 0, 0.8); border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5); padding: 20px; color: white;">

            <!-- Sticky Title -->
            <h3 class="text-center sticky-top py-2 text-warning rounded" style="z-index: 1;">Your Cart</h3>

            <!-- Scrollable Items -->
            <div class="cart-items overflow-auto flex-grow-1 my-3" style="max-height: calc(100vh - 200px);">
                <!-- PHP code for items -->
                <?php if (isset($_SESSION['cart-items']) && count($_SESSION['cart-items']) > 0): ?>
                    <?php foreach ($_SESSION['cart-items'] as $items):
                        $id = $items['id'];
                        $query = "SELECT * FROM products WHERE id=$id";
                        $result = mysqli_query($conn, $query);
                        $product = mysqli_fetch_assoc($result);
                    ?>
                        <div class="cart-item d-flex justify-content-between align-items-center border-bottom py-3 px-3 mb-3"
                            style="background-color: rgba(255, 255, 255, 0.8); border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">
                            <img src="<?php echo str_replace('../', '', $product['image']); ?>" alt="Product Image" style="width: 70px; height: 70px;" class="rounded-circle">
                            <div class="w-100 ps-3 ">
                                <h4><?php echo $product['name']; ?></h4>
                                <p class="d-inline text-dark">Qty: <?php echo $items['qty']; ?></p>      
                                <h6 class="d-inline">$<?php echo number_format($product['price'], 2); ?></h6>
                            </div>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <input type="hidden" name="r_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="remove-id" class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <h4 class="text-center text-warning">Your cart is empty!</h4>
                <?php endif; ?>
            </div>

            <!-- Sticky Summary -->
            <div class="cart-summary text-white sticky-bottom  py-3 rounded" style="z-index: 1;">
                <h5 class="text-success">Total: <span class="text-success"><?php echo number_format($total, 2); ?> $</span></h5>
                <h5 class="text-danger">Delivery: <span class="text-danger"><?php echo number_format($delivery_charge, 2); ?> $</span></h5>
                <h5 class="text-warning">Grand Total: <span class="text-warning"><?php echo number_format($grand_total, 2); ?> $</span></h5>
            </div>

            <!-- Buttons -->
            <div class="text-center mt-3">
                <?php if (isset($_SESSION['cart-items']) && count($_SESSION['cart-items']) > 0): ?>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addressModal">Proceed to Order</button>
                    <a href="index.php" class="btn btn-sm btn-danger">Cancel</a>
                <?php else: ?>
                    <a href="index.php" class="btn btn-sm btn-danger">Cancel</a>
                    <a href="menu.php" class="btn btn-sm btn-success">Order Items</a>
                    
                <?php endif; ?>
            </div>
        </div>
    </div>


        
        

        <!-- Modal -->
        <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content p-4">
                    <h5 class="modal-title text-center mb-4">Enter Your Address</h5>
                    <form action="order.php" method="post">
                        <!-- Province and City on One Line -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="selectProvince" class="form-label">Select Province</label>
                                <select class="form-select" name="province" id="selectProvince">
                                    <option selected disabled>Choose a province</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Sindh">Sindh</option>
                                    <option value="Khyber Pakhtunkhwa">Khyber Pakhtunkhwa</option>
                                    <option value="Balochistan">Balochistan</option>
                                    <option value="Islamabad">Islamabad</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="selectCity" class="form-label">Select City</label>
                                <select class="form-select" name="city" id="selectCity">
                                    <option selected disabled>Choose a city</option>
                                    <option value="Lahore">Lahore</option>
                                    <option value="Pakpattan">Pakpattan</option>
                                    <option value="Karachi">Karachi</option>
                                    <option value="Arifwala">Arifwala</option>
                                    <option value="Islamabad">Islamabad</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Address Input -->
                        <div class="mb-3">
                            <label for="userAddress" class="form-label">Enter Address</label>
                            <textarea class="form-control" id="userAddress" rows="3" name="address" placeholder="Enter your full address"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="btn-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <!--Total bill of order-->
                            <input type="hidden" name="bill" value="<?php echo $grand_total; ?>">
                            <!--Details of order in json form-->
                            <input type="hidden" name="details" value='<?php echo json_encode($orderItems); ?>'>
                            <button type="submit" name="confirm-order" class="btn btn-success">Confirm Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>