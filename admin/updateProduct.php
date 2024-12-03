<?php 
include "db-connection.php";
session_start();
if(isset($_POST['product_id']))
{
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $sql = "SELECT * FROM products WHERE id='$product_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $product = mysqli_fetch_assoc($result);
    }
}
if (isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $target_file = null;

    // Check if a new file is uploaded
    if (!empty($_FILES["image"]["tmp_name"])) {
        $target_dir = "../uploads/products/";
        $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);
        
        // Attempt to move the uploaded file
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Error uploading the file.";
            exit();
        }
    }

    // Prepare SQL query to update the product
    if ($target_file) {
        $sql = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    image = '$target_file', 
                    price = '$price' 
                WHERE id = '$product_id'";
    } else {
        $sql = "UPDATE products SET 
                    name = '$name', 
                    description = '$description', 
                    price = '$price' 
                WHERE id = '$product_id'";
    }

    // Execute the query and redirect
    if (mysqli_query($conn, $sql)) {
        header("Location: productDetails.php"); // Redirect after success
        exit();
    } else {
        echo "Error updating the product: " . mysqli_error($conn);
    }
}
if(isset($_POST['cancel_update']))
{
    header("Location: productDetails.php"); // Redirect after success
        exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="css/styles.css" rel="stylesheet">
    <!-- Font Awesome CDN -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    
</head>
<body>
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
                            <div class="sb-nav-link-icon text-light"><i class="fas fa-tachometer-alt"></i>Dashboard</div>
                        </a> 
                        
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="pending.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-hourglass-split"></i></div>
                            Pending Orders
                        </a>
                        <a class="nav-link" href="productDetails.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-clipboard"></i></div>
                            Products
                        </a>
                        <a class="nav-link" href="chefDetails.php">
                            <div class="sb-nav-link-icon "><i class="bi bi-egg-fried"></i></div>
                            Chefs
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
                    <h1 class="mt-4">Update Product</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item " ><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Update product</li>
                    </ol>
                    <div class="container">
                        <div class="modal-body d-flex justify-content-center mb-4">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" class="form-control" value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>" name="product_id">

                                <label for="name" class="form-label">Name:</label><br>
                                <input type="text" class="form-control" value="<?php echo isset($product['name']) ? $product['name'] : ''; ?>" name="name"><br>

                                <label for="price" class="form-label">Price:</label><br>
                                <input type="number" step="0.01" name="price" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" class="form-control"><br>

                                <label for="image" class="form-label">Select Image:</label><br>
                                <input type="file" name="image" class="form-control"><br>

                                <label for="description" class="form-label">Description:</label><br>
                                <textarea name="description" class="form-control" placeholder="description of item">
                                    <?php echo isset($product['description']) ? $product['description'] : ''; ?>
                                </textarea><br>

                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-danger" name="cancel_update" >Cancel</button>
                                    <button type="submit" class="btn btn-success ms-2" name="update_product">Save</button>
                                </div>
                            </form>

                        </div>
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
    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
</body>
</html>