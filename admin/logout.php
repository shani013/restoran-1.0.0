<?php
session_destroy(); // End the session

header("Location: ../login.php");
// Redirect to the index page
exit();
?>
