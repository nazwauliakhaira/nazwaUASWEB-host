<?php
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'penjualan_bunga');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data produk
$products = [];
$sql = "SELECT * FROM produk";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Ambil data pesanan
$orders = [];
$sql = "SELECT * FROM pesanan ORDER BY tanggal DESC LIMIT 5";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Hitung total produk dan pesanan
$totalProducts = $conn->query("SELECT COUNT(*) as total FROM produk")->fetch_assoc()['total'];
$totalOrders = $conn->query("SELECT COUNT(*) as total FROM pesanan")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - Bunga Mekar Indah</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        .header {
            background: linear-gradient(to right, #ff1493, #ff69b4);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .sidebar {
            width: 250px;
            background: white;
            height: calc(100vh - 56px);
            position: fixed;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            border-bottom: 1px solid #eee;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: #ff69b4;
            color: white;
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .card h3 {
            margin-top: 0;
            color: #555;
            font-size: 1rem;
        }
        
        .card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #ff1493;
            margin: 10px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background: #ff69b4;
            color: white;
        }
        
        tr:hover {
            background: #fff5f9;
        }
        
        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .btn-edit {
            background: #4CAF50;
            color: white;
        }
        
        .btn-delete {
            background: #f44336;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.8;
        }
        
        .section-title {
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ff69b4;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard Admin - Bunga Mekar Indah</h1>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    
    <div class="sidebar">
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active"><i>🏠</i> Dashboard</a></li>
            <li><a href="produk.php"><i>🌹</i> Kelola Produk</a></li>
            <li><a href="pesanan.php"><i>📦</i> Kelola Pesanan</a></li>
            <li><a href="pelanggan.php"><i>👥</i> Data Pelanggan</a></li>
            <li><a href="laporan.php"><i>📊</i> Laporan</a></li>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="card-container">
            <div class="card">
                <h3>Total Produk</h3>
                <div class="number"><?php echo $totalProducts; ?></div>
                <a href="produk.php">Lihat Semua</a>
            </div>
            
            <div class="card">
                <h3>Total Pesanan</h3>
                <div class="number"><?php echo $totalOrders; ?></div>
                <a href="pesanan.php">Lihat Semua</a>
            </div>
            
            <div class="card">
                <h3>Pendapatan Bulan Ini</h3>
                <div class="number">Rp 5.250.000</div>
                <a href="laporan.php">Lihat Detail</a>
            </div>
            
            <div class="card">
                <h3>Pelanggan Baru</h3>
                <div class="number">12</div>
                <a href="pelanggan.php">Lihat Semua</a>
            </div>
        </div>
        
        <h2 class="section-title">Produk Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach(array_slice($products, 0, 5) as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['nama']; ?></td>
                    <td>Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $product['stok']; ?></td>
                    <td>
                        <button class="btn btn-edit">Edit</button>
                        <button class="btn btn-delete">Hapus</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <h2 class="section-title" style="margin-top: 30px;">Pesanan Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['nama_pelanggan']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($order['tanggal'])); ?></td>
                    <td>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td>
                        <button class="btn btn-edit">Detail</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>