<?php
include_once 'db-connection.php';
session_start();
$error_message='';

if (isset($_POST['login']))
 {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Fetch both username and password from the database for the given username
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
           if (password_verify($password, $data['password'])) {
                $_SESSION['name'] = $data['name'];
                $_SESSION['id'] = $data['id'];
                $_SESSION['role'] = $data['role'];

                if($data['role'] =='-1')
                {
                    header('Location:admin/index.php');
                    exit();
                }
                else{
                    header("Location: index.php");
                    exit();
                }

                
            } else {
                $error_message='password is incorrect';
            }
        } else {
            $error_message="Email not found.";
        }
    } else {
        $error_message="Error in query execution: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
    <form class='form' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h2>Login</h2>
        <?php if (!empty($error_message)) { ?>
            <div style="color: red; margin-bottom: 10px;"><?php echo $error_message; ?></div>
        <?php } ?>

        <input type="email" name="email" placeholder="email" autocomplete="email" class="input-field" required />
        <input type="password" name="password" placeholder="your password" autocomplete="password" class="input-field" required />
        <span>Not have an account <a href="signup.php">Sign up</a></span>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>