<?php
include 'db-connection.php';
session_start(); 
$total=0;
$charges=5;
?>
<style>
    .cart-container {
        position: relative;
        display: inline-block;
    }
    .cart-number {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1rem;
        font-weight: bold;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <a href="" class="navbar-brand p-0">
        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
    </a>
    <?php if(isset($_SESSION['name'])) { ?>
            <h5 class='text-light'>Welcome <?php echo $_SESSION['name'];?></h5>
            <a  href="logout.php" class='btn btn-sm btn-danger text-light mx-1'>Logout</a>
    <?php } ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="index.php" class="nav-item nav-link text-warning">Home</a>
            <a href="about.php" class="nav-item nav-link">About</a>
            <a href="service.php" class="nav-item nav-link">Service</a>
            <a href="menu.php" class="nav-item nav-link">Menu</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0">
                    <a href="team.php" class="dropdown-item">Our Team</a>
                    <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                </div>
            </div>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>
        <!-- Button trigger modal -->
        <?php if(isset($_SESSION['name'])): ?>
            
            <a href='#' class="cart-container"  data-bs-toggle="modal" data-bs-target="#cartModal" >
                <i class="bi bi-cart" style="font-size: 3rem;"></i>
                <?php if(isset($_SESSION['cart'])): ?>
                    <span class="cart-number text-warning"><?php echo count($_SESSION['cart']);?></span>
                <?php endif;?>
            </a>
        <?php else : ?> 
            <a type="button" class="btn btn-primary py-2 px-4" href='login.php'>
            Login
            </a>
        <?php endif; ?>    
    </div>
</nav>
        <!-- getting items from db as id is in cart-->
<?php
         

?>
<!-- Modal for Cart -->
<div class="modal  fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" >
        <div class="modal-content   px-2" style='max-width:450px;border-radius: 25px;'>
                <!-- Cart Items -->
                <div id="cart-items">
                    <div class="card-title pt-2">
                        <h3 class="text-center">Cart Items</h3>
                    </div>
                <div class="modal-body" style="max-height: 300px;  overflow-y: auto;">

                    <!-- Static cart items -->
                    <div class="col-lg-12">
                        <?php 
                        foreach ($_SESSION['cart'] as $id) { 
                            $query = "SELECT * FROM products WHERE id='$id'"; // Correct query syntax
                            $result = mysqli_query($conn, $query);
                            $product = mysqli_fetch_assoc($result); 
                            $total+=$product['price'];
                        ?>
                            <div class="product-card d-flex align-items-center position-relative border-bottom pb-2">
                                <img class="flex-shrink img-fluid rounded-circle" src="<?php echo $product['image']; ?>" alt="Product Image" style="width: 50px; height:50px;">
                                <div class="w-100 d-flex flex-column text-start ps-4">
                                    <h5 class="d-flex justify-content-between mt-2">
                                        <span class="fw-bold"><?php echo $product['name']; ?></span>
                                        <span class="text-success"><?php echo number_format($product['price'],2) ?>$</span>
                                    </h5>
                                    <div class="d-flex justify-content-end">
                                        <span class="fw-dark px-2">Qty</span>
                                        <input type="number" class="form-control form-control-sm rounded-3 text-between" value="1" min="1" style="width: 50px; height: 25px;">
                                        <button class='btn btn-sm btn-danger ms-auto'>Remove</button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <!-- Add more items in the same style as needed -->
                    </div>
                </div>
                <div class="container d-flex justify-content-between mt-2 px-4">
                    <span><strong>Total</strong></span>
                    <span><strong><?php echo number_format($total,2) ;?>$</strong></span>
                </div>
                <div class="container d-flex justify-content-between  px-4">
                    <span>Delivery Charges</span>
                    <span class='text-dark'><?php echo number_format($charges,2) ;?>$</span>
                </div>
                <div class="container d-flex justify-content-between  px-4">
                    <span>Grand Total</span>
                    <span class='text-dark'><?php echo number_format($total+$charges ,2);?>$</span>
                </div>
            </div>

            <!-- Footer with Action Buttons -->
            <div class="modal-footer justify-content-center bt-0">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-sm btn-success" id="placeOrderBtn">Place Order</button>
            </div>
        </div>
    </div>
</div>


