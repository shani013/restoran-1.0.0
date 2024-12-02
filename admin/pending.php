<?php 
include 'db-connection.php';
session_start();
if (isset($_POST['confirm-order'])) 
{
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // Update query
    $query = "UPDATE orders SET status = 'Y' WHERE id = '$order_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: pending.php"); // Redirect after success
        exit();
    } 
}
$query = 'SELECT 
    orders.id AS order_id,
    users.name AS username, 
    orders.status AS order_status,
    GROUP_CONCAT(products.name) AS product_names
FROM 
    orders
JOIN 
    users ON orders.user_id = users.id
JOIN 
    JSON_TABLE(
        orders.details, 
        "$[*]" 
        COLUMNS (product_id INT PATH "$.id")
    ) AS product_ids ON product_ids.product_id
JOIN 
    products ON product_ids.product_id = products.id
GROUP BY 
    orders.id, users.name, orders.status';
$result=mysqli_query($conn, $query);
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
    <title>Pending orders Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRDR/pb1lsly2a1b6DR8kk54we1rNZH+y3mgGxZ4R" crossorigin="anonymous">

        <style>
        .table thead {
            background-color: #007bff;
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
            background-color: #f1f1f1;
        }
        .table-responsive {
            margin-top: 20px;
        }
        
        </style>
    <!-- CSS Links -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
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
                        <a class="nav-link" href="charts.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="pending.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Pending Orders
                        </a>
                        <a class="nav-link" href="tables.html">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
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
                    <h1 class="mt-4">Pending Order Details</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pending Order Details</li>
                    </ol>
                </div>
                <div class="container mt-5">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Customer Name</th>
                                    <th>Order Details</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                    <?php foreach ($data as $value): ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $value['username']; ?></td>
                                            <td><?php echo $value['product_names']; ?></td>
                                            <?php if ($value['order_status'] == 'Y'): ?>
                                                <td><span class='text-success'>Delivered</span></td>
                                            <?php else: ?>
                                                <td>
                                                    <span class='text-danger'>Pending</span>
                                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                                        <input type="hidden" value="<?php echo htmlspecialchars($value['order_id']); ?>" name="order_id">
                                                        <button class="btn btn-sm btn-danger" type="submit" name="confirm-order">Confirm</button>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-dark mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-light">Copyright &copy; RESTOREN <?php echo date("Y"); ?></div>
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
        
    <!-- Bootstrap JS and jQuery -->
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-VoPF1aOmi6zBYT6n3k0PfN2dpvLppAt5T8XFLjxSY0S7Or/FTxI1qF8xbPygQDBH" crossorigin="anonymous"></script>


</body>
</html>
