<?php
session_start();
session_destroy();
header('Location: index.php');
exit; 
// session_unset();
// session_destroy();
// header("Location: index.php");
// exit();
?>
