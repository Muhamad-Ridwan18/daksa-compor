/**
 * PPh21 Calculator Utilities
 * Auto-format currency input with thousand separator
 */

/**
 * Format number dengan thousand separator (titik)
 * @param {string|number} value - Nilai yang akan diformat
 * @returns {string} - String yang sudah diformat (contoh: "1.000.000")
 */
function formatCurrency(value) {
    if (!value && value !== 0) return '';
    
    // Hapus semua karakter non-digit
    const numericValue = String(value).replace(/\D/g, '');
    
    if (!numericValue) return '';
    
    // Format dengan thousand separator (titik)
    return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

/**
 * Unformat currency (hapus separator, return angka saja)
 * @param {string} value - String yang sudah diformat
 * @returns {string} - String angka tanpa separator (contoh: "1000000")
 */
function unformatCurrency(value) {
    if (!value) return '';
    return String(value).replace(/\./g, '');
}

/**
 * Initialize auto-format untuk semua input dengan class atau attribute tertentu
 */
function initCurrencyFormatting() {
    // Cari semua input dengan class 'currency-input' atau data-attribute 'currency'
    const currencyInputs = document.querySelectorAll(
        'input[type="text"].currency-input, input[type="number"].currency-input, input[data-currency="true"]'
    );

    currencyInputs.forEach(input => {
        // Set type ke text untuk menghindari masalah dengan number input
        if (input.type === 'number') {
            input.type = 'text';
            input.setAttribute('inputmode', 'numeric');
        }

        // Format saat input (real-time)
        input.addEventListener('input', function(e) {
            const cursorPosition = this.selectionStart;
            const oldValue = this.value;
            const oldLength = oldValue.length;
            
            // Unformat dulu, lalu format lagi
            const unformatted = unformatCurrency(this.value);
            const formatted = formatCurrency(unformatted);
            
            this.value = formatted;
            
            // Maintain cursor position setelah format
            const newLength = formatted.length;
            const lengthDiff = newLength - oldLength;
            
            // Hitung posisi cursor baru
            let newCursorPosition = cursorPosition;
            if (lengthDiff > 0) {
                // Ada penambahan karakter (titik)
                // Hitung berapa titik yang ditambahkan sebelum cursor
                const beforeCursor = oldValue.substring(0, cursorPosition);
                const unformattedBefore = unformatCurrency(beforeCursor);
                const formattedBefore = formatCurrency(unformattedBefore);
                newCursorPosition = formattedBefore.length;
            } else if (lengthDiff < 0) {
                // Ada pengurangan karakter
                const beforeCursor = oldValue.substring(0, cursorPosition);
                const unformattedBefore = unformatCurrency(beforeCursor);
                const formattedBefore = formatCurrency(unformattedBefore);
                newCursorPosition = formattedBefore.length;
            }
            
            // Set cursor position
            this.setSelectionRange(newCursorPosition, newCursorPosition);
        });

        // Format saat blur (pastikan format benar saat keluar dari field)
        input.addEventListener('blur', function(e) {
            const unformatted = unformatCurrency(this.value);
            if (unformatted) {
                this.value = formatCurrency(unformatted);
            }
        });

        // Format saat paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData('text');
            const unformatted = unformatCurrency(pastedData);
            const formatted = formatCurrency(unformatted);
            
            // Insert formatted value
            const start = this.selectionStart;
            const end = this.selectionEnd;
            const currentValue = this.value;
            this.value = currentValue.substring(0, start) + formatted + currentValue.substring(end);
            
            // Set cursor position setelah paste
            const newPosition = start + formatted.length;
            this.setSelectionRange(newPosition, newPosition);
        });

        // Prevent non-numeric input (kecuali titik yang sudah ada)
        input.addEventListener('keydown', function(e) {
            // Allow: backspace, delete, tab, escape, enter, home, end, arrow keys
            if ([8, 9, 27, 13, 46, 35, 36, 37, 38, 39, 40].indexOf(e.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (e.keyCode === 65 && e.ctrlKey === true) ||
                (e.keyCode === 67 && e.ctrlKey === true) ||
                (e.keyCode === 86 && e.ctrlKey === true) ||
                (e.keyCode === 88 && e.ctrlKey === true)) {
                return;
            }
            
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
}

/**
 * Get numeric value dari input yang sudah diformat
 * @param {HTMLElement|string} input - Input element atau selector
 * @returns {number} - Nilai numerik
 */
function getCurrencyValue(input) {
    const element = typeof input === 'string' ? document.querySelector(input) : input;
    if (!element) return 0;
    const unformatted = unformatCurrency(element.value);
    return parseFloat(unformatted) || 0;
}

/**
 * Set value ke input dengan auto-format
 * @param {HTMLElement|string} input - Input element atau selector
 * @param {number|string} value - Nilai yang akan diset
 */
function setCurrencyValue(input, value) {
    const element = typeof input === 'string' ? document.querySelector(input) : input;
    if (!element) return;
    element.value = formatCurrency(value);
}

/**
 * Handle form submission - unformat semua currency input sebelum submit
 * @param {HTMLFormElement} form - Form element
 */
function handleCurrencyFormSubmit(form) {
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        // Unformat semua currency input sebelum submit
        const currencyInputs = form.querySelectorAll(
            'input.currency-input, input[data-currency="true"]'
        );
        
        currencyInputs.forEach(input => {
            const unformatted = unformatCurrency(input.value);
            // Buat hidden input dengan nilai unformatted
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = input.name;
            hiddenInput.value = unformatted || '0';
            form.appendChild(hiddenInput);
            
            // Disable original input agar tidak ikut submit
            input.disabled = true;
        });
    });
}

/**
 * Initialize form handler untuk kalkulator PPh21
 */
function initPPh21Form() {
    const form = document.querySelector('#pph21-calculator-form, form[data-pph21-calculator]');
    if (form) {
        handleCurrencyFormSubmit(form);
    }
}

// Initialize saat DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        initCurrencyFormatting();
        initPPh21Form();
    });
} else {
    initCurrencyFormatting();
    initPPh21Form();
}

// Export untuk penggunaan di file lain
window.PPh21Calculator = {
    formatCurrency,
    unformatCurrency,
    getCurrencyValue,
    setCurrencyValue,
    initCurrencyFormatting,
    handleCurrencyFormSubmit,
    initPPh21Form
};

