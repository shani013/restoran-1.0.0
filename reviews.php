<?php
include 'db-connection.php';
if (isset($_POST['submit'])) {
    session_start();
    
        $user_id=$_SESSION['id'];
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        $profession = mysqli_real_escape_string($conn, $_POST['profession']);
        $target_dir = "../uploads/reviews/";
        // Generate a unique file name to prevent overwriting
        $target_file = $target_dir . uniqid() . basename($_FILES["image"]["name"]);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

            $sql = "INSERT INTO reviews (user_id,image,message,profession) VALUES ('$user_id','$target_file','$message','$profession')";
            $result = mysqli_query($conn, $sql);
            header("Location: index.php");
            exit();
        }  
}
else {
   $query = "SELECT 
    users.name AS name,
    reviews.image AS image,
    reviews.profession AS profession,
    reviews.message AS message
FROM 
    reviews 
JOIN 
    users ON reviews.user_id = users.id;";
    $data = mysqli_query($conn, $query);
    $reviews = mysqli_fetch_all($data, MYSQLI_ASSOC);
}
?>

<?php foreach ($reviews as $row) { ?>
    <div class="testimonial-item bg-transparent border p-4" style="border-radius:40px;">
        <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
        <p><?php echo $row['message']; ?></p>
        <div class="d-flex align-items-center">
            <img class="img-fluid flex-shrink-0 rounded-circle" src="<?php echo str_replace('../', '', $row['image']); ?>"
                style="width: 70px; height: 70px;">
            <div class="ps-3">
                <h5 class="mb-1"><?php echo $row['name']; ?></h5>
                <small><?php echo $row['profession']; ?></small>
            </div>
        </div>
    </div>


<?php } ?>
