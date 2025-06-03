<?php
session_start();
unset($_SESSION['doctor_id']);
unset($_SESSION['doctor_name']);
session_destroy();
header("Location: login.php");
exit();
?>