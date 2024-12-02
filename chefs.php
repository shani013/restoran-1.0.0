<?php
include 'db-connection.php';
$query = "SELECT * FROM chefs";
$data = mysqli_query($conn, $query);
$chefs = mysqli_fetch_all($data, MYSQLI_ASSOC);
?>
<?php foreach ($chefs as $row) { ?>
    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="team-item text-center rounded overflow-hidden">
            <div class="rounded-circle overflow-hidden m-4">
                <img class="img-fluid" src="<?php echo str_replace('../', '', $row['image']); ?>">
            </div>
            <h5 class="mb-0"><?php echo $row['name']; ?></h5>
            <small><?php echo $row['designation']; ?></small>
            <div class="d-flex justify-content-center mt-3">
                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-square btn-primary mx-1" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
<?php } ?>