<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: AdmindanUserLogin.php");
    exit;
}

$username = $_SESSION['username'];

// Ambil data user dari tabel_user
$sql = "SELECT * FROM tabel_user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$user = $result->fetch_assoc();

if (!$user) {
    echo "❌ Data user tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

  <h2 class="mb-4">👤 Profil Pengguna</h2>
  <table class="table table-bordered w-50">
    <tr>
      <th>ID</th>
      <td><?= $user['id']; ?></td>
    </tr>
    <tr>
      <th>Username</th>
      <td><?= htmlspecialchars($user['username']); ?></td>
    </tr>
    <tr>
      <th>Password</th>
      <td><?= htmlspecialchars($user['password']); ?></td>
    </tr>
    <tr>
      <th>role</th>
      <td><?= htmlspecialchars($user['role']); ?></td>
    </tr>
    <tr>
      <th>No HP</th>
      <td><?= htmlspecialchars($user['no_hp']); ?></td>
    </tr>
    <tr>
      <th>Alamat</th>
      <td><?= htmlspecialchars($user['alamat']); ?></td>
    </tr>
  </table>

  <a href="katalog.php" class="btn btn-secondary mt-3">⬅ Kembali ke Katalog</a>

</body>
</html>