<?php
//koneksi database
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'dbkampus');

// membuat koneksi ke msql
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// cek koneksi
if($mysqli === false){
    die("Tidak dapat terhubung. " . $mysqli->connect_error);
}

?>