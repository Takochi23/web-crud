<?php
// Hubungkan ke file konfigurasi
require_once "config.php";

// Inisialisasi variabel
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$register_success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validasi username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Silakan masukkan username.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "Username ini sudah digunakan.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Terjadi kesalahan.";
            }
            $stmt->close();
        }
    }

    // Validasi password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Silakan masukkan password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password minimal harus 6 karakter.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validasi konfirmasi password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Silakan konfirmasi password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password tidak cocok.";
        }
    }

    // Jika tidak ada error, masukkan ke database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute()) {
                // Alihkan ke halaman login setelah registrasi berhasil
                header("location: login.php?registration=success");
                exit();
            } else {
                echo "Oops! Terjadi kesalahan.";
            }
            $stmt->close();
        }
    }
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="particle-container"></div>

    <div class="login-card" id="loginCard">
        <h2>Daftar Akun</h2>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username); ?>" required>
                <?php if(!empty($email_err)) echo '<div class="error-message">'.$email_err.'</div>'; ?>
            
            <div class="input-box">
                <br>
                <br>
                <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($username); ?>" required>
                <?php if(!empty($username_err)) echo '<div class="error-message">'.$username_err.'</div>'; ?>
            </div>    
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                 <?php if(!empty($password_err)) echo '<div class="error-message">'.$password_err.'</div>'; ?>
            </div>
            <div class="input-box">
                <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                 <?php if(!empty($confirm_password_err)) echo '<div class="error-message">'.$confirm_password_err.'</div>'; ?>
            </div>
            
            <button type="submit" class="btn-login">Daftar</button>

            <div class="extra-links">
                <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
            </div>
        </form>
    </div>    

    <script>
        const particleContainer = document.querySelector('.particle-container');
        const loginCard = document.getElementById('loginCard');
        const rotationStrength = 25;

        for (let i = 0; i < 50; i++) {
            let p = document.createElement('div');
            p.className = 'particle';
            let size = Math.random() * 5 + 1;
            p.style.cssText = `
                width: ${size}px; height: ${size}px; 
                top: ${Math.random() * 100}%; left: ${Math.random() * 100}%;
                animation-duration: ${Math.random() * 10 + 15}s;
                animation-delay: ${Math.random() * 5}s;
            `;
            particleContainer.appendChild(p);
        }

        document.body.addEventListener('mousemove', e => {
            let x = (e.clientX / window.innerWidth) - 0.5;
            let y = (e.clientY / window.innerHeight) - 0.5;
            loginCard.style.transform = `rotateY(${x * rotationStrength}deg) rotateX(${-y * rotationStrength}deg)`;
        });

        document.body.addEventListener('mouseleave', () => {
            loginCard.style.transform = 'rotateY(0deg) rotateX(0deg)';
        });
    </script>
</body>
</html>
