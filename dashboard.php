<?php

session_start();
 
// cek jika pengguna belum login, maka alihkan ke halaman login
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* style tambahan untuk dashboard */
        .dashboard-container { text-align: center; color: white; }
        .dashboard-container h1 { font-size: 3rem; }
        .dashboard-container a { color: #f0f0f0; text-decoration: none; background: #8e44ad; padding: 10px 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Halo, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.</h1>
        <p>Anda berhasil masuk ke halaman dashboard.</p>
        <p>
            <a href="logout.php">Keluar (Logout)</a>
        </p>
    </div>
</body>
</html>