<?php 
session_start(); 
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
        <!-- <img src="img/logo.png" alt="Logo"> -->
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
            <a href="#" class="cart-container">
              <i class="bi bi-cart" style="font-size: 3rem;"></i>
                <span class="cart-number text-warning">3</span>
            </a>
        <?php else : ?> 
            <a type="button" class="btn btn-primary py-2 px-4" href='login.php'>
            Login
            </a>
        <?php endif; ?>
        
        
    </div>
</nav>

