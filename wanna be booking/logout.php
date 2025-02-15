<?php
session_start();
include 'track_visit.php';
session_unset();
session_destroy();
header('Location: login.php');
exit;
?>
