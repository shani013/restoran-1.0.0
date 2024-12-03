<?php 
include 'db-connection.php';
session_start();
    $query = "SELECT * FROM chefs";
    $result = mysqli_query($conn, $query);
    $data=mysqli_fetch_all($result,MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>
<body>
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Products</title>
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
                background-color: #f1f1f1;
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
                            Charts
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
                            <div class="sb-nav-link-icon text-light"><i class="bi bi-egg-fried"></i>Chefs</div>
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
                    <h1 class="mt-4">Chefs</h1>
                    <div class="container-fluid d-flex justify-content-between">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Chefs details</li>
                        </ol>
                        <button class="btn  btn-success" data-bs-toggle="modal" data-bs-target="#addchefs" >
                            New Chef
                            <i class="bi bi-plus-circle"></i>
                        </button>
                        <!--chefs Modal-->
                        <div class="modal fade" id="addchefs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog ">
                                <div class="modal-content ">
                                    <div class="modal-header d-flex justify-content-center ">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Chefs Details</h1>
                                    </div>
                                    <div class="modal-body d-flex justify-content-center ">
                                        <form action="addChef.php" method="post" enctype="multipart/form-data">
                                            <label for="name" class="form-label ">Name:</label><br>
                                            <input type="text" class="form-control" name='name' required><br>
                                            <label for="designation" class="form-label ">Designation</label><br>
                                            <input type="text" name='designation' class="form-control" required><br>
                                            <label for="image" class="form-label ">Select Image:</label><br>
                                            <input type="file" name="image" class="form-control" required><br>
                                            <br>
                                            <div class="modal-footer justify-content-center ">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary" name="add-chef">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Image</th>
                                    <th>Chef Name</th>
                                    <th>Designation</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1;?>
                                <?php foreach($data as $chef): ?>
                                <tr>
                                    <td><?php echo $count++?></td>
                                    <td>
                                        <img src="<?php echo $chef['image'];?>" alt="<?php echo $chef['name'];?>" style="width: 60px; height: 60px;">
                                    </td>
                                    <td><?php echo $chef['name'];?></td>
                                    <td >
                                        
                                            <?php echo $chef['designation'];?>
                                        
                                    </td>
                                    <td >
                                        <form action="updateChef.php" method="post" class="m-0 p-0" style="display:inline;">
                                            <input type="hidden" value="<?php echo $chef['id']; ?>" name="chef_id">
                                            <button class="btn btn-sm btn-success" type="submit">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </form>
                                        <form action="deleteChef.php" method="post" class="m-0 p-0" style="display:inline;">
                                            <input type="hidden" value="<?php echo $chef['id']; ?>" name="chef_id">
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>

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