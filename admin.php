<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <title>Admin</title>

</head>

<body>

    <div class="container">
        <h2 class="text-success">Admin Panel</h2>
        <div class="container d-flex justify-content-around my-3 ">
            <!-- product trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addproduct">
                <i class="bi bi-plus-circle"></i>
                New Product
            </button>
            <!-- chefs trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addchefs">
                <i class="bi bi-plus-circle"></i>
                New Chefs
            </button>
        </div>


        <!--Product Modal -->
        <div class="modal fade" id="addproduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content ">
                    <div class="modal-header d-flex justify-content-center ">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Product Details</h1>
                    </div>
                    <div class="modal-body d-flex justify-content-center ">
                        <form action="product.php" method="post" enctype="multipart/form-data">
                            <label for="name" class="form-label ">Name:</label><br>
                            <input type="text" class="form-control" name='name'><br>
                            <label for="price" class="form-label ">price</label><br>
                            <input type="decimal" name='price' class="form-control"><br>
                            <label for="image" class="form-label ">Select Image:</label><br>
                            <input type="file" name="image" class="form-control" required><br>
                            <label for="description" class="form-label ">Description</label><br>
                            <textarea type="text" name='description' class="form-control"
                                placeholder='description of item'></textarea><br><br>
                            <div class="modal-footer justify-content-center ">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" name="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--chefs Modal-->
    <div class="modal fade" id="addchefs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content ">
                <div class="modal-header d-flex justify-content-center ">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Chefs Details</h1>
                </div>
                <div class="modal-body d-flex justify-content-center ">
                    <form action="chef.php" method="post" enctype="multipart/form-data">
                        <label for="name" class="form-label ">Name:</label><br>
                        <input type="text" class="form-control" name='name'><br>
                        <label for="designation" class="form-label ">Designation</label><br>
                        <input type="text" name='designation' class="form-control"><br>
                        <label for="image" class="form-label ">Select Image:</label><br>
                        <input type="file" name="image" class="form-control" required><br>
                        <br>
                        <div class="modal-footer justify-content-center ">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>