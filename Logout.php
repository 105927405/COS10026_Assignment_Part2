<?php
session_start();
session_unset();   
session_destroy();  

header("Location: Login_Page.php?message=" . urlencode("You have been signed out successfully."));
exit();
?>