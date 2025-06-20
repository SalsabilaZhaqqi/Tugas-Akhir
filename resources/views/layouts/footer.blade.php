<footer class="modern-footer">
    <div class="footer-container">
        <div class="footer-logo">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="footer-icon">
                <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                <path d="M2 17l10 5 10-5"></path>
                <path d="M2 12l10 5 10-5"></path>
            </svg>
            <span class="footer-app-name">Radiasi Meter</span>
        </div>
        
        <div class="footer-copyright">
            <p>&copy; {{ date('Y') }} Radiasi Meter. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<style>
.modern-footer {
    background: linear-gradient(90deg, #2c3e50, #1a252f);
    color: rgba(255, 255, 255, 0.8);
    font-family: 'Poppins', sans-serif;
    padding: 20px 0;
    margin-top: 30px;
    box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.05);
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-icon {
    color: #3498db;
}

.footer-app-name {
    font-weight: 600;
    background: linear-gradient(45deg, #3498db, #9b59b6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 18px;
}

.footer-links {
    display: flex;
    gap: 20px;
    margin: 10px 0;
}

.footer-link {
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.05);
}

.footer-link:hover {
    color: #fff;
    background-color: rgba(52, 152, 219, 0.2);
    transform: translateY(-2px);
}

.footer-copyright {
    font-size: 14px;
    text-align: center;
    color: rgba(255, 255, 255, 0.6);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .footer-container {
        padding: 0 20px;
    }
}
</style>