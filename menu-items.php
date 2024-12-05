<?php
    include 'db-connection.php';
    
    // Optimize the query by selecting only the needed columns
    $query = "SELECT id, name, price, image, description FROM products";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($data, MYSQLI_ASSOC);
    
?>

    <div id="tab-1" class="tab-pane fade show p-0 active">
        <div class="row g-4">
            <?php foreach ($result as $row) { ?>
                <div class="col-lg-6">
                    <div class="product-card d-flex align-items-center position-relative">
                        <img class="flex-shrink-0 img-fluid rounded-circle"  src="<?php echo str_replace('../', '', $row['image']); ?>" alt="" style="width: 80px; height:80px;" >
                        <div class="w-100 d-flex flex-column text-start ps-4">
                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                <span><?php echo $row['name']; ?></span>
                                <span class="text-primary"><?php echo number_format($row['price'], 2); ?>$</span>
                            </h5>
                            <small class="fst-italic"><?php echo $row['description']; ?></small>
                            <?php if (isset($_SESSION['name'])): ?>
                                <form action="cart.php" method="post" class='d-flex'>
                                    <input type="hidden" name="product-id" value="<?php echo $row['id']; ?>">
                                    <input type="number" class="form-control form-control-sm rounded-3 text-between product-qty" name='product-qty' value='1' min="1" style="width: 50px; height: 25px;">
                                    <button type='submit' name='add-to-cart' class='btn btn-sm btn-danger mt-3 add-to-cart-btn'>
                                        cart
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>



<style>
    

    /* Hide the Add to Cart button initially */
    .product-qty {
        position: absolute;
        left: 74%;
        bottom:70%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .add-to-cart-btn {
        position: absolute;
        left: 60%;
        bottom:70%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Show the Add to Cart button on hover */
    .product-card:hover .add-to-cart-btn,.product-card:hover .product-qty {
        opacity: 1;
    }
</style>
