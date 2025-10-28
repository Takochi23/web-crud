<?php
session_start();
 
// alihkan jika pengguna sudah login
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: data_mahasiswa.php");
    exit;
}
 
require_once "config.php";
 
$username = $password = "";
$login_err = "";
 
// proses form saat dikirim
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $login_err = "Silakan masukkan username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $login_err = "Silakan masukkan password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($login_err)){
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            
            if($stmt->execute()){
                $stmt->store_result();
                
                if($stmt->num_rows == 1){                    
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Jika password benar, mulai sesi
                            session_start();
                            
                            // Simpan data ke sesi
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Alihkan ke halaman data mahasiswa
                            header("location: data_mahasiswa.php");
                        } else{
                            $login_err = "Username atau password salah.";
                        }
                    }
                } else{
                    $login_err = "Username atau password salah.";
                }
            } else{
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
    <title>Daftar Akun - Futuristik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="particle-container"></div>

    <div class="login-card" id="loginCard">
        <h2>Login</h2>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <?php 
            if(!empty($login_err)){
                echo '<div class="error-message">' . $login_err . '</div>';
            }        
            ?>

            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-login">Masuk</button>
            <div class="extra-links">
                <p>Tidak punya akun? <a href="register.php">Daftar</a></p>
                <p> <a href="reset_password.php">Lupa Password?</a></p>
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
                width: ${size}px; 
                height: ${size}px; 
                top: ${Math.random() * 100}%; 
                left: ${Math.random() * 100}%;
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