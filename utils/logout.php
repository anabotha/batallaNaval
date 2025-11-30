<?php
session_start();
session_destroy();
header("Location: ../login/loginView.php");
exit;
?>