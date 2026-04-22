<?php
require '../koneksi.php';

// Ambil semua kategori untuk sidebar
$kategori_sql = "SELECT * FROM kategori_artikel ORDER BY nama_kategori ASC";
$kategori_result = $conn->query($kategori_sql);
$kategori_list = [];
while ($row = $kategori_result->fetch_assoc()) {
    $kategori_list[] = $row;
}

// Ambil artikel beserta penilis & kategori, urut berdasarkan terbaru
$artikel_sql = "SELECT a.*, p.nama_depan, p.nama_belakang, p.foto AS foto_penulis, k.nama_kategori 
                FROM artikel a 
                JOIN penulis p ON a.id_penulis = p.id 
                JOIN kategori_artikel k ON a.id_kategori = k.id 
                ORDER BY a.id DESC";
$artikel_result = $conn->query($artikel_sql);
$artikel_list = [];
while ($row = $artikel_result->fetch_assoc()) {
    $artikel_list[] = $row;
}

// Pisahkan artikel pertama sebagai Hero, sisanya untuk grid (maks 6 untuk contoh)
$hero_article = count($artikel_list) > 0 ? $artikel_list[0] : null;
$grid_articles = array_slice($artikel_list, 1, 6);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Publik CMS</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <i class="fa-solid fa-blog"></i> MyBlog
        </div>
        <ul class="nav-links">
            <li><a href="index.php" class="active">Beranda</a></li>
            <li><a href="#">Kategori</a></li>
            <li><a href="#">Tentang</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="#" class="btn btn-outline"><i class="fa-solid fa-magnifying-glass"></i></a>
            <a href="auth.php" class="btn btn-primary"><i class="fa-solid fa-user-circle"></i> Masuk / Daftar</a>
        </div>
    </nav>

    <div class="container main-layout">
        <main>
            <?php if ($hero_article): ?>
            <!-- Hero Section -->
            <section class="hero">
                <img src="../uploads_artikel/<?= htmlspecialchars($hero_article['gambar']) ?>" alt="Thumbnail" onerror="this.src='https://via.placeholder.com/800x400/1e2a3a/334155?text=No+Image';">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <span class="badge"><?= htmlspecialchars($hero_article['nama_kategori']) ?></span>
                    <h2><a href="article.php?id=<?= $hero_article['id'] ?>"><?= htmlspecialchars($hero_article['judul']) ?></a></h2>
                    <p><?= htmlspecialchars(mb_strimwidth(strip_tags($hero_article['isi']), 0, 150, "...")) ?></p>
                    <a href="article.php?id=<?= $hero_article['id'] ?>" class="btn btn-primary">Baca Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </section>
            <?php endif; ?>

            <!-- Article Grid -->
            <div>
                <h3 class="section-title"><i class="fa-solid fa-newspaper"></i> Artikel Terbaru</h3>
                <div class="article-grid">
                    <?php foreach ($grid_articles as $artikel): ?>
                    <div class="article-card">
                        <img src="../uploads_artikel/<?= htmlspecialchars($artikel['gambar']) ?>" class="card-img" alt="Thumbnail" onerror="this.src='https://via.placeholder.com/400x250/1e2a3a/334155?text=Img';">
                        <div class="card-content">
                            <div class="card-meta">
                                <span><i class="fa-regular fa-calendar"></i> <?= htmlspecialchars($artikel['hari_tanggal']) ?></span>
                                <span style="color: var(--accent); font-weight: 500;"><?= htmlspecialchars($artikel['nama_kategori']) ?></span>
                            </div>
                            <h4 class="card-title">
                                <a href="article.php?id=<?= $artikel['id'] ?>"><?= htmlspecialchars($artikel['judul']) ?></a>
                            </h4>
                            <div class="card-footer">
                                <img src="../uploads_penulis/<?= htmlspecialchars($artikel['foto_penulis']) ?>" class="author-avatar" alt="Avatar" onerror="this.src='https://via.placeholder.com/50';">
                                <span class="author-name"><?= htmlspecialchars($artikel['nama_depan'] . ' ' . $artikel['nama_belakang']) ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    
                    <?php if (count($grid_articles) === 0 && !$hero_article): ?>
                        <div style="color: var(--text-muted); text-align: center; padding: 3rem;">
                            <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p>Belum ada artikel yang dipublikasikan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-list"></i> Kategori</h3>
                <ul class="category-list">
                    <?php foreach ($kategori_list as $kat): ?>
                        <li><a href="#"><span><?= htmlspecialchars($kat['nama_kategori']) ?></span> <i class="fa-solid fa-chevron-right" style="font-size:0.7rem; color:var(--border)"></i></a></li>
                    <?php endforeach; ?>
                    <?php if (empty($kategori_list)) echo "<li style='color:var(--text-muted);'>Belum ada kategori</li>"; ?>
                </ul>
            </div>

            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-fire"></i> Populer (Mock)</h3>
                <ul class="category-list">
                    <li><a href="#">Cara Setting Database MySQL</a></li>
                    <li><a href="#">Belajar PHP Native 2026</a></li>
                    <li><a href="#">UI/UX Interaktif dengan React</a></li>
                </ul>
            </div>

            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-tags"></i> Tag Cloud (Mock)</h3>
                <div class="tag-cloud">
                    <span class="tag">#PHP</span>
                    <span class="tag">#MySQL</span>
                    <span class="tag">#WebDev</span>
                    <span class="tag">#HTML5</span>
                    <span class="tag">#CSS3</span>
                    <span class="tag">#Backend</span>
                </div>
            </div>
            
            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-envelope-open-text"></i> Newsletter</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1rem;">Dapatkan pembaruan langsung ke inbox kamu.</p>
                <div style="display: flex; gap: 0.5rem;">
                    <input type="email" placeholder="Email kamu..." style="flex:1; padding:0.6rem; border-radius:6px; border:1px solid var(--border); background:var(--bg-dark); color:var(--text-main);">
                    <button class="btn btn-primary" style="padding: 0.6rem 1rem;"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </aside>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div>
                <div class="logo"><i class="fa-solid fa-blog"></i> MyBlog</div>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 1rem; max-width:300px;">
                    Platform blog modern dengan UI/UX premium yang terintegrasi dengan CMS.
                </p>
            </div>
            <div class="social-links">
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
        <div class="copyright">
            &copy; 2026 UTS Pemrograman Web. Dibuat dengan &hearts;
        </div>
    </footer>

</body>
</html>
