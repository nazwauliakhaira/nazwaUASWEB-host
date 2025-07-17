<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "db_nazwa_bunga");

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $check = $conn->query("SELECT * FROM admin WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        // Simpan ke database
        $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$hashedPassword')";
        if ($conn->query($sql)) {
            $success = "Registrasi berhasil! Silakan login.";
        } else {
            $error = "Gagal menyimpan data.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Admin</title>
    <style>
        body {
            font-family: Arial;
            background: #f3f3f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
        }
        .message {
            margin-top: 15px;
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>Register Admin</h2>
    <form method="POST" action="">
        <label>Username</label>
        <input type="text" name="username" required>
        
        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Daftar</button>
    </form>

    <?php if (isset($error)): ?>
        <div class="message"><?= $error ?></div>
    <?php elseif (isset($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php endif; ?>
</div>

</body>
</html>
