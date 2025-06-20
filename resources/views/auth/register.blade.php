<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        
        .register-container {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .register-header {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .register-title {
            font-weight: 600;
            color: var(--dark-color);
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .register-subtitle {
            color: #6c757d;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group input {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 12px 15px;
            height: 54px;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .form-group input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(108, 99, 255, 0.15);
            outline: none;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .input-icon {
            position: absolute;
            color: #adb5bd;
            left: 15px;
            top: 42px;
            transform: translateY(-50%);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 42px;
            transform: translateY(-50%);
            color: #adb5bd;
            cursor: pointer;
            z-index: 10;
        }
        
        .password-input {
            padding-right: 40px;
            padding-left: 40px;
        }
        
        .input-with-icon {
            padding-left: 40px;
        }
        
        .btn-register {
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 16px;
            padding: 12px;
            height: 54px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            background: linear-gradient(135deg, var(--secondary-color), var(--dark-color));
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .login-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .login-link a:hover {
            color: var(--dark-color);
        }
        
        .terms-text {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
            margin-top: 20px;
        }
        
        .terms-text a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        @media (max-width: 576px) {
            .register-container {
                padding: 30px 20px;
                margin: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h3 class="register-title">Buat Akun</h3>
            <p class="register-subtitle">Silakan isi data diri Anda untuk mendaftar</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <!-- <i class="fas fa-user input-icon"></i> -->
                <input type="text" class="form-control input-with-icon" id="name" name="name" placeholder="Masukkan nama lengkap" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <!-- <i class="fas fa-envelope input-icon"></i> -->
                <input type="email" class="form-control input-with-icon" id="email" name="email" placeholder="Masukkan email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <!-- <i class="fas fa-lock input-icon"></i> -->
                <input type="password" class="form-control password-input" id="password" name="password" placeholder="Masukkan password" required>
                <i class="fas fa-eye-slash password-toggle mt-3" id="togglePassword"></i>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <!-- <i class="fas fa-lock input-icon"></i> -->
                <input type="password" class="form-control password-input" id="password_confirmation" name="password_confirmation" placeholder="Masukkan ulang password" required>
                <i class="fas fa-eye-slash password-toggle mt-3" id="togglePasswordConfirm"></i>
            </div>
            
            <button type="submit" class="btn btn-register w-100">
                <i class="fas fa-user-plus me-2"></i>Daftar
            </button>
        </form>
        
        <div class="login-link">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this;
            
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
        
        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordInput = document.getElementById('password_confirmation');
            const icon = this;
            
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
    </script>
</body>
</html>