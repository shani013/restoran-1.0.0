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
            <?php if (isset($_SESSION['order-id'])):?>
                <?php 
                $query = "SELECT status FROM orders WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['order-id']); // assuming 'id' is an integer
                $stmt->execute();
                $result = $stmt->get_result();
                $order = $result->fetch_assoc();
                ?>
                <?php if($order['status']=='Y'):?>
                    <a data-bs-toggle="order-in-progress" title="Rider is on the way">
                        
                        <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                            width="50px" height="50px" viewBox="0 0 512.000000 512.000000"
                            preserveAspectRatio="xMidYMid meet">
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)" fill="#228B22" stroke="none">
                                <!-- Delivery vehicle design -->
                                <path class="cycling-path" d="M1657 5036 c-26 -7 -71 -29 -100 -49 -28 -20 -343 -328 -698 -684
                                -735 -737 -703 -698 -704 -853 0 -152 -4 -148 492 -641 402 -401 432 -428 487
                                -448 59 -22 155 -29 208 -16 25 6 28 3 49 -47 19 -46 85 -116 500 -533 l478
                                -480 3 -475 3 -475 28 -57 c47 -96 125 -146 241 -155 139 -11 249 48 302 162
                                l24 50 0 560 0 559 -310 311 c-170 171 -310 315 -310 320 0 6 168 177 372 382
                                l373 373 210 -210 211 -210 452 0 c491 0 485 -1 560 57 75 57 104 189 61 283
                                -27 60 -54 88 -114 116 -50 24 -53 24 -400 24 l-350 0 -414 414 c-266 266
                                -428 421 -452 431 l-37 17 14 35 c42 100 38 211 -13 304 -16 30 -172 193 -456
                                477 l-432 430 -69 21 c-77 24 -139 26 -209 7z m171 -166 c30 -14 159 -136 451
                                -427 385 -384 410 -411 420 -455 8 -36 8 -60 0 -95 -11 -45 -47 -84 -668 -707
                                -380 -381 -670 -664 -688 -672 -42 -18 -117 -18 -157 1 -17 8 -217 201 -443
                                428 -369 369 -413 417 -423 456 -13 48 -9 85 15 135 8 17 309 325 668 683 512
                                511 660 654 687 661 54 16 91 13 138 -8z m1392 -1695 l436 -435 372 0 373 0
                                24 -25 c31 -30 32 -73 4 -109 l-20 -26 -412 0 -412 0 -225 225 c-218 218 -226
                                225 -265 225 -39 0 -47 -7 -492 -453 -443 -443 -453 -453 -453 -491 0 -39 9
                                -49 328 -368 l327 -329 3 -509 c3 -563 4 -553 -60 -586 -49 -25 -141 -15 -176
                                19 l-27 27 -5 499 -5 498 -495 502 c-272 276 -499 512 -504 525 -24 63 -28 59
                                582 669 l577 577 45 0 44 0 436 -435z"/>
                                <path d="M1775 4155 c-42 -41 -34 -77 32 -146 l57 -60 -27 -55 -28 -56 -44 41
                                c-43 40 -72 49 -110 35 -9 -4 -50 -51 -91 -105 -41 -55 -78 -99 -81 -99 -4 0
                                -70 63 -148 139 -129 127 -146 141 -198 156 -92 27 -177 3 -244 -67 -67 -69
                                -85 -185 -42 -270 26 -53 258 -290 317 -325 25 -15 48 -38 56 -57 8 -17 70
                                -86 138 -153 109 -107 129 -123 158 -123 27 0 79 34 302 202 148 110 278 212
                                288 226 37 47 28 67 -82 179 l-103 104 58 113 c31 62 57 126 57 142 0 22 -19
                                47 -88 116 -75 74 -93 88 -121 88 -21 0 -41 -9 -56 -25z m-538 -437 c119 -119
                                133 -136 133 -167 0 -47 -33 -81 -79 -81 -32 0 -48 12 -168 133 -118 118 -133
                                137 -133 167 0 47 33 80 79 80 32 0 48 -12 168 -132z m578 -118 c60 -60 107
                                -111 104 -113 -15 -13 -367 -275 -378 -281 -9 -6 -33 11 -76 54 l-64 63 39 28
                                c39 28 90 103 90 131 0 16 156 228 168 228 4 0 57 -49 117 -110z"/>
                                <path d="M3387 4379 c-109 -26 -234 -127 -285 -232 -64 -130 -64 -267 0 -397
                                82 -168 276 -270 458 -241 133 21 273 119 330 230 77 152 63 338 -38 474 -49
                                68 -140 132 -219 157 -69 21 -177 25 -246 9z m233 -179 c61 -30 97 -66 127
                                -124 96 -189 -38 -406 -252 -406 -316 1 -386 435 -88 546 54 20 157 13 213
                                -16z"/>
                                <path d="M3821 2234 c-23 -30 -27 -71 -8 -95 24 -32 56 -39 171 -39 l116 0 0
                                -59 c0 -52 3 -62 26 -80 37 -29 70 -26 105 8 24 25 29 38 29 79 l0 50 126 4
                                c118 3 127 4 145 27 26 32 25 82 -4 109 -23 22 -28 22 -354 22 l-332 0 -20
                                -26z"/>
                                <path d="M945 1880 c-158 -22 -316 -87 -440 -183 -145 -111 -268 -299 -316
                                -482 -30 -111 -32 -309 -5 -415 80 -313 291 -545 588 -646 145 -49 350 -57
                                498 -19 79 21 209 80 283 129 164 109 303 307 359 511 29 108 31 326 4 429
                                -105 393 -422 656 -821 679 -49 3 -117 2 -150 -3z m272 -175 c134 -31 271
                                -112 366 -214 72 -79 121 -162 160 -276 27 -81 31 -102 31 -210 0 -134 -21
                                -229 -73 -333 -170 -336 -573 -489 -921 -349 -172 70 -321 213 -395 380 -82
                                189 -78 432 11 610 101 201 263 331 489 392 68 18 255 18 332 0z"/>
                                <path d="M4045 1880 c-103 -14 -186 -39 -280 -85 -242 -117 -404 -314 -477
                                -582 -30 -111 -30 -325 0 -435 95 -348 375 -602 726 -659 94 -15 266 -7 356
                                16 36 10 103 35 148 56 391 181 598 610 493 1024 -26 101 -106 262 -171 342
                                -183 227 -515 362 -795 323z m274 -176 c148 -36 298 -131 394 -249 58 -72 121
                                -196 144 -285 22 -87 22 -253 -1 -345 -61 -250 -250 -447 -506 -527 -108 -33
                                -292 -33 -400 0 -205 64 -360 194 -450 377 -56 114 -73 190 -74 320 0 133 17
                                205 78 330 91 185 273 331 474 380 80 19 261 19 341 -1z"/>
                            </g>
                            
                            <!-- Animation for moving vehicle -->
                            <animateTransform 
                                attributeName="transform" 
                                type="translate" 
                                from="0 0" 
                                to="131 0" 
                                dur="3s" 
                                repeatCount="indefinite" 
                                keyTimes="0; 1" 
                                values="0 0; 131 0"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 100" width="80" height="100">
                            <!-- Road (transparent background) -->
                            <rect x="0" y="80" width="60" height="20" fill="none" />
                            
                            <!-- Smoke-like dust particles -->
                            <path class="dust" d="M20,75 Q25,70 30,75 Q25,80 20,75 Z" fill="rgba(169, 169, 169, 0.8)">
                                <animate attributeName="d" values="M20,75 Q25,70 30,75 Q25,80 20,75 Z; M240,75 Q245,70 250,75 Q245,80 240,75 Z" dur="7.1s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M50,78 Q55,73 60,78 Q55,83 50,78 Z" fill="rgba(169, 169, 169, 0.7)">
                                <animate attributeName="d" values="M50,78 Q55,73 60,78 Q55,83 50,78 Z; M270,78 Q275,73 280,78 Q275,83 270,78 Z" dur="7.2s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M90,77 Q95,72 100,77 Q95,82 90,77 Z" fill="rgba(169, 169, 169, 0.6)">
                                <animate attributeName="d" values="M90,77 Q95,72 100,77 Q95,82 90,77 Z; M340,77 Q345,72 350,77 Q345,82 340,77 Z" dur="7.2s" repeatCount="indefinite" />
                            </path>

                            <!-- More smoke-like dust particles with adjusted size -->
                            <path class="dust" d="M120,75 Q125,70 130,75 Q125,80 120,75 Z" fill="rgba(169, 169, 169, 0.7)">
                                <animate attributeName="d" values="M120,75 Q125,70 130,75 Q125,80 120,75 Z; M380,75 Q385,70 390,75 Q385,80 380,75 Z" dur="7.3s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M150,77 Q255,72 160,77 Q255,82 150,77 Z" fill="rgba(169, 169, 169, 0.5)">
                                <animate attributeName="d" values="M150,77 Q255,72 160,77 Q255,82 150,77 Z; M400,77 Q405,72 410,77 Q405,82 400,77 Z" dur="7.5s" repeatCount="indefinite" />
                            </path>

                            <!-- Additional smoke-like dust particles -->
                            <path class="dust" d="M180,75 Q185,70 190,75 Q185,80 180,75 Z" fill="rgba(169, 169, 169, 0.6)">
                                <animate attributeName="d" values="M180,75 Q185,70 190,75 Q185,80 180,75 Z; M380,75 Q385,70 390,75 Q385,80 380,75 Z" dur="7.5s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M160,78 Q185,73 170,78 Q185,83 160,78 Z" fill="rgba(169, 169, 169, 0.5)">
                                <animate attributeName="d" values="M160,78 Q165,73 170,78 Q165,83 160,78 Z; M370,78 Q375,73 380,78 Q375,83 370,78 Z" dur="7.6s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M110,74 Q115,69 120,74 Q185,79 110,74 Z" fill="rgba(169, 169, 169, 0.7)">
                                <animate attributeName="d" values="M110,74 Q115,69 120,74 Q115,79 110,74 Z; M340,74 Q345,69 350,74 Q345,79 340,74 Z" dur="7.7s" repeatCount="indefinite" />
                            </path>

                            <path class="dust" d="M180,77 Q185,72 190,77 Q185,82 180,77 Z" fill="rgba(169, 169, 169, 0.6)">
                                <animate attributeName="d" values="M180,77 Q185,72 190,77 Q185,82 180,77 Z; M380,77 Q385,72 390,77 Q385,82 380,77 Z; M190,80 Q195,75 200,80 Q195,85 190,80 Z" dur="7.8s" repeatCount="indefinite" />
                            </path>

                        </svg>
                    </a>
                <?php else: ?>    
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Order in Progress">
                        <i class="bi bi-info-circle text-danger" style="font-size: 30px;" ></i>
                    </a>
                <?php endif;?>
            <?php endif; ?>
        <?php else: ?>
            <!-- Login Button if not logged in -->
            <a type="button" class="btn btn-primary py-2 px-4 ms-3" href='login.php'>
                Login
            </a>
        <?php endif; ?>
    </div>
</nav>

        
<?php
         

?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    // Initialize Bootstrap Tooltip
    var tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="order-in-progress"]');
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
    // Initialize tooltips for elements with data-bs-toggle="tooltip"
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>




