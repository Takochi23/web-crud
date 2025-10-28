<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // di sini ada logika untuk mengirim email reset password.
    // untuk saat ini, kita hanya akan menampilkan pesan sukses.
    $email = htmlspecialchars($_POST['email']);
    $message = "Jika email " . $email . " terdaftar, instruksi reset password telah dikirim.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Futuristik</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="particle-container"></div>

    <div class="login-card" id="loginCard">
        <h2>Lupa Password</h2>
        <p style="margin-bottom: 20px; font-size: 0.9em; color: rgba(255,255,255,0.7);">Masukkan email untuk reset password.</p>
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <?php if(!empty($message)): ?>
                <div class="success-message"><?= $message; ?></div>
            <?php endif; ?>

            <div class="input-box">
                <input type="email" name="email" placeholder="Email Anda" required>
            </div>
            
            <button type="submit" class="btn-login">Kirim Instruksi</button>

            <div class="extra-links">
                <p>Ingat password Anda? <a href="login.php">Kembali ke Login</a>.</p>
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
