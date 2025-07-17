<?php
$conn = new mysqli("localhost", "root", "", "db_nazwa_bunga");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM produk WHERE Id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard_admin.php");
        exit();
    } else {
        echo "Gagal menghapus: " . $conn->error;
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
