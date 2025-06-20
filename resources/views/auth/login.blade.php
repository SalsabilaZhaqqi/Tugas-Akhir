<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Firebase versi 9 compat untuk mendukung sintaks lama -->
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-auth-compat.js"></script>
    <style>
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #4A41D7;
            --dark-color: #2A2A72;
            --light-color: #F8F9FA;
            --gradient: linear-gradient(135deg, var(--primary-color), var(--dark-color));
        }
        
        body {
            background: var(--gradient);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .login-header {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .login-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .login-subtitle {
            color: #6c757d;
            font-size: 14px;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-floating input {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            height: 56px;
            transition: all 0.3s ease;
        }
        
        .form-floating input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.15);
        }
        
        .form-floating label {
            padding: 16px 15px;
            color: #6c757d;
        }
        
        .btn-login {
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            padding: 12px;
            height: 56px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.2);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            background: linear-gradient(135deg, var(--secondary-color), var(--dark-color));
        }
        
        .social-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: #6c757d;
        }
        
        .social-divider:before,
        .social-divider:after {
            content: "";
            flex: 1;
            height: 1px;
            background: #dee2e6;
        }
        
        .social-divider span {
            padding: 0 15px;
            font-size: 14px;
        }
        
        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .signup-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .signup-link a:hover {
            color: var(--dark-color);
        }
        
        .input-icon-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #adb5bd;
            cursor: pointer;
        }
        
        .form-check {
            margin-bottom: 20px;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 30px 20px;
                margin: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h3 class="login-title">Selamat Datang</h3>
            <p class="login-subtitle">Silakan login untuk melanjutkan</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-floating mb-4">
                <input type="email" class="form-control" id="email" name="email" placeholder="nama@contoh.com" required>
                <label for="email"><i class="fas fa-envelope me-2 text-muted"></i>Email</label>
            </div>
            
            <div class="form-floating mb-3">
                <div class="input-icon-wrapper">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <label for="password"><i class="fas fa-lock me-2 text-muted"></i>Password</label>
                    <span class="input-icon" id="togglePassword">
                        <i class="fas fa-eye-slash mb-5"></i>
                    </span>
                </div>
            </div>
            
            <button type="submit" class="btn btn-login w-100">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </button>
        </form>

        <div class="social-divider"><span>Atau masuk dengan</span></div>
        <button id="googleLogin" class="btn btn-light w-100">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" class="me-2">
            Masuk dengan Google
        </button>
        
        <div class="signup-link">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
        
        // Konfigurasi Firebase
        const firebaseConfig = {
            apiKey: "AIzaSyCfFxowhHiXKaoHcFZM4EzJOtSvBGcEKpg",
            authDomain: "tugasakhir-6eac8.firebaseapp.com",
            projectId: "tugasakhir-6eac8",
            storageBucket: "tugasakhir-6eac8.firebasestorage.app",
            messagingSenderId: "440871351596",
            appId: "1:440871351596:web:6d08cb866675ebe95ae889",
            measurementId: "G-5JYS66X37M"
        };

        // Inisialisasi Firebase
        firebase.initializeApp(firebaseConfig);

        // Fungsi Login dengan Google
        document.getElementById('googleLogin').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah form submit default
            console.log("Tombol Google Login diklik!"); // Debugging
            
            const provider = new firebase.auth.GoogleAuthProvider();
            
            firebase.auth().signInWithPopup(provider)
                .then((result) => {
                    const user = result.user;
                    console.log('User Info:', user);
                    
                    // Dapatkan token ID dari user
                    user.getIdToken().then(idToken => {
                        // Kirim token dan data user ke backend
                        fetch('/login/google-callback', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                idToken: idToken,
                                user: {
                                    name: user.displayName,
                                    email: user.email,
                                    uid: user.uid,
                                    photo: user.photoURL
                                }
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = data.redirect;
                            } else {
                                alert('Login gagal: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error saat mengirim token:', error);
                            alert('Login gagal: ' + error.message);
                        });
                    });
                })
                .catch((error) => {
                    console.error('Error saat login:', error);
                    alert('Login gagal: ' + error.message);
                });
        });
    </script>
</body>
</html>