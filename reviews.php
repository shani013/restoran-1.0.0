<?php
include 'db-connection.php';
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $target_dir = "uploads/reviews/";

    // Generate a unique file name to prevent overwriting
    $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $sql = "INSERT INTO reviews (name,profession,email,images,message) VALUES ('$name','$profession','$email','$target_file','$message')";
        $result = mysqli_query($conn, $sql);
        header("Location: index.php");
        exit();
    }

} else {

    $query = "SELECT * FROM reviews";
    $data = mysqli_query($conn, $query);
    $reviews = mysqli_fetch_all($data, MYSQLI_ASSOC);
}

?>
<?php foreach ($reviews as $row) { ?>
    <div class="testimonial-item bg-transparent border  p-4" style="border-radius:40px;">
        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
        <p><?php echo $row['message']; ?></p>
        <div class="d-flex align-items-center">
            <img class="img-fluid flex-shrink-0 rounded-circle" src="<?php echo $row['images']; ?>"
                style="width: 70px; height: 70px;">
            <div class="ps-3">
                <h5 class="mb-1"><?php echo $row['name']; ?></h5>
                <small><?php echo $row['profession']; ?></small>
            </div>
        </div>
    </div>

<?php } ?>