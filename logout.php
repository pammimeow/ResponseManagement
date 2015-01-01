<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['formname']);
unset($_SESSION['receparray']);
unset($_SESSION['recepadded']);
unset($_SESSION['new']);

header('Location:login.php');
?>