<?php
$conn = new mysqli("localhost", "root", "", "db_nazwa_bunga");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_POST['gambar']; // pastikan link gambar sudah valid atau bisa pakai upload

    $sql = "INSERT INTO produk (nama, harga, deskripsi, gambar) 
            VALUES ('$nama', '$harga', '$deskripsi', '$gambar')";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_admin.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
</head>
<body>
    <h2>Tambah Produk Baru</h2>
    <form method="POST">
        <label>Nama Produk:</label><br>
        <input type="text" name="nama" required><br><br>

        <label>Harga:</label><br>
        <input type="number" name="harga" required><br><br>

        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" required></textarea><br><br>

        <label>URL Gambar:</label><br>
        <input type="text" name="gambar" required><br><br>

        <button type="submit">Simpan</button>
    </form>
    <br>
    <a href="dashboard_admin.php">Kembali ke Dashboard</a>
</body>
</html>
