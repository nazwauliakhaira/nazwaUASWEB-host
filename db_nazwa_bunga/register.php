<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'db_nazwa_bunga');
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah dipakai
        $check = $conn->query("SELECT * FROM user WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $error = "Username sudah terdaftar!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Simpan ke database
            $sql = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
                header('Location: login.php');
                exit;
            } else {
                $error = "Terjadi kesalahan: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Nazwa Florist</title>
    <style>
        body {
            background-color: #FFD1DC;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }

        .register-container h2 {
            color: #C93756;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #5A3D5C;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #FFB6C1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .register-button {
            width: 100%;
            padding: 10px;
            background-color: #D65DB1;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .register-button:hover {
            background-color: #C93756;
        }

        .error-message {
            color: #C93756;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #FFF0F5;
        }

        .login-link {
            margin-top: 15px;
            font-size: 14px;
            color: #D65DB1;
            display: block;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register Nazwa Florist</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="input-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <button type="submit" class="register-button">Register</button>
            <a class="login-link" href="login.php">Sudah punya akun? Login</a>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
