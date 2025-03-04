<template>
    <div class="login-container">
        <div class="unified-card">
            <!-- Left Side - Logo Section -->
            <div class="logo-section">
                <div class="logo-content">
                    <img src="" alt="Logo" class="company-logo fade-in">
                    <h1 class="slide-in-left">Tech Concept</h1>
                    <p class="slide-in-left-delay">The Future Of Technology</p>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="form-section">
                <div class="form-container fade-in-up">
                    <div class="brand-header">
                        <h2>Inventory Management System</h2>
                        <p>Please sign in to continue</p>
                    </div>
                    
                    <div v-if="error" class="alert scale-in">
                        {{ error }}
                    </div>

                    <form @submit.prevent="handleLogin" class="login-form">
                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-user"></i>
                                <input 
                                    type="text" 
                                    placeholder="Username or Email"
                                    v-model="formData.username"
                                    :class="{ 'is-invalid': validationErrors.username }"
                                    required
                                >
                            </div>
                            <div class="invalid-feedback">{{ validationErrors.username }}</div>
                        </div>

                        <div class="form-group">
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input 
                                    type="password" 
                                    placeholder="Password"
                                    v-model="formData.password"
                                    :class="{ 'is-invalid': validationErrors.password }"
                                    required
                                >
                            </div>
                            <div class="invalid-feedback">{{ validationErrors.password }}</div>
                        </div>

                        <div class="form-options">
                            <label class="custom-checkbox">
                                <input 
                                    type="checkbox" 
                                    v-model="formData.rememberMe"
                                >
                                <span class="checkbox-mark">
                                    <svg class="tick" viewBox="0 0 24 24">
                                        <path d="M4.1 12.7L9 17.6 20.3 6.3" fill="none" stroke="white" stroke-width="2"/>
                                    </svg>
                                </span>
                                <span class="checkbox-label">Remember me</span>
                            </label>
                            <router-link to="/forgot-password" class="forgot-link">
                                Forgot Password?
                            </router-link>
                        </div>

                        <button 
                            type="submit" 
                            class="login-btn"
                            :disabled="isLoading"
                            @mousemove="handleMouseMove"
                            @mouseleave="handleMouseLeave"
                            ref="loginBtn"
                        >
                            <span v-if="!isLoading" class="btn-content">
                                <span class="btn-text">Sign In</span>
                                <span class="btn-shine" :style="shinePosition"></span>
                            </span>
                            <span v-else class="loading-spinner"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            formData: {
                username: '',
                password: '',
                rememberMe: false
            },
            error: null,
            validationErrors: {},
            isLoading: false,
            loginAttempts: 0,
            shinePosition: {
                left: '50%',
                top: '50%'
            }
        };
    },
    methods: {
        async handleLogin() {
            this.error = null;
            this.validationErrors = {};
            this.isLoading = true;

            try {
                const response = await axios.post('/api/login', {
                    username: this.formData.username,
                    password: this.formData.password,
                    remember_me: this.formData.rememberMe
                });

                if (response.data.token) {
                    localStorage.setItem('token', response.data.token);
                    
                    // Redirect based on user role
                    switch (response.data.user.role) {
                        case 'admin':
                            this.$router.push('/admin/dashboard');
                            break;
                        case 'inventory':
                            this.$router.push('/inventory/dashboard');
                            break;
                        case 'sales':
                            this.$router.push('/sales/dashboard');
                            break;
                        default:
                            this.$router.push('/dashboard');
                    }
                }
            } catch (err) {
                this.loginAttempts++;
                
                if (this.loginAttempts >= 5) {
                    this.error = 'Too many login attempts. Please try again later.';
                    setTimeout(() => this.loginAttempts = 0, 300000); // Reset after 5 minutes
                } else if (err.response) {
                    this.error = err.response.data.message || 'Invalid username or password';
                } else {
                    this.error = 'An error occurred. Please try again.';
                }
            } finally {
                this.isLoading = false;
            }
        },
        handleMouseMove(e) {
            if (this.$refs.loginBtn) {
                const rect = this.$refs.loginBtn.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                this.shinePosition = {
                    left: `${x}px`,
                    top: `${y}px`
                }
            }
        },
        handleMouseLeave() {
            this.shinePosition = {
                left: '50%',
                top: '50%'
            }
        }
    }
};
</script>

<style scoped>
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.unified-card {
    display: flex;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 1000px;
    overflow: hidden;
}

