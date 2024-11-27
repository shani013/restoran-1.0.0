<?php
include_once 'db-connection.php';
session_start();
$error_message='';
if(isset($_POST['signin']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $phone = $_POST['phone'];
    $role='1';

    $query="SELECT email FROM users WHERE email='$email'";
    $result=mysqli_query($conn,$query);
    $data=mysqli_fetch_assoc($result);

    if($data)
    {
        $error_message="Email already exists";
    }
    else
    {
        $query = "INSERT INTO users(name,phone,email, password,role) VALUES ('$name','$phone', '$email', '$password','$role')";
        if(mysqli_query($conn,$query))
        {
            $_SESSION['name'] = $name;
            header('location:login.php');
            exit();
        }
        else
        {
            $error_message="Failed to insert data";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup.css">

        <title>signUp</title>
</head>

<body >
    <form class="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <h2>Sign up</h2>
        <span style="color: red;"><?php echo $error_message;?></span>
        <input type="text" placeholder="Name" name="name">
        <input type="email" placeholder="email" name="email">
        <input type="tel" placeholder="Enter you phone" name="phone">
        <input type="password" placeholder="password" name="password">
        <button class='btn' type="submit" name="signin">Sign in</button>
        <br>
        <span>Already have account <a href="login.php">Login</a> </span> 
    </form> 
</body>
</html>