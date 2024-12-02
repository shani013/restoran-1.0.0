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
    .custom-icon {
        font-size: 1.5rem; /* Adjust the icon size (1.5rem is an example, change it as needed) */
    }

    /* Adjusting dropdown menu width and padding */
    

    /* Adjusting text size and padding inside the dropdown */
    .custom-text {
        color:#fff;
        font-size: 1rem; /* Adjust text size of the user's name */
        padding: 10px;
    }

    /* Adjust the size and appearance of the logout button */
    .custom-btn {
        font-size: 0.875rem; /* Smaller font size for the button */
        padding: 5px 10px; /* Adjust the button padding for a better fit */
    }
    
    /* Optional: Adjust the hover effect for better user interaction */
    .dropdown-item:hover {
        background-color: #fea116; /* Darker background on hover */
    }

    .dropdown-menu {
        border-radius: 8px; /* Optional: for rounded corners on the dropdown */
    }

</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
    <!-- Navbar brand (Restoran Title) on the left -->
    <a href="index.php" class="navbar-brand p-0">
        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i>Restoran</h1>
    </a>

    <!-- Toggle button for mobile view -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>

    <!-- Navbar links and dropdown on the right -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 pe-4">
            <a href="index.php" class="nav-item nav-link text-warning">Home</a>
            <a href="about.php" class="nav-item nav-link">About</a>
            <a href="service.php" class="nav-item nav-link">Service</a>
            <a href="menu.php" class="nav-item nav-link">Menu</a>
            <div class="nav-item dropdown ">
                <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu m-0 bg-dark">
                    <a href="team.php" class="dropdown-item text-light">Our Team</a>
                    <a href="testimonial.php" class="dropdown-item text-light">Testimonial</a>
                </div>
            </div>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
        </div>

        <!-- User and cart information (right-aligned) -->
        <?php if(isset($_SESSION['name'])): ?>
            

            <!-- User Dropdown -->
            <div class="dropdown ">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle custom-icon"></i> 
                </a>
                <ul class="dropdown-menu dropdown-menu-start bg-dark custom-dropdown " aria-labelledby="userDropdown">
                    <li class="dropdown-item custom-text "><?php echo $_SESSION['name']; ?></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a href="logout.php" class="btn btn-sm btn-danger text-light mx-4 custom-btn">Logout</a></li>
                </ul>
            </div>
            <!-- Cart Icon -->
            <a href='cart.php' class="cart-container ms-3">
                <i class="bi bi-cart" style="font-size: 2.3rem;"></i>
                <?php if(isset($_SESSION['total_qty'])): ?>
                    <span class="cart-number text-warning"><?php echo $_SESSION['total_qty']; ?></span>
                <?php else: ?>
                    <span class="cart-number text-warning">0</span>
                <?php endif; ?>
            </a>
        <?php else: ?>
            <!-- Login Button if not logged in -->
            <a type="button" class="btn btn-primary py-2 px-4 ms-3" href='login.php'>
                Login
            </a>
        <?php endif; ?>
    </div>
</nav>

        <!-- getting items from db as id is in cart-->
<?php
         

?>



