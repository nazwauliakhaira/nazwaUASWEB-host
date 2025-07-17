<?php
session_start();
$conn = new mysqli("localhost", "root", "", "db_nazwa_bunga");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
        a {
            text-decoration: none;
            padding: 8px 12px;
            background: #4CAF50;
            color: white;
            border-radius: 4px;
            margin-bottom: 10px;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #555;
            color: white;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-btn { background-color: #ffa500; color: white; }
        .delete-btn { background-color: #dc3545; color: white; }
    </style>
</head>
<body>

    <h2>Dashboard Admin - Produk</h2>
    <a href="form_tambah.php">+ Tambah Produk</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM produk";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Id']}</td>
                        <td>{$row['nama']}</td>
                        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                        <td>{$row['deskripsi']}</td>
                        <td><img src='{$row['gambar']}' width='100'></td>
                        <td>
                            <a class='action-btn edit-btn' href='form_edit.php?id={$row['Id']}'>Edit</a>
                            <a class='action-btn delete-btn' href='hapus.php?id={$row['Id']}' onclick=\"return confirm('Yakin ingin menghapus produk ini?');\">Hapus</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
