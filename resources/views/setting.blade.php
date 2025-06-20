@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="setting-container">
    <div class="setting-header">
        <h1 class="setting-title">Pengaturan Sistem</h1>
    </div>

    <div class="status-cards">
        <!-- Status Online Card -->
        <div class="status-card online-status">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                        <line x1="9" y1="9" x2="9.01" y2="9"></line>
                        <line x1="15" y1="9" x2="15.01" y2="9"></line>
                    </svg>
                </div>
                <div class="card-title">Status Sistem</div>
            </div>
            <div class="card-content">
                <div class="status-indicator" id="system-status">
                    <span class="status-dot"></span>
                    <span class="status-text">Online</span>
                </div>
                <div class="status-description">
                    Sistem monitoring sedang berjalan dengan baik
                </div>
            </div>
        </div>

        <!-- Last Online Card -->
        <div class="status-card last-online">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <div class="card-title">Terakhir Online</div>
            </div>
            <div class="card-content">
                <div class="last-online-time" id="last-online-time">
                    {{ date('d M Y, H:i:s') }}
                </div>
                <div class="last-online-description">
                    Waktu terakhir sistem aktif
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.setting-container {
    padding: 20px 0;
}

.setting-header {
    margin-bottom: 30px;
}

.setting-title {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    background: linear-gradient(45deg, #2c3e50, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.status-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.status-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.status-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.card-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.card-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
}

.online-status .card-icon {
    background-color: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.last-online .card-icon {
    background-color: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
}

.card-title {
    font-weight: 600;
    font-size: 16px;
    color: #2c3e50;
    flex-grow: 1;
}

.card-content {
    padding: 10px 0;
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #10b981;
    display: inline-block;
}

.status-text {
    font-weight: 600;
    font-size: 18px;
    color: #10b981;
}

.status-description, .last-online-description {
    color: #64748b;
    font-size: 14px;
}

.last-online-time {
    font-size: 18px;
    font-weight: 600;
    color: #4f46e5;
    margin-bottom: 10px;
}

.setting-section {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 20px;
    margin-bottom: 30px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin-top: 0;
    margin-bottom: 20px;
}

.setting-form {
    max-width: 600px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #4b5563;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.toggle-input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-label {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #d1d5db;
    transition: .4s;
    border-radius: 24px;
}

.toggle-label:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-input:checked + .toggle-label {
    background-color: #10b981;
}

.toggle-input:checked + .toggle-label:before {
    transform: translateX(26px);
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
}

.save-btn, .reset-btn {
    padding: 10px 16px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.save-btn {
    background-color: #3b82f6;
    color: white;
    border: none;
}

.save-btn:hover {
    background-color: #2563eb;
}

.reset-btn {
    background-color: #f3f4f6;
    color: #4b5563;
    border: 1px solid #d1d5db;
}

.reset-btn:hover {
    background-color: #e5e7eb;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .status-cards {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .save-btn, .reset-btn {
        width: 100%;
    }
}
</style>

<script>
    // Fungsi untuk memperbarui status sistem
    function updateSystemStatus() {
        fetch('/api/monitoring/system-status')
            .then(response => response.json())
            .then(data => {
                const statusElement = document.getElementById('system-status');
                const statusDot = statusElement.querySelector('.status-dot');
                const statusText = statusElement.querySelector('.status-text');
                
                if (data.isOnline) {
                    statusDot.style.backgroundColor = '#10b981';
                    statusText.textContent = 'Online';
                    statusText.style.color = '#10b981';
                } else {
                    statusDot.style.backgroundColor = '#ef4444';
                    statusText.textContent = 'Offline';
                    statusText.style.color = '#ef4444';
                }
                
                // Perbarui waktu terakhir online
                document.getElementById('last-online-time').textContent = data.lastOnline;
            })
            .catch(error => {
                console.error('Error fetching system status:', error);
            });
    }
    
    // Perbarui status setiap 30 detik
    setInterval(updateSystemStatus, 30000);
    
    // Panggil updateSystemStatus sekali saat halaman dimuat
    updateSystemStatus();
    
    // Event listener untuk tombol simpan
    document.querySelector('.save-btn').addEventListener('click', function() {
        const updateInterval = document.getElementById('update-interval').value;
        const dataRetention = document.getElementById('data-retention').value;
        const notification = document.getElementById('notification').checked;
        
        // Kirim data pengaturan ke server
        fetch('/api/settings/save', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                updateInterval,
                dataRetention,
                notification
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Pengaturan berhasil disimpan');
            } else {
                alert('Gagal menyimpan pengaturan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error saving settings:', error);
            alert('Terjadi kesalahan saat menyimpan pengaturan');
        });
    });
    
    // Event listener untuk tombol reset
    document.querySelector('.reset-btn').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mereset pengaturan ke default?')) {
            document.getElementById('update-interval').value = 3;
            document.getElementById('data-retention').value = 30;
            document.getElementById('notification').checked = true;
        }
    });
</script>
@endsection
