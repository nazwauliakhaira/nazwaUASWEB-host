<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'db_nazwa_bunga');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $login_type = $_POST['login_type']; // 'user' or 'admin'

    if ($login_type == 'admin') {
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username'] = $admin['username'];
                $_SESSION['role'] = 'admin';
                header('Location: Admin.php');
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username admin tidak ditemukan!";
        }
    } else {
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['role'] = 'user';
                header('Location: index.php');
                exit;
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username user tidak ditemukan!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Nazwa Florist</title>
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

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            color: #C93756;
            margin-bottom: 20px;
        }

        .login-options {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #FFB6C1;
            border-radius: 5px;
            overflow: hidden;
        }

        .login-option {
            flex: 1;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-option.active {
            background-color: #D65DB1;
            color: white;
        }

        .input-group {
            margin-bottom: 20px;
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

        .login-button {
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

        .login-button:hover {
            background-color: #C93756;
        }

        .error-message {
            color: #C93756;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #FFF0F5;
        }

        .forgot-password, .register-link {
            display: block;
            margin-top: 10px;
            color: #D65DB1;
            text-decoration: none;
            font-size: 14px;
        }

        .register-link:hover,
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Nazwa Florist</h2>

        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="login-options">
            <div class="login-option active" onclick="setLoginType('user')">User</div>
            <div class="login-option" onclick="setLoginType('admin')">Admin</div>
        </div>

        <form method="POST" action="">
            <input type="hidden" id="login_type" name="login_type" value="user">

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
            <a href="#" class="forgot-password">Forgot password?</a>
            <a href="register.php" class="register-link">Belum punya akun? Daftar di sini</a>
        </form>
    </div>

    <script>
        function setLoginType(type) {
            document.getElementById('login_type').value = type;

            const options = document.querySelectorAll('.login-option');
            options.forEach(option => {
                option.classList.remove('active');
            });

            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
<?php $conn->close(); ?>
