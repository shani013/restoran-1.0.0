<?php
include 'db-connection.php';
$query="SELECT * FROM products";
$data=mysqli_query($conn,$query);
$result=mysqli_fetch_all($data,MYSQLI_ASSOC);
?>
<div id="tab-1" class="tab-pane fade show p-0 active">
    <div class="row g-4">
        <?php foreach ($result as $row ) { ?>
            <div class="col-lg-6">
                <div class="product-card d-flex align-items-center position-relative">
                    <img class="flex-shrink-0 img-fluid rounded-circle" src="<?php echo $row['image'] ;?>" alt="" style="width: 80px; height:80px;">
                    <div class="w-100 d-flex flex-column text-start ps-4">
                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                            <span><?php echo $row['name'];?></span>
                            <span class="text-primary"><?php echo number_format($row['price'],2); ?>$</span>
                        </h5>
                        <small class="fst-italic"><?php echo $row['description'];?></small>
                        <?php if(isset($_SESSION['name'])): ?>
                        <a href="#" class='btn btn-sm btn-danger mt-3 add-to-cart-btn'>Add to Cart</a>
                        <?php endif;?>
                    </div>
                    <!-- Hidden Add to Cart Button -->
                    
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    

    /* Hide the Add to Cart button initially */
    .add-to-cart-btn {
        position: absolute;
        left: 50%;
        bottom:70%;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Show the Add to Cart button on hover */
    .product-card:hover .add-to-cart-btn {
        opacity: 1;
    }
</style>




    
                        