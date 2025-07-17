<?php
$conn = new mysqli('localhost', 'root', '', 'db_nazwa_bunga');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nazwa Florist</title>
    <style>
        body {
            background-color: rgb(94, 28, 73);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: white;
            scroll-behavior: smooth;
        }
        /* Header */
        header {
            background: linear-gradient(to right, rgb(105, 21, 63), rgb(18, 18, 69));
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 12px rgba(122, 32, 32, 0.3);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px rgba(255, 20, 147, 0.7);
            margin-bottom: 10px;
        }

        .tagline {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 15px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            transition: all 0.3s;
            font-weight: bold;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            margin-top: 80px;
        }

        .hero-content {
            text-align: center;
            z-index: 2;
            max-width: 800px;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            text-shadow: 0 0 15px rgba(255, 20, 147, 0.7);
            animation: fadeIn 1.5s ease-in-out;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 30px;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out 0.5s forwards;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(to right, #ff1493, #ff69b4);
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(255, 20, 147, 0.4);
            transition: all 0.3s;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out 1s forwards;
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(255, 20, 147, 0.6);
        }

        /* Produk Section */
        .products {
            padding: 100px 20px;
            background-color: rgba(0, 0, 0, 0.2);
            min-height: 100vh;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
            color: #ff69b4;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            backdrop-filter: blur(5px);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(255, 20, 147, 0.3);
        }

        .product-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #ff69b4;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #daa520;
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.7);
            padding: 5px 10px;
            border-radius: 5px;
        }

        .product-description {
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .add-to-cart {
            display: block;
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #ff1493, #ff69b4);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .add-to-cart:hover {
            background: linear-gradient(to right, #ff69b4, #ff1493);
        }

        /* About Section */
        .about {
            padding: 100px 20px;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .about-content {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .about-image {
            flex: 1;
            min-width: 300px;
            height: 400px;
            border-radius: 15px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .about-text {
            flex: 1;
        }

        .about-text h2 {
            font-size: 2.5rem;
            color: #ff69b4;
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Contact Section */
        .contact {
            padding: 100px 20px;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.2);
        }

        .contact-container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 50px;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }

        .contact-info h3 {
            font-size: 1.8rem;
            color: #ff69b4;
            margin-bottom: 20px;
        }

        .contact-info p {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(5px);
        }

        .contact-form h3 {
            font-size: 1.8rem;
            color: #ff69b4;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .form-group textarea {
            height: 150px;
        }

        .submit-btn {
            background: linear-gradient(to right, #ff1493, #ff69b4);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 20, 147, 0.4);
        }

        /* Footer */
        footer {
            background-color: rgb(10, 10, 40);
            padding: 40px 20px;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            text-align: left;
        }

        .footer-column h3 {
            color: #ff69b4;
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .footer-column p, .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }

        .footer-column a:hover {
            color: white;
        }

        .copyright {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Efek Bunga Mekar */
        .flower-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            opacity: 0.3;
        }

        .flower {
            position: absolute;
            width: 50px;
            height: 50px;
        }

        .petal {
            position: absolute;
            width: 20px;
            height: 40px;
            background: linear-gradient(to bottom, rgba(255, 20, 147, 0.6), rgba(255, 105, 180, 0.4));
            border-radius: 20px 20px 0 0;
            transform-origin: bottom center;
        }

        .center {
            position: absolute;
            width: 10px;
            height: 10px;
            background: rgba(218, 165, 32, 0.6);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            nav {
                flex-wrap: wrap;
            }
            
            .product-grid {
                grid-template-columns: 1fr;
            }
            
            .about-content {
                flex-direction: column;
            }
            
            .about-image {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Toko Nazwa Florist</div>
        <div class="tagline">bunga yang mekar di antara rerumputan, temukanlah keindahan dalam kesederhanaan.</div>
        <nav>
            <a href="#home">Beranda</a>
            <a href="#products">Produk</a>
            <a href="#about">Tentang Kami</a>
            <a href="#contact">Kontak</a>
            <a href="admin_login.php">Admin</a>
        </nav>
    </header>

    <section class="hero" id="home">
        <div class="flower-animation" id="flowerAnimation"></div>
        <div class="hero-content">
            <h1>Bunga Mekar Indah</h1>
            <p>Temukan koleksi bunga terbaik kami yang akan menghiasi setiap momen berharga dalam hidup Anda</p>
            <a href="#products" class="cta-button">Lihat Koleksi</a>
        </div>
    </section>

<section class="products" id="products">
    <h2 class="section-title">Produk Kami</h2>
    <div class="product-grid">
        <?php
        // Koneksi ke database
        $conn = new mysqli("localhost", "root", "", "db_nazwa_bunga");
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Ambil data produk dari tabel
        $sql = "SELECT * FROM produk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($product = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<div class="product-image" style="background-image: url(\'' . $product['gambar'] . '\')"></div>';
                echo '<div class="product-price">Rp ' . number_format($product['harga'], 0, ',', '.') . '</div>';
                echo '<div class="product-info">';
                echo '<h3 class="product-name">' . $product['nama'] . '</h3>';
                echo '<p class="product-description">' . $product['deskripsi'] . '</p>';
                echo '<button class="add-to-cart" data-id="' . $product['Id'] . '">Tambah ke Keranjang</button>';
                echo '</div></div>';
            }
        } else {
            echo '<p>Tidak ada produk ditemukan.</p>';
        }

        $conn->close();
        ?>
    </div>
</section>


    <section class="about" id="about">
        <h2 class="section-title">Tentang Kami</h2>
        <div class="about-content">
            <div class="about-image" style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRTOGjPAhksRaNed5E8o3KB6OdU1KcD9elsOQ&s')"></div>
            <div class="about-text">
                <h2>Cerita Kami</h2>
                <p>Toko Bunga Mekar Indah didirikan pada tahun 2010 dengan misi membawa keindahan alam melalui bunga-bunga segar kepada pelanggan kami. Kami percaya bahwa bunga memiliki kekuatan untuk menyampaikan perasaan yang tak terucapkan.</p>
                <p>Dengan lebih dari 10 tahun pengalaman, kami telah melayani ribuan pelanggan dengan berbagai kebutuhan bunga mereka, mulai dari pernikahan, ulang tahun, hingga acara perusahaan.</p>
                <p>Kami bekerja sama dengan petani bunga lokal untuk memastikan kualitas terbaik dan kesegaran bunga yang kami sediakan. Setiap rangkaian bunga dibuat dengan penuh cinta dan perhatian oleh tim florist profesional kami.</p>
                <p>Dan bunga ini bisa juga untuk di berikan kepada orang tersayang/terdekat <P>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <h2 class="section-title">Kontak Kami</h2>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Informasi Kontak</h3>
                <p><i class="fas fa-map-marker-alt"></i> Jl. Bunga Indah No. 123, Kota Bunga</p>
                <p><i class="fas fa-phone"></i> (021) 567-8999</p>
                <p><i class="fas fa-envelope"></i> info@bungamekarindah.com</p>
                <p><i class="fas fa-clock"></i> Senin-Jumat: 08.00 - 17.00</p>
                <p><i class="fas fa-clock"></i> Sabtu: 09.00 - 15.00</p>
                <p><i class="fas fa-clock"></i> Minggu: Tutup</p>
            </div>
            <div class="contact-form">
                <h3>Kirim Pesan</h3>
                <form action="kirim_pesan.php" method="POST">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    <?php
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'sukses') {
        echo "<script>alert('Pesan berhasil dikirim!');</script>";
    } else if ($_GET['status'] === 'gagal') {
        echo "<script>alert('Gagal mengirim pesan!');</script>";
    }
}
?>


    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>Tentang Kami</h3>
                <p>Bunga Mekar Indah adalah toko bunga online yang menyediakan berbagai jenis bunga segar dan rangkaian bunga untuk berbagai acara.</p>
            </div>
            <div class="footer-column">
                <h3>Kontak</h3>
                <p>Jl. Bunga Indah No. 123</p>
                <p>Kota Bunga, 12345</p>
                <p>Telp: (021) 123-4567</p>
                <p>Email: info@bungamekarindah.com</p>
            </div>
            <div class="footer-column">
                <h3>Jam Buka</h3>
                <p>Senin - Jumat: 08.00 - 17.00</p>
                <p>Sabtu: 09.00 - 15.00</p>
                <p>Minggu: Tutup</p>
            </div>
        </div>
        <div class="copyright">
            &copy; 2023 Bunga Mekar Indah. All Rights Reserved.
        </div>
    </footer>

    <script>
        // Animasi bunga
        function createFlowerAnimation() {
            const container = document.getElementById('flowerAnimation');
            const flowerCount = 15;
            
            for (let i = 0; i < flowerCount; i++) {
                const flower = document.createElement('div');
                flower.className = 'flower';
                
                // Random position
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                const size = 20 + Math.random() * 30;
                const delay = Math.random() * 5;
                
                flower.style.left = `${posX}%`;
                flower.style.top = `${posY}%`;
                flower.style.width = `${size}px`;
                flower.style.height = `${size}px`;
                flower.style.animation = `fadeIn 1s ${delay}s forwards`;
                flower.style.opacity = '0';
                
                // Create petals
                const petalCount = 8;
                for (let j = 0; j < petalCount; j++) {
                    const petal = document.createElement('div');
                    petal.className = 'petal';
                    petal.style.transform = `rotate(${j * (360 / petalCount)}deg)`;
                    petal.style.width = `${size * 0.4}px`;
                    petal.style.height = `${size * 0.8}px`;
                    flower.appendChild(petal);
                }
                
                // Create center
                const center = document.createElement('div');
                center.className = 'center';
                flower.appendChild(center);
                
                container.appendChild(flower);
            }
        }
        
        // Panggil fungsi saat halaman dimuat
        window.addEventListener('load', createFlowerAnimation);
        
        // Tambahkan ke keranjang
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                alert(`Produk dengan ID ${productId} telah ditambahkan ke keranjang!`);
                
                // Di sini Anda bisa menambahkan logika AJAX untuk menyimpan ke session/cookie
            });
        });
        
        // Smooth scroll untuk navigasi
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if(this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php $conn->close(); ?>