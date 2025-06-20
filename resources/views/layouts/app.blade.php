<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <img width="48" height="48" src="https://img.icons8.com/color/48/dota.png" alt="dota"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .app-container {
            display: flex;
            flex: 1;
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .content-wrapper {
            flex: 1;
            padding: 20px;
            width: 100%;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            background: linear-gradient(180deg, #2c3e50, #1a252f);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: width 0.3s ease;
        }
        
        .modern-footer {
            margin-top: auto;
            width: 100%;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .content-wrapper {
                padding: 15px;
            }
        }
        
        /* Toggle button for mobile view */
        .sidebar-toggle {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1100;
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
        }
        
        /* Used for mobile navigation */
        body.sidebar-collapsed .sidebar {
            width: 0;
            overflow: hidden;
        }
        
        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle" id="sidebar-toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        
        <!-- Sidebar -->
        @include('layouts.sidebar')
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-wrapper">
                @yield('content')
            </div>
            
            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        // Add active class to current menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = window.location.href;
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                if (item.href === currentLocation) {
                    item.classList.add('active');
                    item.style.backgroundColor = 'rgba(255, 255, 255, 0.05)';
                    item.style.borderLeft = '3px solid #3498db';
                }
            });
        });
    </script>
</body>
</html>