/**
 * Phone Login Manager - Fixed version with proper CSS class management
 */

class PhoneLoginManager {
    constructor() {
        this.elements = {};
        this.config = {
            otpLength: 6,
            otpValidityMinutes: 5,
            resendTimeoutSeconds: 60,
            maxResendAttempts: 3
        };
        this.state = {
            currentPhone: '',
            resendCount: 0,
            resendTimer: null,
            currentTab: 'email'
        };
        
        this.init();
    }

    init() {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.initializeElements();
                this.bindEvents();
                this.initializeCountryCode();
                this.setupInitialState();
            });
        } else {
            this.initializeElements();
            this.bindEvents();
            this.initializeCountryCode();
            this.setupInitialState();
        }
    }

    initializeElements() {
        this.elements = {
            emailTab: document.getElementById('email-login-tab'),
            phoneTab: document.getElementById('phone-login-tab'),
            emailForm: document.getElementById('email-login-form'),
            phoneForm: document.getElementById('phone-login-form'),
            phoneInputForm: document.getElementById('phone-input-form'),
            otpVerificationForm: document.getElementById('otp-verification-form'),
            countryCode: document.getElementById('country-code'),
            phoneNumber: document.getElementById('phone-number'),
            otpCode: document.getElementById('otp-code'),
            sendOtpButton: document.getElementById('send-otp-button'),
            verifyOtpButton: document.getElementById('verify-otp-button'),
            resendOtpButton: document.getElementById('resend-otp-button'),
            backToPhoneButton: document.getElementById('back-to-phone-button'),
            alertMessage: document.getElementById('alert-message'),
            phoneError: document.getElementById('phone-error'),
            otpError: document.getElementById('otp-error'),
            resendTimer: document.getElementById('resend-timer')
        };
    }

    /**
     * Hide element by adding hidden class AND setting display none
     */
    hideElement(element) {
        if (element) {
            element.classList.add('hidden');
            element.style.display = 'none';
        }
    }

    /**
     * Show element by removing hidden class AND setting display
     */
    showElement(element, displayType = 'block') {
        if (element) {
            element.classList.remove('hidden');
            element.style.display = displayType;
        }
    }

    /**
     * Show element as flex
     */
    showElementFlex(element) {
        if (element) {
            element.classList.remove('hidden');
            element.style.display = 'flex';
        }
    }

    /**
     * Check if element is hidden
     */
    isElementHidden(element) {
        if (!element) return true;
        return element.classList.contains('hidden') || 
               element.style.display === 'none' || 
               getComputedStyle(element).display === 'none';
    }

    bindEvents() {
        // Tab switching
        if (this.elements.emailTab) {
            this.elements.emailTab.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchTab('email');
            });
        }
        
        if (this.elements.phoneTab) {
            this.elements.phoneTab.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchTab('phone');
            });
        }

        // Phone input formatting
        if (this.elements.phoneNumber) {
            this.elements.phoneNumber.addEventListener('input', (e) => this.formatPhoneInput(e));
            this.elements.phoneNumber.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.sendOtp();
                }
            });
        }

        // OTP input formatting
        if (this.elements.otpCode) {
            this.elements.otpCode.addEventListener('input', (e) => this.formatOtpInput(e));
            this.elements.otpCode.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.verifyOtp();
                }
            });
        }

        // Button events
        if (this.elements.sendOtpButton) {
            this.elements.sendOtpButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.sendOtp();
            });
        }
        
        if (this.elements.verifyOtpButton) {
            this.elements.verifyOtpButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.verifyOtp();
            });
        }
        
        if (this.elements.resendOtpButton) {
            this.elements.resendOtpButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.resendOtp();
            });
        }
        
        if (this.elements.backToPhoneButton) {
            this.elements.backToPhoneButton.addEventListener('click', (e) => {
                e.preventDefault();
                this.backToPhoneInput();
            });
        }

        // Country code change
        if (this.elements.countryCode) {
            this.elements.countryCode.addEventListener('change', () => this.updatePhonePlaceholder());
        }
    }

    initializeCountryCode() {
        if (this.elements.countryCode) {
            this.elements.countryCode.value = '+966';
            this.updatePhonePlaceholder();
        }
    }

    setupInitialState() {
        this.switchTab('email');
    }

    switchTab(tabType) {
        this.state.currentTab = tabType;
        
        // إخفاء جميع النماذج
        this.hideElement(this.elements.emailForm);
        this.hideElement(this.elements.phoneForm);

        // إزالة التفعيل من التابات
        [this.elements.emailTab, this.elements.phoneTab].forEach(tab => {
            if (tab) {
                tab.classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
                tab.classList.add('text-gray-500', 'hover:text-gray-700');
            }
        });

        // عرض النموذج المحدد
        if (tabType === 'email' && this.elements.emailForm && this.elements.emailTab) {
            this.showElement(this.elements.emailForm);
            this.elements.emailTab.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
            this.elements.emailTab.classList.remove('text-gray-500', 'hover:text-gray-700');
        } else if (tabType === 'phone' && this.elements.phoneForm && this.elements.phoneTab) {
            this.showElement(this.elements.phoneForm);
            this.elements.phoneTab.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
            this.elements.phoneTab.classList.remove('text-gray-500', 'hover:text-gray-700');
            
            // التأكد من عرض نموذج إدخال الهاتف وإخفاء OTP
            this.showPhoneInputForm();
            
            setTimeout(() => {
                if (this.elements.phoneNumber) {
                    this.elements.phoneNumber.focus();
                }
            }, 100);
        }

        this.clearAlerts();
    }

    showPhoneInputForm() {
        this.showElement(this.elements.phoneInputForm);
        this.hideElement(this.elements.otpVerificationForm);
    }

    formatPhoneInput(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        const countryCode = this.elements.countryCode?.value || '+966';
        const maxLength = this.getMaxPhoneLength(countryCode);
        
        if (value.length > maxLength) {
            value = value.substring(0, maxLength);
        }

        e.target.value = value;
        this.clearError('phone');
    }

    formatOtpInput(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > this.config.otpLength) {
            value = value.substring(0, this.config.otpLength);
        }

        e.target.value = value;
        this.clearError('otp');
    }

    updatePhonePlaceholder() {
        const countryCode = this.elements.countryCode?.value || '+966';
        const placeholders = {
            '+966': '501234567',
            '+965': '51234567',
            '+973': '31234567',
            '+974': '31234567',
            '+971': '501234567',
            '+968': '91234567'
        };

        if (this.elements.phoneNumber) {
            this.elements.phoneNumber.placeholder = placeholders[countryCode] || '501234567';
        }
    }

    getMaxPhoneLength(countryCode) {
        const lengths = {
            '+966': 9,
            '+965': 8,
            '+973': 8,
            '+974': 8,
            '+971': 9,
            '+968': 8
        };
        
        return lengths[countryCode] || 9;
    }

    validatePhone(phone, countryCode) {
        if (!phone) {
            return { valid: false, message: 'يرجى إدخال رقم الهاتف' };
        }

        const patterns = {
            '+966': /^[5][0-9]{8}$/,
            '+965': /^[5-9][0-9]{7}$/,
            '+973': /^[3-9][0-9]{7}$/,
            '+974': /^[3-7][0-9]{7}$/,
            '+971': /^[5][0-9]{8}$/,
            '+968': /^[9][0-9]{7}$/
        };

        const pattern = patterns[countryCode];
        if (!pattern || !pattern.test(phone)) {
            return { 
                valid: false, 
                message: 'صيغة رقم الهاتف غير صحيحة لهذه الدولة' 
            };
        }

        return { valid: true };
    }

    getFullPhoneNumber() {
        const countryCode = this.elements.countryCode?.value || '+966';
        const phoneNumber = this.elements.phoneNumber?.value || '';
        return countryCode + phoneNumber;
    }

    async sendOtp() {
        const countryCode = this.elements.countryCode?.value;
        const phoneNumber = this.elements.phoneNumber?.value;
        
        const validation = this.validatePhone(phoneNumber, countryCode);
        if (!validation.valid) {
            this.showError('phone', validation.message);
            return;
        }

        const fullPhone = this.getFullPhoneNumber();
        this.state.currentPhone = fullPhone;

        this.setButtonLoading(this.elements.sendOtpButton, true, 'جاري الإرسال...');

        try {
            const response = await fetch('/customer/login/phone/send-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ phone: fullPhone })
            });

            const data = await response.json();

            if (data.success) {
                this.showOtpForm();
                this.showAlert(data.message, 'success');
                this.startResendTimer();
                setTimeout(() => {
                    if (this.elements.otpCode) {
                        this.elements.otpCode.focus();
                    }
                }, 300);
            } else {
                this.showAlert(data.message || 'حدث خطأ أثناء إرسال رمز التحقق', 'error');
            }
        } catch (error) {
            console.error('OTP Send Error:', error);
            this.showAlert('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        } finally {
            this.setButtonLoading(this.elements.sendOtpButton, false, 'إرسال رمز التحقق عبر WhatsApp');
        }
    }

    async verifyOtp() {
        const otpCode = this.elements.otpCode?.value;
        
        if (!otpCode) {
            this.showError('otp', 'يرجى إدخال رمز التحقق');
            return;
        }

        if (otpCode.length !== this.config.otpLength) {
            this.showError('otp', `رمز التحقق يجب أن يكون ${this.config.otpLength} أرقام`);
            return;
        }

        this.setButtonLoading(this.elements.verifyOtpButton, true, 'جاري التحقق...');

        try {
            const response = await fetch('/customer/login/phone/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ 
                    phone: this.state.currentPhone,
                    otp: otpCode 
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect_url || '/customer/account';
                }, 1500);
            } else {
                this.showAlert(data.message || 'رمز التحقق غير صحيح', 'error');
                if (this.elements.otpCode) {
                    this.elements.otpCode.focus();
                    this.elements.otpCode.select();
                }
            }
        } catch (error) {
            console.error('OTP Verify Error:', error);
            this.showAlert('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.', 'error');
        } finally {
            this.setButtonLoading(this.elements.verifyOtpButton, false, 'تسجيل الدخول');
        }
    }

    async resendOtp() {
        if (this.state.resendCount >= this.config.maxResendAttempts) {
            this.showAlert('تم تجاوز الحد الأقصى لإعادة الإرسال. يرجى المحاولة لاحقاً.', 'error');
            return;
        }

        this.state.resendCount++;
        await this.sendOtp();
    }

    showOtpForm() {
        this.hideElement(this.elements.phoneInputForm);
        this.showElement(this.elements.otpVerificationForm);
        
        if (this.elements.otpCode) {
            this.elements.otpCode.value = '';
        }
    }

    backToPhoneInput() {
        this.hideElement(this.elements.otpVerificationForm);
        this.showElement(this.elements.phoneInputForm);
        
        if (this.elements.otpCode) {
            this.elements.otpCode.value = '';
        }
        
        this.clearAlerts();
        this.stopResendTimer();
        
        setTimeout(() => {
            if (this.elements.phoneNumber) {
                this.elements.phoneNumber.focus();
            }
        }, 100);
    }

    startResendTimer() {
        let timeLeft = this.config.resendTimeoutSeconds;
        
        // إخفاء زر الإعادة وإظهار العداد
        this.hideElement(this.elements.resendOtpButton);
        
        const updateTimer = () => {
            if (timeLeft <= 0) {
                this.stopResendTimer();
                return;
            }
            
            if (this.elements.resendTimer) {
                this.elements.resendTimer.textContent = `إعادة الإرسال خلال ${timeLeft} ثانية`;
            }
            
            timeLeft--;
        };
        
        updateTimer();
        this.state.resendTimer = setInterval(updateTimer, 1000);
    }

    stopResendTimer() {
        if (this.state.resendTimer) {
            clearInterval(this.state.resendTimer);
            this.state.resendTimer = null;
        }
        
        // إظهار زر الإعادة وإخفاء العداد
        this.showElement(this.elements.resendOtpButton);
        if (this.elements.resendTimer) {
            this.elements.resendTimer.textContent = '';
        }
    }

    showError(field, message) {
        const errorElement = field === 'phone' ? this.elements.phoneError : this.elements.otpError;
        const inputElement = field === 'phone' ? this.elements.phoneNumber : this.elements.otpCode;
        
        if (errorElement) {
            errorElement.textContent = message;
            this.showElement(errorElement);
        }
        
        if (inputElement) {
            inputElement.style.borderColor = '#ef4444';
            inputElement.focus();
            
            const removeRedBorder = () => {
                inputElement.style.borderColor = '';
                inputElement.removeEventListener('input', removeRedBorder);
            };
            inputElement.addEventListener('input', removeRedBorder);
        }
    }

    clearError(field) {
        const errorElement = field === 'phone' ? this.elements.phoneError : this.elements.otpError;
        
        if (errorElement) {
            this.hideElement(errorElement);
            errorElement.textContent = '';
        }
    }

    showAlert(message, type) {
        const alertClass = type === 'success' ? 
            'bg-green-50 border border-green-200 text-green-800' : 
            'bg-red-50 border border-red-200 text-red-800';
        
        const iconSvg = type === 'success' ? 
            `<svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>` :
            `<svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>`;

        if (this.elements.alertMessage) {
            this.elements.alertMessage.className = `flex items-center gap-3 p-4 rounded-xl ${alertClass}`;
            this.elements.alertMessage.innerHTML = `
                ${iconSvg}
                <span class="flex-1">${message}</span>
                <button type="button" onclick="window.phoneLoginManager?.clearAlerts()" class="text-current opacity-50 hover:opacity-100">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            `;
            this.showElementFlex(this.elements.alertMessage);
            
            this.elements.alertMessage.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    }

    clearAlerts() {
        if (this.elements.alertMessage) {
            this.hideElement(this.elements.alertMessage);
            this.elements.alertMessage.innerHTML = '';
        }

        this.clearError('phone');
        this.clearError('otp');
    }

    setButtonLoading(button, isLoading, text) {
        if (!button) return;

        if (isLoading) {
            button.disabled = true;
            button.style.opacity = '0.75';
            button.innerHTML = `
                <svg class="inline-block w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                ${text}
            `;
        } else {
            button.disabled = false;
            button.style.opacity = '';
            
            if (button === this.elements.sendOtpButton) {
                button.innerHTML = `
                    <svg class="inline-block w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    ${text}
                `;
            } else if (button === this.elements.verifyOtpButton) {
                button.innerHTML = `
                    <svg class="inline-block w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    ${text}
                `;
            }
        }
    }

    destroy() {
        this.stopResendTimer();
    }
}

// Export for integration with main app
export default PhoneLoginManager;