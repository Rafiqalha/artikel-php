<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - MyBlog</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Menggunakan font styling umum yang ada namun dengan page layout center */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            background: linear-gradient(135deg, var(--bg-dark), var(--bg-card));
        }
        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: var(--text-muted);
        }
        .back-home:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-home"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>

    <div class="auth-container">
        
        <div style="text-align: center; margin-bottom: 2rem;">
            <div class="logo" style="justify-content: center; font-size: 2rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-blog"></i> MyBlog</div>
            <p style="color: var(--text-muted);">Gabung sekarang untuk mulai menulis atau sekedar memberikan komentar.</p>
        </div>

        <div class="auth-card">
            <div class="auth-tabs">
                <div class="auth-tab active" id="tab-login" onclick="switchTab('login')">Masuk</div>
                <div class="auth-tab" id="tab-register" onclick="switchTab('register')">Daftar</div>
            </div>

            <!-- Formulir Login -->
            <form id="form-login">
                <div class="form-group">
                    <label for="login-email">Email / Username</label>
                    <input type="text" id="login-email" placeholder="Masukkan email atau username" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" placeholder="••••••••" required>
                </div>
                <div style="text-align: right; margin-bottom: 1.5rem;">
                    <a href="#" style="font-size: 0.85rem; color: var(--accent);">Lupa Password?</a>
                </div>
                <button type="submit" class="btn btn-primary btn-block"><i class="fa-solid fa-right-to-bracket"></i> Masuk Sekarang</button>
            </form>

            <!-- Formulir Register -->
            <form id="form-register" style="display: none;">
                <div class="form-group">
                    <label for="reg-user">Username</label>
                    <input type="text" id="reg-user" placeholder="Misal: buditech" required>
                </div>
                <div class="form-group">
                    <label for="reg-email">Email</label>
                    <input type="email" id="reg-email" placeholder="nama@email.com" required>
                </div>
                <div class="form-group">
                    <label for="reg-password">Password</label>
                    <input type="password" id="reg-password" placeholder="Buat password yang kuat" required>
                </div>
                <div class="form-group">
                    <label for="reg-konfirm">Konfirmasi Password</label>
                    <input type="password" id="reg-konfirm" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" style="background: var(--accent);"><i class="fa-solid fa-user-plus"></i> Buat Akun</button>
            </form>

            <div class="auth-note">
                <div style="color: var(--text-muted); font-size: 0.85rem;"><i class="fa-solid fa-circle-info"></i> Form UI Mockup Only</div>
                <div class="auth-note-badges">
                    <span class="auth-badge">session_start()</span>
                    <span class="auth-badge">password_hash()</span>
                    <span class="auth-badge">MySQL Injection Safe</span>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchTab(target) {
            const tabLogin = document.getElementById('tab-login');
            const tabRegister = document.getElementById('tab-register');
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');

            if (target === 'login') {
                tabLogin.classList.add('active');
                tabRegister.classList.remove('active');
                formLogin.style.display = 'block';
                formRegister.style.display = 'none';
            } else {
                tabRegister.classList.add('active');
                tabLogin.classList.remove('active');
                formRegister.style.display = 'block';
                formLogin.style.display = 'none';
            }
        }

        // Prevent actual submission for the mock forms
        document.getElementById('form-login').addEventListener('submit', (e) => {
            e.preventDefault();
            alert("Sistem MOCK: Aksi login ditekan (Backend logic diabaikan sesuai panduan pengguna)");
        });

        document.getElementById('form-register').addEventListener('submit', (e) => {
            e.preventDefault();
            alert("Sistem MOCK: Aksi mendaftar ditekan (Backend logic diabaikan sesuai panduan pengguna)");
        });
    </script>
</body>
</html>
