<template>
    <div class="not-authorized-container">
        <div class="error-card">
            <div class="error-content fade-in">
                <img src="" alt="Logo" class="company-logo fade-in">
                <div class="error-number slide-in-left">403</div>
                <h1 class="error-title slide-in-left-delay">Not Authorized</h1>
                <p class="error-description fade-in-up">You don't have permission to access this page.</p>
                <router-link to="/" class="return-button">
                    <span class="btn-content">
                        <i class="fas fa-home"></i>
                        Return Home
                        <span class="btn-shine"></span>
                    </span>
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>

</script>

<style scoped>
.not-authorized-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.error-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    padding: 3rem;
    text-align: center;
    max-width: 500px;
    width: 90%;
}

.error-number {
    font-size: 8rem;
    font-weight: 700;
    background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1;
    margin-bottom: 1rem;
}

.error-title {
    font-size: 2rem;
    color: #dc3545;
    margin-bottom: 1rem;
}

.error-description {
    color: #5f6368;
    margin-bottom: 2rem;
    font-size: 1.1rem;
}

.company-logo {
    width: 80px;
    height: 80px;
    margin-bottom: 2rem;
    animation: float 6s ease-in-out infinite;
}

.return-button {
    display: inline-block;
    background: #dc3545;
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.return-button:hover {
    background: #b02a37;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220,53,69,0.2);
}

.btn-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-shine {
    position: absolute;
    width: 100px;
    height: 100px;
    background: radial-gradient(circle, 
        rgba(255,255,255,0.2) 0%, 
        rgba(255,255,255,0.1) 40%, 
        transparent 70%
    );
    border-radius: 50%;
    transform: translate(-50%, -50%);
    pointer-events: none;
    transition: all 0.1s ease;
}

/* Animations */
.fade-in {
    animation: fadeIn 0.8s ease-out;
}

.fade-in-up {
    animation: fadeInUp 0.8s ease-out;
}

.slide-in-left {
    animation: slideInLeft 0.8s ease-out;
}

.slide-in-left-delay {
    animation: slideInLeft 0.8s ease-out 0.2s both;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .not-authorized-container {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    }

    .error-card {
        background: #2d2d2d;
    }

    .error-title {
        color: #ff4d5e;
    }

    .error-description {
        color: #e8eaed;
    }

    .error-number {
        background: linear-gradient(135deg, #ff4d5e 0%, #dc3545 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .company-logo {
        filter: brightness(0.9);
    }
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .error-number {
        font-size: 6rem;
    }

    .error-title {
        font-size: 1.5rem;
    }

    .error-card {
        padding: 2rem;
    }

    .company-logo {
        width: 60px;
        height: 60px;
        margin-bottom: 1.5rem;
    }
}
</style>