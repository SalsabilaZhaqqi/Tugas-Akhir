@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Monitoring</h1>
    </div>

    <div class="dashboard-status">
        <div class="status-indicator online">
            <span class="status-dot"></span>
            <span class="status-text">System Online</span>
        </div>
        <div class="status-time">
            Last update: <span id="last-update">{{ date('d M Y, H:i:s') }}</span>
        </div>
    </div>

    <div class="dashboard-cards">
        <!-- Radiation Card -->
        <div class="dashboard-card radiation">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="2"></circle>
                        <line x1="12" y1="8" x2="12" y2="4"></line>
                        <line x1="12" y1="20" x2="12" y2="16"></line>
                        <line x1="16" y1="12" x2="20" y2="12"></line>
                        <line x1="4" y1="12" x2="8" y2="12"></line>
                    </svg>
                </div>
                <div class="card-title">Radiasi</div>
            </div>
            <div class="card-value" id="radiation-value">87.6 <span class="unit">cpm</span></div>
            <div class="card-chart">
                <canvas id="radiation-chart"></canvas>
            </div>
        </div>

        <!-- Magnetic Field Card -->
        <div class="dashboard-card magnetic">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v0a10 10 0 0 1 10 10c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2A10 10 0 0 1 12 2z"></path>
                        <path d="M17.8 20c-.4-2.4-2.4-4-4.8-4s-4.4 1.6-4.8 4h9.6z"></path>
                    </svg>
                </div>
                <div class="card-title">Medan Magnet</div>
            </div>
            <div class="card-value" id="magnetic-value">0.42 <span class="unit">G</span></div>
            <div class="card-chart">
                <canvas id="magnetic-chart"></canvas>
            </div>
        </div>

        <!-- Signal Card -->
        <div class="dashboard-card signal">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                        <line x1="2" y1="20" x2="2.01" y2="20"></line>
                    </svg>
                </div>
                <div class="card-title">Sinyal</div>
            </div>
            <div class="card-value" id="signal-value">3.8 <span class="unit">V</span></div>
            <div class="card-chart">
                <canvas id="signal-chart"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Gabungan History Rata-rata 10 Menit -->
    <div class="dashboard-combined-chart" style="background:#fff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.05); padding:20px; margin-bottom:30px;">
        <h3 style="margin-bottom: 10px; color: #2c3e50;">Avarage Conditions</h3>
        <canvas id="combined-chart-history-10min"></canvas>
    </div>
</div>