.logo-section {
    flex: 1;
    background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
    padding: 3rem 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.logo-content {
    text-align: center;
    color: white;
}

.company-logo {
    width: 100px;
    margin-bottom: 1.5rem;
}

.logo-content h1 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.logo-content p {
    font-size: 1.1rem;
    opacity: 0.9;
}

.form-section {
    flex: 1;
    padding: 3rem 2rem;
    background: white;
}

.form-container {
    max-width: 380px;
    margin: 0 auto;
}

/* Animation Classes */
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

.scale-in {
    animation: scaleIn 0.3s ease-out;
}

/* Input Styles */
.input-wrapper {
    position: relative;
    margin-bottom: 1.5rem;
}

input {
    width: 90%;
    padding: 1rem 1rem 1rem 1rem;
    border: 1px solid #e8eaed;
    border-radius: 12px;
    background: #f8f9fa;
    font-size: 1rem;
    transition: all 0.3s;
}

input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 4px rgba(26,115,232,0.1);
    outline: none;
}

.input-wrapper i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #1a73e8;
}

/* Button Styles */
.login-btn {
    margin-top: 1rem;
    background: #1a73e8;
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 12px;
    width: 100%;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.btn-content {
    position: relative;
    z-index: 1;
    display: block;
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

.login-btn:hover {
    background: #1557b0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(26,115,232,0.2);
}

.login-btn:disabled {
    background: #a8c7fa;
    cursor: not-allowed;
    transform: none;
}

.login-btn:disabled .btn-shine {
    display: none;
}

/* Optional: Add pulse effect on hover */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(26,115,232,0.4);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(26,115,232,0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(26,115,232,0);
    }
}

.login-btn:hover:not(:disabled) {
    animation: pulse 1.5s infinite;
}

/* Updated Form Options Styles */
.form-options {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 1.5rem 0;
    width: 90%;
}

.custom-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
}

.custom-checkbox input {
    display: none;
}

.checkbox-mark {
    width: 20px;
    height: 20px;
    border: 2px solid #1a73e8;
    border-radius: 6px;
    margin-right: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    background: transparent;
    overflow: hidden;
}

.tick {
    width: 14px;
    height: 14px;
    stroke-dasharray: 20;
    stroke-dashoffset: 20;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.custom-checkbox input:checked + .checkbox-mark {
    background: #1a73e8;
    border-color: #1a73e8;
}

.custom-checkbox input:checked + .checkbox-mark .tick {
    animation: tick-draw 0.3s ease forwards;
}

@keyframes tick-draw {
    to {
        stroke-dashoffset: 0;
    }
}

/* Optional: Add hover effect */
.custom-checkbox:hover .checkbox-mark {
    border-color: #1557b0;
    box-shadow: 0 0 0 3px rgba(26,115,232,0.1);
}

.checkbox-label {
    color: #5f6368;
    font-size: 0.9rem;
    font-weight: 500;
}

.forgot-link {
    color: #1a73e8;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    position: relative;
    transition: all 0.2s ease;
    cursor: pointer;
}

.forgot-link::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: #1a73e8;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

.forgot-link:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

/* Animations */
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

@keyframes scaleIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .login-container {
        padding: 1rem;
    }

    .unified-card {
        flex-direction: column;
        max-width: 400px;
    }

    .logo-section {
        padding: 2rem 1.5rem;
    }

    .logo-content h1 {
        font-size: 2rem;
    }

    .form-section {
        padding: 2rem 1.5rem;
    }

    .company-logo {
        width: 80px;
        margin-bottom: 1rem;
    }

    .form-options {
        flex-direction: row;
        align-items: center;
        gap: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .login-container {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    }

    .unified-card {
        background: #2d2d2d;
    }

    .form-section {
        background: #2d2d2d;
    }

    .logo-section {
        background: linear-gradient(135deg, #1557b0 0%, #0d47a1 100%);
    }

    .form-container {
        background: #2d2d2d;
        color: white;
    }

    input {
        background: #3d3d3d;
        color: white;
    }

    .brand-header h2,
    .brand-header p {
        color: white;
    }

    .checkbox-label {
        color: #e8eaed;
    }
    
    .custom-checkbox .checkbox-mark {
        border-color: #1a73e8;
    }
    
    .forgot-link {
        color: #8ab4f8;
    }
    
    .forgot-link::after {
        background-color: #8ab4f8;
    }
}
</style>
