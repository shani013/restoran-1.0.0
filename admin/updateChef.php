<?php 
include "db-connection.php";
session_start();
if(isset($_POST['chef_id']))
{
    $chef_id = mysqli_real_escape_string($conn, $_POST['chef_id']);
    $sql = "SELECT * FROM chefs WHERE id='$chef_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $chef = mysqli_fetch_assoc($result);
    }
}
if (isset($_POST['update_chef'])) {
    $chef_id = mysqli_real_escape_string($conn, $_POST['chef_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    
    $target_file = null;

    // Check if a new file is uploaded
    if (!empty($_FILES["image"]["tmp_name"])) {
        $target_dir = "../uploads/chefs/";
        $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);
        
        // Attempt to move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Error uploading the file.";
            exit();
        }
    }

    // Prepare SQL query to update the product
    if ($target_file) {
        $sql = "UPDATE chefs SET 
                    name = '$name', 
                    designation = '$designation', 
                    image = '$target_file', 
                     
                WHERE id = '$chef_id'";
    } else {
        $sql = "UPDATE chefs SET 
                    name = '$name', 
                    designation = '$designation', 
                WHERE id = '$chef_id'";
    }

    // Execute the query and redirect
    if (mysqli_query($conn, $sql)) {
        header("Location: chefDetails.php"); // Redirect after success
        exit();
    } else {
        echo "Error updating the product: " . mysqli_error($conn);
    }
}
if(isset($_POST['cancel_update']))
{
    header("Location: chefDetails.php"); // Redirect after success
        exit();
}




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
    <title>Update Chefs</title>

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
                    <h1 class="mt-4"> Update Chefs</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update Chefs </li>
                    </ol>
                </div>
                <div class="container">
                    <div class="modal-body d-flex justify-content-center mb-4">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" class="form-control" value="<?php echo isset($chef['id']) ? $chef['id'] : ''; ?>" name="chef_id">

                            <label for="name" class="form-label">Name:</label><br>
                            <input type="text" class="form-control" value="<?php echo isset($chef['name']) ? $chef['name'] : ''; ?>" name="name"><br>

                            <label for="image" class="form-label">Select Image:</label><br>
                            <input type="file" name="image" class="form-control"><br>

                            <label for="description" class="form-label">Designation:</label><br>
                            <input type="text" class="form-control" value="<?php echo isset($chef['designation']) ? $chef['designation'] : ''; ?>" name="designation"><br>

                            <div class="modal-footer justify-content-center">
                                <button type="submit" class="btn btn-danger" name="cancel_update" >Cancel</button>
                                <button type="submit" class="btn btn-success ms-2" name="update_chef">Save</button>
                            </div>
                        </form>

                    </div>
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