<style>
.dashboard-container {
    padding: 10px 0;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.dashboard-title {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    background: linear-gradient(45deg, #2c3e50, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.dashboard-status {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 10px 15px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.status-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.status-indicator.online {
    color: #10b981;
}

.status-indicator.online .status-dot {
    background-color: #10b981;
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.status-indicator.warning {
    color: #f59e0b;
}

.status-indicator.warning .status-dot {
    background-color: #f59e0b;
}

.status-indicator.danger {
    color: #ef4444;
}

.status-indicator.danger .status-dot {
    background-color: #ef4444;
}

.status-text {
    color: #6c757d;
    font-size: 14px;
}

.status-time {
    color: #6c757d;
    font-size: 14px;
}

.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.dashboard-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 20px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
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

.radiation .card-icon {
    background-color: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.magnetic .card-icon {
    background-color: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
}

.signal .card-icon {
    background-color: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.card-title {
    font-weight: 600;
    font-size: 16px;
    color: #2c3e50;
    flex-grow: 1;
}

.card-menu {
    color: #94a3b8;
    cursor: pointer;
}

.card-value {
    font-size: 32px;
    font-weight: 700;
    margin: 15px 0;
    color: #1e293b;
}

.unit {
    font-size: 16px;
    color: #64748b;
    font-weight: 400;
}

.card-chart {
    margin: 20px 0;
    height: 150px;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #f1f5f9;
}

.card-status {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    font-weight: 500;
}

.card-status.normal {
    color: #10b981;
}

.card-status.warning {
    color: #f59e0b;
}

.card-status.good {
    color: #3b82f6;
}

.card-trend {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    font-weight: 500;
}

.card-trend.up {
    color: #10b981;
}

.card-trend.down {
    color: #ef4444;
}

.dashboard-details {
    margin-top: 30px;
}

.detail-card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 20px;
}

.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.detail-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.detail-actions {
    display: flex;
    gap: 10px;
}

.detail-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.detail-btn:hover {
    background-color: #e9ecef;
}

.detail-table-container {
    overflow-x: auto;
}

.detail-table {
    width: 100%;
    border-collapse: collapse;
}

.detail-table th,
.detail-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}

.detail-table th {
    font-weight: 600;
    color: #64748b;
    font-size: 14px;
}

.detail-table td {
    color: #1e293b;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.status-badge.normal {
    background-color: rgba(16, 185, 129, 0.1);
    color: #10b981;
}

.status-badge.warning {
    background-color: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .dashboard-status {
        flex-direction: column;
        gap: 10px;
    }
    
    .detail-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

.dashboard-combined-chart {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 30px;
    max-width: 100%;
}
.dashboard-combined-chart canvas {
    width: 100% !important;
    height: auto !important;
    display: block;
}
/* Responsive: tinggi chart lebih kecil di layar mobile */
@media (max-width: 600px) {
    .dashboard-combined-chart canvas {
        height: 220px !important;
    }
}
</style>

<!-- Tambahkan Firebase SDK sebelum Chart.js -->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-database.js"></script>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Konfigurasi Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyBwF0xwV0oqn9s4oVVS-757F1V9ZXyGVK0",
        authDomain: "tugasakhir-6eac8.firebaseapp.com",
        databaseURL: "https://tugasakhir-6eac8-default-rtdb.asia-southeast1.firebasedatabase.app",
        projectId: "tugasakhir-6eac8",
        storageBucket: "tugasakhir-6eac8.appspot.com",
        messagingSenderId: "1015385528362",
        appId: "1:1015385528362:web:5e3c9c3f8f66666f4f90ae"
    };

    // Inisialisasi Firebase
    firebase.initializeApp(firebaseConfig);
    const database = firebase.database();

    // Cek koneksi Firebase
    const connectedRef = firebase.database().ref(".info/connected");
    connectedRef.on("value", (snap) => {
        if (snap.val() === true) {
            console.log("Terhubung ke Firebase");
            updateStatus('online');
        } else {
            console.log("Tidak terhubung ke Firebase");
            updateStatus('danger');
        }
    });

    // Fungsi untuk memuat data dari localStorage
    function loadChartData() {
        const savedData = localStorage.getItem('dashboardChartData');
        if (savedData) {
            const data = JSON.parse(savedData);
            radiationData = data.radiationData || [];
            magneticData = data.magneticData || [];
            signalData = data.signalData || [];
            labels = data.labels || [];
        }
    }

    // Fungsi untuk menyimpan data ke localStorage
    function saveChartData() {
        const data = {
            radiationData,
            magneticData,
            signalData,
            labels
        };
        localStorage.setItem('dashboardChartData', JSON.stringify(data));
    }

    // Data untuk chart
    let chartHistory = []; // [{time: ISOString, cpm, gauss, vpm}]
    let radiationData = [];
    let magneticData = [];
    let signalData = [];
    let labels = [];

    // Data yang disederhanakan untuk chart di dalam card
    let radiationDataSmall = [];
    let magneticDataSmall = [];
    let signalDataSmall = [];
    let labelsSmall = [];

    // Muat data yang tersimpan saat halaman dimuat

    function loadChartHistory() {
        const saved = localStorage.getItem('dashboardChartHistory');
        if (saved) {
            chartHistory = JSON.parse(saved).map(item => ({
                ...item,
                time: new Date(item.time)
            }));
        }
        updateChartArrays();
    }

    function saveChartHistory() {
        localStorage.setItem('dashboardChartHistory', JSON.stringify(chartHistory));
    }

    function updateChartArrays() {
        // Filter hanya data 1 hari terakhir
        const now = new Date();
        const oneDayAgo = new Date(now.getTime() - 24 * 60 * 60 * 1000);
        chartHistory = chartHistory.filter(item => item.time >= oneDayAgo);

        labels.length = 0;
        radiationData.length = 0;
        magneticData.length = 0;
        signalData.length = 0;

        chartHistory.forEach(item => {
            labels.push(item.time.getHours().toString().padStart(2, '0') + ':' + item.time.getMinutes().toString().padStart(2, '0'));
            radiationData.push(item.cpm);
            magneticData.push(item.gauss);
            signalData.push(item.vpm);
        });

        // Panggil fungsi untuk menyederhanakan data untuk card charts
        updateSmallChartArrays();
    }

    function updateSmallChartArrays() {
        const targetPoints = 40; // Maksimal 40 titik data di chart kecil
        
        labelsSmall.length = 0;
        radiationDataSmall.length = 0;
        magneticDataSmall.length = 0;
        signalDataSmall.length = 0;

        if (chartHistory.length <= targetPoints) {
            chartHistory.forEach(item => {
                labelsSmall.push(item.time.getHours().toString().padStart(2, '0') + ':' + item.time.getMinutes().toString().padStart(2, '0'));
                radiationDataSmall.push(item.cpm);
                magneticDataSmall.push(item.gauss);
                signalDataSmall.push(item.vpm);
            });
        } else {
            const step = Math.floor(chartHistory.length / targetPoints);
            for (let i = 0; i < chartHistory.length; i += step) {
                const item = chartHistory[i];
                labelsSmall.push(item.time.getHours().toString().padStart(2, '0') + ':' + item.time.getMinutes().toString().padStart(2, '0'));
                radiationDataSmall.push(item.cpm);
                magneticDataSmall.push(item.gauss);
                signalDataSmall.push(item.vpm);
            }
        }
    }

    function addChartData(cpm, gauss, vpm) {
        const now = new Date();
        // Cek apakah sudah ada data pada menit yang sama
        if (
            chartHistory.length > 0 &&
            now.getHours() === chartHistory[chartHistory.length - 1].time.getHours() &&
            now.getMinutes() === chartHistory[chartHistory.length - 1].time.getMinutes()
        ) {
            // Replace data terakhir dengan data baru (update)
            chartHistory[chartHistory.length - 1] = {
                time: now,
                cpm: cpm,
                gauss: gauss,
                vpm: vpm
            };
        } else {
            // Tambahkan data baru
            chartHistory.push({
                time: now,
                cpm: cpm,
                gauss: gauss,
                vpm: vpm
            });
        }
        updateChartArrays();
        saveChartHistory();
        // Update semua chart setiap ada data baru
        radiationChart.update('none');
        magneticChart.update('none');
        signalChart.update('none');
    }

    loadChartHistory();
    
    // Inisialisasi chart
    const radiationChart = new Chart(document.getElementById('radiation-chart'), {
        type: 'line',
        data: {
            labels: labelsSmall,
            datasets: [{
                label: 'Radiasi',
                data: radiationDataSmall,
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 2,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            return 'Waktu: ' + context[0].label;
                        },
                        label: function(context) {
                            return `Radiasi: ${context.parsed.y.toFixed(2)} cpm`;
                        }
                    }
                }
            },
            scales: {
                x: { display: false },
                y: { 
                    display: false,
                    beginAtZero: true 
                }
            },
            elements: {
                line: {
                    cubicInterpolationMode: 'monotone'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 0
            }
        }
    });

    const magneticChart = new Chart(document.getElementById('magnetic-chart'), {
        type: 'line',
        data: {
            labels: labelsSmall,
            datasets: [{
                label: 'Medan Magnet',
                data: magneticDataSmall,
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 2,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            return 'Waktu: ' + context[0].label;
                        },
                        label: function(context) {
                            return `Medan Magnet: ${context.parsed.y.toFixed(2)} G`;
                        }
                    }
                }
            },
            scales: {
                x: { display: false },
                y: { 
                    display: false,
                    beginAtZero: true 
                }
            },
            elements: {
                line: {
                    cubicInterpolationMode: 'monotone'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 0
            }
        }
    });
    
    const signalChart = new Chart(document.getElementById('signal-chart'), {
        type: 'line',
        data: {
            labels: labelsSmall,
            datasets: [{
                label: 'Sinyal',
                data: signalDataSmall,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 2,
                pointHoverRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        title: function(context) {
                            return 'Waktu: ' + context[0].label;
                        },
                        label: function(context) {
                            return `Sinyal: ${context.parsed.y.toFixed(2)} V`;
                        }
                    }
                }
            },
            scales: {
                x: { display: false },
                y: { 
                    display: false,
                    beginAtZero: true 
                }
            },
            elements: {
                line: {
                    cubicInterpolationMode: 'monotone'
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animation: {
                duration: 0
            }
        }
    });
    
    // Fungsi untuk memperbarui status
    function updateStatus(status) {
        const statusIndicator = document.querySelector('.status-indicator');
        const statusDot = document.querySelector('.status-dot');
        const statusText = document.querySelector('.status-text');
        
        // Hapus kelas status sebelumnya
        statusIndicator.classList.remove('online', 'warning', 'danger');
        
        // Tambahkan kelas status baru
        statusIndicator.classList.add(status);
        
        // Perbarui teks status
        let text = 'System Online';
        if (status === 'warning') {
            text = 'System Warning';
        } else if (status === 'danger') {
            text = 'System Danger';
        }
        
        // Update teks status
        statusText.textContent = text;
    }

    // Fungsi untuk mendapatkan data terbaru dalam 5 menit terakhir
    function getLatestWithin5Minutes(type) {
        const now = new Date();
        const fiveMinutesAgo = new Date(now.getTime() - 5 * 60 * 1000);
        // Cari data terbaru dalam 5 menit terakhir dari belakang
        for (let i = chartHistory.length - 1; i >= 0; i--) {
            if (chartHistory[i].time >= fiveMinutesAgo) {
                if (type === 'cpm') return chartHistory[i].cpm;
                if (type === 'gauss') return chartHistory[i].gauss;
                if (type === 'vpm') return chartHistory[i].vpm;
            } else {
                break;
            }
        }
        return null;
    }

    // Fungsi untuk memperbarui nilai magnetic dari Firebase
    function updateMagneticFromFirebase() {
        console.log('Memulai koneksi ke Firebase...');
        
        // Referensi ke node magnetic
        const magneticRef = firebase.database().ref('/');
        
        // Mendengarkan perubahan data
        magneticRef.on('value', (snapshot) => {
            console.log('Data diterima:', snapshot.val());
            const data = snapshot.val();
            
            if (data && data.magnetic && data.magnetic.gauss !== undefined) {
                const gaussValue = data.magnetic.gauss;
                console.log('Nilai gauss:', gaussValue);
                
                // Ambil data terbaru dalam 5 menit terakhir
                const latestGauss = getLatestWithin5Minutes('gauss');
                document.getElementById('magnetic-value').innerHTML =
                    (latestGauss !== null ? latestGauss.toFixed(2) : '-') + ' <span class="unit">G</span>';

                // Update data chart
                // Ambil data terakhir dari radiasi & sinyal jika ada
                const lastCpm = radiationData.length > 0 ? radiationData[radiationData.length-1] : 0;
                const lastVpm = signalData.length > 0 ? signalData[signalData.length-1] : 0;
                addChartData(lastCpm, gaussValue, lastVpm);
                magneticChart.update('none');
            } else {
                console.log('Data magnetic tidak ditemukan atau format tidak sesuai');
            }
        }, (error) => {
            console.error('Error membaca data dari Firebase:', error);
            updateStatus('danger');
        });
    }

    // Panggil fungsi untuk mulai mendengarkan perubahan data magnetic
    updateMagneticFromFirebase();

    // Fungsi untuk memperbarui data menggunakan AJAX (untuk data lainnya)
    function updateData() {
        fetch('/api/monitoring/current-data')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.message || 'Terjadi kesalahan saat mengambil data');
                }
                
                // Ambil data terbaru dalam 5 menit terakhir
                const latestCpm = getLatestWithin5Minutes('cpm');
                const latestVpm = getLatestWithin5Minutes('vpm');
                document.getElementById('radiation-value').innerHTML =
                    (latestCpm !== null ? latestCpm.toFixed(1) : '-') + ' <span class="unit">cpm</span>';
                document.getElementById('signal-value').innerHTML =
                    (latestVpm !== null ? latestVpm.toFixed(1) : '-') + ' <span class="unit">V</span>';
                
                // Perbarui waktu update terakhir
                document.getElementById('last-update').textContent = new Date().toLocaleString('id-ID');
                
                // Perbarui status
                updateStatus('online');
                
                // Perbarui data chart untuk radiasi dan sinyal
                // Ambil data terakhir dari magnetic jika ada
                const lastGauss = magneticData.length > 0 ? magneticData[magneticData.length-1] : 0;
                addChartData(data.current.cpm, lastGauss, data.current.vpm);
                radiationChart.update('none');
                signalChart.update('none');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                updateStatus('danger');
                const statusText = document.querySelector('.status-text');
                statusText.textContent = 'Error: ' + error.message;
            });
    }
    
    // Mulai pembaruan data otomatis setiap 10 detik (untuk data non-magnetic)
    setInterval(updateData, 10000);
    
    // Panggil updateData sekali saat halaman dimuat
    updateData();

    // Add this function after loadChartHistory()
