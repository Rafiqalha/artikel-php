<?php
require '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the article details
$stmt = $conn->prepare("SELECT a.*, p.nama_depan, p.nama_belakang, p.foto AS foto_penulis, k.nama_kategori 
                        FROM artikel a 
                        JOIN penulis p ON a.id_penulis = p.id 
                        JOIN kategori_artikel k ON a.id_kategori = k.id 
                        WHERE a.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$artikel = $result->fetch_assoc();

if (!$artikel) {
    echo "<h2 style='text-align:center; color:white; margin-top:5rem;'>Artikel tidak ditemukan.</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($artikel['judul']) ?> - MyBlog</title>
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
            <li><a href="index.php">Beranda</a></li>
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
            <!-- Breadcrumb -->
            <div class="breadcrumb">
                <a href="index.php">Beranda</a>
                <i class="fa-solid fa-chevron-right" style="font-size:0.6rem;"></i>
                <a href="#"><?= htmlspecialchars($artikel['nama_kategori']) ?></a>
                <i class="fa-solid fa-chevron-right" style="font-size:0.6rem;"></i>
                <span style="color: var(--text-main); font-weight:500;"><?= htmlspecialchars($artikel['judul']) ?></span>
            </div>

            <!-- Article Header -->
            <header class="article-header">
                <h1><?= htmlspecialchars($artikel['judul']) ?></h1>
                
                <div class="article-meta">
                    <span style="display:flex; align-items:center; gap:0.5rem;">
                        <img src="../uploads_penulis/<?= htmlspecialchars($artikel['foto_penulis']) ?>" alt="Author" style="width:24px; height:24px; border-radius:50%; object-fit:cover;" onerror="this.src='https://via.placeholder.com/50';">
                        <?= htmlspecialchars($artikel['nama_depan'] . ' ' . $artikel['nama_belakang']) ?>
                    </span>
                    <span><i class="fa-regular fa-calendar" style="color:var(--primary);"></i> <?= htmlspecialchars($artikel['hari_tanggal']) ?></span>
                    <span><i class="fa-regular fa-clock" style="color:var(--primary);"></i> 5 menit baca (Mock)</span>
                </div>
            </header>

            <!-- Banner Image -->
            <img src="../uploads_artikel/<?= htmlspecialchars($artikel['gambar']) ?>" alt="Article Image" class="article-banner" onerror="this.src='https://via.placeholder.com/1200x500/1e2a3a/334155?text=No+Image';">

            <!-- Body -->
            <article class="article-body">
                <!-- Data ini diambil dari database, harap berhati-hati jika teks mengandung tag HTML dari editor -->
                <?= nl2br(htmlspecialchars($artikel['isi'])) ?>
            </article>

            <!-- Comments Mock Section -->
            <section class="comments-section">
                <h3 class="section-title"><i class="fa-solid fa-comments"></i> 2 Komentar</h3>
                
                <div class="comment-form">
                    <p style="margin-bottom: 1rem; color: var(--text-muted);"><i class="fa-solid fa-info-circle"></i> Tambah Komentar (UI Mock Only - no DB)</p>
                    <textarea placeholder="Tuliskan pendapat kamu mengenai artikel ini..."></textarea>
                    <button class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Kirim Komentar</button>
                </div>

                <div class="comment-list">
                    <div class="comment-item">
                        <div class="comment-avatar"><i class="fa-solid fa-user"></i></div>
                        <div class="comment-content">
                            <div class="comment-author">
                                Budi Santoso
                                <span class="comment-date">2 jam yang lalu</span>
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.95rem;">
                                Wah artikel yang sangat bermanfaat sekali! Terima kasih banyak atas informasinya karena kebetulan saya sedang mencari referensi mengenai hal ini.
                            </p>
                        </div>
                    </div>
                    
                    <div class="comment-item">
                        <div class="comment-avatar"><i class="fa-solid fa-user-ninja"></i></div>
                        <div class="comment-content">
                            <div class="comment-author">
                                Developer Keren
                                <span class="comment-date">5 jam yang lalu</span>
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.95rem;">
                                UI/UX nya terasa sangat modern dan interaktif, mirip banget sama referensi desain kekinian. Nice work!
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Related Articles (Mock) -->
            <div style="margin-top: 4rem;">
                <h3 class="section-title"><i class="fa-solid fa-link"></i> Artikel Terkait (Mock)</h3>
                <div class="article-grid">
                    <div class="article-card" style="border-style:dashed;">
                        <div class="card-content" style="align-items:center; justify-content:center; padding: 2rem;">
                            <i class="fa-solid fa-file-code" style="font-size: 2rem; color: var(--border); margin-bottom: 1rem;"></i>
                            <div style="width: 80%; height: 8px; background: var(--border); border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="width: 50%; height: 8px; background: var(--border); border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div class="article-card" style="border-style:dashed;">
                        <div class="card-content" style="align-items:center; justify-content:center; padding: 2rem;">
                            <i class="fa-solid fa-file-code" style="font-size: 2rem; color: var(--border); margin-bottom: 1rem;"></i>
                            <div style="width: 80%; height: 8px; background: var(--border); border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="width: 50%; height: 8px; background: var(--border); border-radius: 4px;"></div>
                        </div>
                    </div>
                    <div class="article-card" style="border-style:dashed;">
                        <div class="card-content" style="align-items:center; justify-content:center; padding: 2rem;">
                            <i class="fa-solid fa-file-code" style="font-size: 2rem; color: var(--border); margin-bottom: 1rem;"></i>
                            <div style="width: 80%; height: 8px; background: var(--border); border-radius: 4px; margin-bottom: 8px;"></div>
                            <div style="width: 50%; height: 8px; background: var(--border); border-radius: 4px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-newspaper"></i> Lagi Trending</h3>
                <div style="display:flex; flex-direction:column; gap:1rem;">
                    <!-- Simulasi artikel populer/trending -->
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <div style="width: 30px; height: 30px; border-radius: 50%; background: var(--primary); color: #000; display:flex; align-items:center; justify-content:center; font-weight:700;">1</div>
                        <div style="color:var(--text-main); font-weight:500; font-size:0.9rem;">Cara Install Node.js di Windows Server</div>
                    </div>
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <div style="width: 30px; height: 30px; border-radius: 50%; background: var(--bg-dark); border: 1px solid var(--border); color: var(--text-muted); display:flex; align-items:center; justify-content:center; font-weight:700;">2</div>
                        <div style="color:var(--text-main); font-weight:500; font-size:0.9rem;">Memahami Asynchronous JavaScript</div>
                    </div>
                    <div style="display:flex; gap:1rem; align-items:center;">
                        <div style="width: 30px; height: 30px; border-radius: 50%; background: var(--bg-dark); border: 1px solid var(--border); color: var(--text-muted); display:flex; align-items:center; justify-content:center; font-weight:700;">3</div>
                        <div style="color:var(--text-main); font-weight:500; font-size:0.9rem;">Panduan Tailwind CSS untuk Pemula</div>
                    </div>
                </div>
            </div>
            
            <div class="widget">
                <h3 class="widget-title"><i class="fa-solid fa-share-nodes"></i> Bagikan Artikel</h3>
                <div style="display:flex; gap:1rem;">
                    <a href="#" class="btn btn-outline" style="flex:1; justify-content:center; color:#1DA1F2;"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline" style="flex:1; justify-content:center; color:#4267B2;"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="btn btn-outline" style="flex:1; justify-content:center; color:#25D366;"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
            
            <!-- Simulasi Iklan Banner / Featured Content -->
            <div style="height: 300px; border-radius:12px; background: linear-gradient(135deg, #1e293b, #0f172a); border: 1px dashed var(--accent); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding: 2rem;">
                <i class="fa-solid fa-rocket" style="font-size:3rem; color:var(--accent); margin-bottom:1rem;"></i>
                <h4 style="color:var(--text-main); margin-bottom:0.5rem;">Join Komunitas Kami</h4>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:1rem;">Dapatkan akses ke materi eksklusif dan tutorial premium.</p>
                <a href="#" class="btn btn-primary btn-sm">Daftar Sekarang</a>
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
