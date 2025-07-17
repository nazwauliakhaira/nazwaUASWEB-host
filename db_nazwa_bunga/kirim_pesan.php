<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_nazwa_bunga";

$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari form
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

// Simpan ke database
$sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    // Redirect ke index.php dengan pesan sukses (opsional)
    header("Location: index.php?status=sukses");
    exit();
} else {
    // Redirect ke index.php dengan pesan error
    header("Location: index.php?status=gagal");
    exit();
}

$stmt->close();
$conn->close();
?>