function clearChartsAtMidnight() {
    const now = new Date();
    // Convert to WIB (UTC+7)
    const wibTime = new Date(now.getTime() + (7 * 60 * 60 * 1000));
    
    // Check if it's midnight in WIB
    if (wibTime.getHours() === 0 && wibTime.getMinutes() === 0) {
        console.log('Clearing charts data at midnight WIB');
        
        // Clear chart history
        chartHistory = [];
        
        // Clear all data arrays
        radiationData.length = 0;
        magneticData.length = 0;
        signalData.length = 0;
        labels.length = 0;
        
        // Clear small chart arrays
        radiationDataSmall.length = 0;
        magneticDataSmall.length = 0;
        signalDataSmall.length = 0;
        labelsSmall.length = 0;
        
        // Update localStorage
        saveChartHistory();
        
        // Update all charts
        radiationChart.update('none');
        magneticChart.update('none');
        signalChart.update('none');
        
        // Fetch new history data for combined chart
        fetchHistoryAndRenderChart();
    }
}

// Add this line after the other setInterval calls
// Check every minute for midnight reset
setInterval(clearChartsAtMidnight, 60000);

// Call once when page loads to check if we need to clear
clearChartsAtMidnight();

// Fungsi untuk memperbarui waktu secara real-time
    function updateRealTime() {
        const now = new Date();
        const day = now.getDate().toString().padStart(2, '0');
        const month = now.toLocaleString('id-ID', { month: 'short' });
        const year = now.getFullYear();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        
        const formattedTime = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds}`;
        document.getElementById('last-update').textContent = formattedTime;
    }
    
    // Perbarui waktu setiap detik
    setInterval(updateRealTime, 1000);
    
    // Panggil fungsi updateRealTime sekali saat halaman dimuat
    updateRealTime();

    // --- Combined Chart dari Firebase History ---
    function fetchHistoryAndRenderChart() {
        const historyRef = firebase.database().ref('/history');
        historyRef.once('value', (snapshot) => {
            const data = snapshot.val();
            if (!data) return;
            // Urutkan key timestamp
            const keys = Object.keys(data).sort();
            const labels = [];
            const cpmData = [];
            const gaussData = [];
            const vpmData = [];
            // Untuk chart rata-rata 10 menit
            const avgLabels = [];
            const avgCpm = [];
            const avgGauss = [];
            const avgVpm = [];
            let group = [];
            let groupStart = null;
            keys.forEach(key => {
                // Format label: jam:menit dari timestamp
                let label = key;
                // Jika format timestamp, ambil jam:menit
                const match = key.match(/\d{4}-\d{2}-\d{2}_(\d{2}):(\d{2}):(\d{2})$/);
                let dateObj = null;
                if (match) {
                    label = match[1] + ':' + match[2];
                    // Buat objek Date
                    const [year, month, day] = key.split('_')[0].split('-');
                    const hour = match[1], minute = match[2], second = match[3];
                    dateObj = new Date(year, month-1, day, hour, minute, second);
                }
                labels.push(label);
                cpmData.push(data[key].cpm ?? null);
                gaussData.push(data[key].gauss ?? null);
                vpmData.push(data[key].vpm ?? null);
                // --- Untuk rata-rata 10 menit ---
                if (dateObj) {
                    if (!groupStart) {
                        groupStart = new Date(dateObj);
                        group = [];
                    }
                    // Jika masih dalam rentang 10 menit
                    if ((dateObj - groupStart) < 10*60*1000) {
                        group.push(data[key]);
                    } else {
                        // Hitung rata-rata group sebelumnya
                        if (group.length > 0) {
                            const avg = arr => arr.reduce((a,b)=>a+b,0)/arr.length;
                            avgLabels.push(groupStart.getHours().toString().padStart(2,'0')+':'+groupStart.getMinutes().toString().padStart(2,'0'));
                            avgCpm.push(avg(group.map(d=>d.cpm||0)));
                            avgGauss.push(avg(group.map(d=>d.gauss||0)));
                            avgVpm.push(avg(group.map(d=>d.vpm||0)));
                        }
                        // Mulai group baru
                        groupStart = new Date(dateObj);
                        group = [data[key]];
                    }
                }
            });
            // Tambahkan group terakhir
            if (group.length > 0 && groupStart) {
                const avg = arr => arr.reduce((a,b)=>a+b,0)/arr.length;
                avgLabels.push(groupStart.getHours().toString().padStart(2,'0')+':'+groupStart.getMinutes().toString().padStart(2,'0'));
                avgCpm.push(avg(group.map(d=>d.cpm||0)));
                avgGauss.push(avg(group.map(d=>d.gauss||0)));
                avgVpm.push(avg(group.map(d=>d.vpm||0)));
            }
            // Render chart history
            new Chart(document.getElementById('combined-chart-history-10min'), {
                type: 'line',
                data: {
                    labels: avgLabels,
                    datasets: [
                        {
                            label: 'Radiasi (cpm)',
                            data: avgCpm,
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.05)',
                            cubicInterpolationMode: 'monotone',
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 6,
                            borderWidth: 2,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Medan Magnet (G)',
                            data: avgGauss,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.05)',
                            cubicInterpolationMode: 'monotone',
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 6,
                            borderWidth: 2,
                            yAxisID: 'y1',
                        },
                        {
                            label: 'Sinyal (V)',
                            data: avgVpm,
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.05)',
                            cubicInterpolationMode: 'monotone',
                            fill: false,
                            pointRadius: 1,
                            pointHoverRadius: 6,
                            borderWidth: 2,
                            yAxisID: 'y2',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                title: function(context) {
                                    // Ambil label (jam:menit)
                                    const label = context[0].label;
                                    // Cari tanggal dari data asli jika memungkinkan
                                    // Karena label hanya jam:menit, kita ambil tanggal hari ini
                                    const now = new Date();
                                    let [hour, minute] = label.split(':');
                                    let localDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), parseInt(hour), parseInt(minute));
                                    // Tambahkan offset +7 jam (WIB)
                                    localDate.setHours(localDate.getHours() + 7);
                                    // Format ke string Indonesia
                                    const formatted = localDate.toLocaleString('id-ID', { hour: '2-digit', minute: '2-digit', second: undefined, hour12: false, timeZone: 'Asia/Jakarta' });
                                    return 'Waktu (WIB): ' + formatted;
                                },
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y.toFixed(2);
                                    }
                                    // Tambahkan unit
                                    if (context.dataset.yAxisID === 'y') label += ' cpm';
                                    if (context.dataset.yAxisID === 'y1') label += ' G';
                                    if (context.dataset.yAxisID === 'y2') label += ' V';
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            title: { display: true, text: 'Waktu' },
                            grid: { display: false }
                        },
                        y: {
                            type: 'linear',
                            position: 'left',
                            title: { display: true, text: 'Radiasi (cpm)', color: '#ef4444', font: { weight: 'bold' } },
                            ticks: { color: '#ef4444' }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Medan Magnet (G)', color: '#4f46e5', font: { weight: 'bold' } },
                            ticks: { color: '#4f46e5' }
                        },
                        y2: {
                            type: 'linear',
                            display: false, // Tetap disembunyikan agar tidak terlalu ramai, datanya bisa dilihat di tooltip
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            title: { display: true, text: 'Sinyal (V)', color: '#10b981' }
                        }
                    }
                }
            });
        });
    }
    // Panggil saat halaman dimuat
    fetchHistoryAndRenderChart();
</script>
@endsection