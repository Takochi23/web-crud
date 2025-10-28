<?php

session_start();
 
// hapus semua variabel sesi
$_SESSION = array();
 
// hancurkan sesi
session_destroy();
 
// alihkan ke halaman login
header("location: login.php");
exit;
?>