<?php
include "db-connection.php";
session_start();
if(!isset($_SESSION['role'] ) || $_SESSION['role'] !='-1')
{
    header("Location: ../404.php");
    exit;
}
$query="SELECT 
    u.name AS name,
    u.phone AS phone,
    u.email AS email,
    COUNT(o.user_id) AS count,
    c.address AS address
FROM 
    users u
JOIN 
    customers c ON u.id = c.user_id
LEFT JOIN 
    orders o ON u.id = o.user_id
GROUP BY 
    u.id, u.name, c.address";
$result = mysqli_query($conn, $query);
$data=mysqli_fetch_all($result,MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Customers</title>
        <style>
            .table thead {
                background-color: #fea116;
                color: #fff;
            }
            .table th, .table td {
                text-align: center;
                vertical-align: middle;
            }
            .table-striped tbody tr:nth-child(odd) {
                background-color: #f9f9f9;
            }
            .table-hover tbody tr:hover {
                background-color: #fea116;
            }
            .table-responsive {
                margin-top: 20px;
            }
        </style>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Restoren</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Add left-aligned content here if needed -->
            </ul>
            <ul class="navbar-nav ">
                <!-- User Info Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i> <?php echo $_SESSION['name']; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="#!"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="#!"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a> 
                        
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Stats
                        </a>
                        <a class="nav-link" href="pending.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Pending Orders
                        </a>
                        <a class="nav-link" href="productDetails.php">
                            <div class="sb-nav-link-icon "><i class="bi bi-clipboard"></i></div>
                            Products
                        </a>
                        <a class="nav-link" href="chefDetails.php">
                            <div class="sb-nav-link-icon "><i class="bi bi-egg-fried"></i></div>
                            Chefs
                        </a>
                        <a class="nav-link" href="customers.php">
                            <div class="sb-nav-link-icon text-light"><i class="bi bi-people-fill"></i>Customers</div>
                        </a>
                        <a class="nav-link" href="reviews.php">
                            <div class="sb-nav-link-icon "><i class="bi bi-chat-left-dots"></i></div>
                            Reviews
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['name'] ;?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Customers</h1>
                    <div class="container-fluid d-flex justify-content-between">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Customers details</li>
                        </ol>
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Customer Name</th>
                                    <th>Total Orders</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;?>
                                <?php foreach($data as $customer): ?>
                                <tr>
                                    <td><?php echo $count++?></td>
                                    <td ><?php echo $customer['name'];?></td>
                                    <td ><?php echo $customer['count'];?></td>
                                    <?php 
                                        // Address string
                                        $address = $customer['address']; 
                                        // Split the address by the first comma
                                        $address_parts = explode(',', $address, 3);

                                        // Handle if the address contains at least two commas
                                        if (count($address_parts) >= 3) {
                                            $city = trim($address_parts[0]);      // First part (city)
                                            $province = trim($address_parts[1]);  // Second part (province)
                                            $remaining_address = trim($address_parts[2]); // Rest of the address (after the second comma)
                                        } else {
                                            // If the address format doesn't match the expected structure, fallback to original address
                                            $city = $province = $remaining_address = $address; // Fallback to the full address
                                        }
                                    ?>
                                    <td class="col-3"><?php echo $remaining_address;?></td>
                                    <td><?php echo $city;?></td>
                                    <td ><?php echo $province;?></td>
                                    <td class="col-2"><?php echo $customer['phone'];?></td>
                                    <td ><?php echo $customer['email'];?></td>

                                    
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>   
                        
                    </div>

            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-white">Copyright &copy; RESTOREN <?php echo date("Y"); ?></div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
</body>
</html>