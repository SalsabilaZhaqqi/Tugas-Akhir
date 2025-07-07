@extends('layouts.app')

@section('title', 'Status Monitoring')

@section('content')
<div class="status-container">
    <div class="status-header">
        <h1 class="status-title">Status Monitoring</h1>
        <div class="connection-status">
            <span id="connectionStatus" class="status-indicator">●</span>
            <span id="lastUpdate">Memuat...</span>
        </div>
    </div>

    <div class="status-content">
        <div class="status-card">
            <div class="card-header">
                <h3>Riwayat Pembacaan</h3>
                <div class="card-actions">
                    <button id="refreshBtn" class="refresh-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                            <path d="M21 3v5h-5"></path>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                            <path d="M3 21v-5h5"></path>
                        </svg>
                        Refresh
                    </button>
                    <button class="export-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Export Data
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="status-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Radiasi (cpm)</th>
                            <th>Medan Magnet (G)</th>
                            <th>Sinyal (V)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="dataTableBody">
                        <tr>
                            <td colspan="5" style="text-align: center;">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.status-container {
    padding: 20px;
}

.status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.status-title {
    font-size: 24px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    background: linear-gradient(45deg, #2c3e50, #3498db);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.connection-status {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #64748b;
}

.status-indicator {
    font-size: 18px;
    transition: color 0.3s ease;
}

.status-indicator.connected {
    color: #10b981;
}

.status-indicator.disconnected {
    color: #ef4444;
}

.status-indicator.loading {
    color: #f59e0b;
}

.status-content {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    padding: 20px;
}

.status-card {
    background-color: #fff;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.card-actions {
    display: flex;
    gap: 10px;
}

.export-btn, .refresh-btn {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 8px 12px;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.export-btn:hover, .refresh-btn:hover {
    background-color: #e9ecef;
}

.refresh-btn.loading svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.table-responsive {
    overflow-x: auto;
}

.status-table {
    width: 100%;
    border-collapse: collapse;
}

.status-table th,
.status-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}

.status-table th {
    font-weight: 600;
    color: #64748b;
    font-size: 14px;
    background-color: #f8f9fa;
}

.status-table td {
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

.new-data-row {
    background-color: rgba(16, 185, 129, 0.1);
    animation: highlightNewData 3s ease-out;
}

@keyframes highlightNewData {
    0% { background-color: rgba(16, 185, 129, 0.3); }
    100% { background-color: transparent; }
}

@media (max-width: 768px) {
    .status-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .card-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .export-btn, .refresh-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
class MonitoringDashboard {
    constructor() {
        this.data = [];
        this.lastTimestamp = null;
        this.refreshInterval = null;
        this.timeUpdateInterval = null;
        this.isLoading = false;
        
        this.tbody = document.getElementById('dataTableBody');
        this.connectionStatus = document.getElementById('connectionStatus');
        this.lastUpdateElement = document.getElementById('lastUpdate');
        this.refreshBtn = document.getElementById('refreshBtn');
        
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.loadInitialData();
        this.startAutoRefresh();
        this.startTimeUpdate();
    }
    
    setupEventListeners() {
        this.refreshBtn.addEventListener('click', () => {
            this.refreshData();
        });
        
        document.querySelector('.export-btn').addEventListener('click', () => {
            this.exportData();
        });
        
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.stopAutoRefresh();
                this.stopTimeUpdate();
            } else {
                this.startAutoRefresh();
                this.startTimeUpdate();
                this.refreshData();
            }
        });
    }
    
    async loadInitialData() {
        this.setLoading(true);
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 60000); // 1 minute timeout

            const response = await fetch('/monitoring/history', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);
            // console.log('Response status:', response.status);
            const responseText = await response.text();
            // console.log('Response text:', responseText);
            
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                throw new Error('Invalid JSON response from server: ' + responseText.substring(0, 100));
            }
            
            if (!result.success) {
                throw new Error(result.message || 'Server returned error response');
            }
            
            const history = result.history || {};
            // console.log('Received history data:', history);
            
            if (Object.keys(history).length === 0) {
                console.log('No history data available');
                this.showError('Belum ada data tersedia');
                return;
            }
            
            // Convert Firebase history object to array and sort by timestamp
            this.data = Object.entries(history)
                .map(([timestamp, data]) => {
                    // console.log('Processing entry:', timestamp, data);
                    return {
                        timestamp_str: this.formatTimestamp(timestamp),
                        raw_timestamp: timestamp,
                        cpm_radiation: parseFloat(data.cpm || 0),
                        em_field: parseFloat(data.vpm || 0),
                        gaus: parseFloat(data.gauss || 0),
                        status: this.determineStatus(data)
                    };
                })
                .sort((a, b) => b.raw_timestamp.localeCompare(a.raw_timestamp));

            // console.log('Processed data:', this.data);
            
            // Limit to 50 entries
            this.data = this.data.slice(0, 50);
            
            this.updateLastTimestamp();
            this.renderTable();
            this.setConnectionStatus('connected');
            this.updateLastUpdateTime();
        } catch (error) {
            console.error('Detailed error in loadInitialData:', error);
            this.setConnectionStatus('disconnected');
            this.showError(error.name === 'AbortError' ? 'Koneksi timeout, silakan coba lagi' : 'Error: ' + error.message);
        } finally {
            this.setLoading(false);
        }
    }

    // formatTimestamp(timestamp) {
    //     if (!timestamp) return 'N/A';
    //     // Convert from 'YYYY-MM-DD_HH:mm:ss' to readable format
    //     return timestamp.replace(/_/g, ' ');
    // }

    formatTimestamp(timestamp) {
    if (!timestamp) return 'N/A';

    // Ambil tanggal UTC dari Firebase: "2025-07-07_06:35:00"
    const utcDateStr = timestamp.replace('_', 'T') + 'Z'; // jadi "2025-07-07T06:35:00Z"
    const dateUTC = new Date(utcDateStr);

    // Format ke waktu Indonesia (WIB)
    return dateUTC.toLocaleString('id-ID', {
        timeZone: 'Asia/Jakarta',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
        });
    }
    
    async refreshData() {
        if (this.isLoading) return;
        
        this.setLoading(true);
        try {
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

            const response = await fetch('/monitoring/store', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            });

            clearTimeout(timeoutId);
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`HTTP error! status: ${response.status}, message: ${errorText}`);
            }

            // Then reload the data
            await this.loadInitialData();
            
        } catch (error) {
            console.error('Error refreshing data:', error);
            this.setConnectionStatus('disconnected');
            this.showError(error.name === 'AbortError' ? 'Koneksi timeout, silakan coba lagi' : error.message);
        } finally {
            this.setLoading(false);
        }
    }
    
    determineStatus(data) {
        const CPM_WARNING_THRESHOLD = 50;  // Example threshold for radiation
        const GAUSS_WARNING_THRESHOLD = 100;  // Example threshold for magnetic field
        const VPM_WARNING_THRESHOLD = 100;  // Example threshold for EM field
        
        if (data.cpm > CPM_WARNING_THRESHOLD || 
            data.gauss > GAUSS_WARNING_THRESHOLD || 
            data.vpm > VPM_WARNING_THRESHOLD) {
            return 'warning';
        }
        return 'normal';
    }
    
    updateLastTimestamp() {
        if (this.data.length > 0) {
            const latestData = this.data[0];
            this.lastTimestamp = latestData.raw_timestamp || latestData.timestamp;
        }
    }
    
    renderTable(newDataCount = 0) {
        if (this.data.length === 0) {
            this.tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada data tersedia</td></tr>';
            return;
        }
        
        this.tbody.innerHTML = '';
        
        this.data.forEach((item, index) => {
            const row = document.createElement('tr');
            
            // Highlight new data
            if (index < newDataCount) {
                row.classList.add('new-data-row');
            }
            
            row.innerHTML = `
                <td>${item.timestamp_str}</td>
                <td>${item.cpm_radiation.toFixed(2)}</td>
                <td>${item.gaus.toFixed(2)}</td>
                <td>${item.em_field.toFixed(2)}</td>
                <td><span class="status-badge ${item.status}">${this.getStatusText(item.status)}</span></td>
            `;
            
            this.tbody.appendChild(row);
        });
    }

    getStatusText(status) {
        switch (status) {
            case 'warning': return 'Peringatan';
            case 'normal': return 'Normal';
            default: return 'Normal';
        }
    }
    
    setLoading(loading) {
        this.isLoading = loading;
        this.refreshBtn.classList.toggle('loading', loading);
        this.setConnectionStatus(loading ? 'loading' : 'connected');
    }
    
    setConnectionStatus(status) {
        this.connectionStatus.className = `status-indicator ${status}`;
        
        switch (status) {
            case 'connected':
                this.connectionStatus.textContent = '●';
                break;
            case 'disconnected':
                this.connectionStatus.textContent = '●';
                break;
            case 'loading':
                this.connectionStatus.textContent = '●';
                break;
        }
    }
    
    updateLastUpdateTime() {
        const now = new Date();
        const nextUpdate = new Date(now.getTime() + 60000); // Next update in 1 minute
        
        this.lastUpdateElement.textContent = `Terakhir diperbarui: ${now.toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        })} (Update selanjutnya: ${nextUpdate.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        })})`;
    }
    
    showError(message) {
        this.tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: #ef4444;">${message}</td></tr>`;
    }
    
    startAutoRefresh() {
        this.stopAutoRefresh();
        console.log('Starting auto-refresh with 1-minute interval');
        this.refreshInterval = setInterval(() => {
            console.log('Auto-refreshing data...');
            this.refreshData();
        }, 60000); // Update every 1 minute (60000 ms)
    }
    
    stopAutoRefresh() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
            this.refreshInterval = null;
        }
    }
    
    exportData() {
        const csvContent = [
            ['Waktu', 'Radiasi (cpm)', 'Medan Magnet (G)', 'Sinyal (V)', 'Status'],
            ...this.data.map(item => [
                item.timestamp_str,
                item.cpm_radiation.toFixed(2),
                item.gaus.toFixed(2),
                item.em_field.toFixed(2),
                this.getStatusText(item.status)
            ])
        ];
        
        const csv = csvContent.map(row => row.join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `monitoring-data-${new Date().toISOString().split('T')[0]}.csv`;
        link.click();
    }

    startTimeUpdate() {
        // Update waktu setiap detik
        this.timeUpdateInterval = setInterval(() => {
            this.updateLastUpdateTime();
        }, 1000);
    }

    stopTimeUpdate() {
        if (this.timeUpdateInterval) {
            clearInterval(this.timeUpdateInterval);
            this.timeUpdateInterval = null;
        }
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new MonitoringDashboard();
});
</script>
@endsection