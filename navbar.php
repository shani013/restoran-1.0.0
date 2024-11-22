<?php 
session_start(); 
?>
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
            <a type="button" href='menu.php' class="btn btn-primary  me-3 animated slideInLeft" >
                Order now
            </a>
        
        <?php else : ?> 
            <a type="button" class="btn btn-primary py-2 px-4" href='login.php'>
            Login
            </a>
        <?php endif; ?>
        
        
    </div>
</nav>




<!-- Modal -->
<div class="modal fade" id="signinmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-body d-flex justify-content-around ">
        <button type="button" class="btn btn-primary">Log in</button>
        <button type="button" class="btn btn-success">Sign up</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

