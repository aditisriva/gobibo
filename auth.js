/**
 * auth.js — bookHotel Frontend Authentication
 * Handles: floating labels, validation, password strength,
 *          show/hide password, page transitions, toast,
 *          forgot-password modal, loading states.
 */

'use strict';

/* ═══════════════════════════════════════════
   UTILITIES
═══════════════════════════════════════════ */

/**
 * Show an inline field error and mark input invalid.
 * @param {HTMLElement} input
 * @param {HTMLElement} errEl
 * @param {string} msg
 */
function setInvalid(input, errEl, msg) {
  input.classList.add('is-invalid');
  input.classList.remove('is-valid');
  if (errEl) errEl.textContent = msg;

  const statusEl = input.closest('.fl-wrap')?.querySelector('.fl-status');
  if (statusEl) {
    statusEl.innerHTML = '<i class="bi bi-x-circle-fill" style="color:#dc2626"></i>';
  }
}

/**
 * Mark input as valid, clear error.
 * @param {HTMLElement} input
 * @param {HTMLElement} errEl
 */
function setValid(input, errEl) {
  input.classList.remove('is-invalid');
  input.classList.add('is-valid');
  if (errEl) errEl.textContent = '';

  const statusEl = input.closest('.fl-wrap')?.querySelector('.fl-status');
  if (statusEl) {
    statusEl.innerHTML = '<i class="bi bi-check-circle-fill" style="color:#16a34a"></i>';
  }
}

/** Clear validation state entirely */
function clearState(input, errEl) {
  input.classList.remove('is-invalid', 'is-valid');
  if (errEl) errEl.textContent = '';
  const statusEl = input.closest('.fl-wrap')?.querySelector('.fl-status');
  if (statusEl) statusEl.innerHTML = '';
}

/** Shake animation on error */
function shakeField(input) {
  const wrap = input.closest('.fl-group') || input;
  wrap.animate([
    { transform: 'translateX(0)' },
    { transform: 'translateX(-6px)' },
    { transform: 'translateX(6px)' },
    { transform: 'translateX(-4px)' },
    { transform: 'translateX(4px)' },
    { transform: 'translateX(0)' }
  ], { duration: 320, easing: 'ease-out' });
}

/** Show toast notification */
function showToast(message, type = 'success') {
  const container = document.getElementById('toastContainer');
  if (!container) return;
  const toast = document.createElement('div');
  toast.className = `toast-item toast-${type}`;
  const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
  toast.innerHTML = `<i class="bi ${icon}"></i><span>${message}</span>`;
  container.appendChild(toast);
  setTimeout(() => {
    toast.style.animation = 'toastIn .3s ease reverse forwards';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

/** Page transition between login & signup */
function pageTransition(targetURL) {
  const overlay = document.getElementById('pageOverlay');
  if (!overlay) { window.location.href = targetURL; return; }

  overlay.classList.add('slide-in');
  setTimeout(() => {
    window.location.href = targetURL;
  }, 500);
}

/** Email format check */
function isValidEmail(str) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(str);
}

/** Mobile: 10 digits starting with 6-9 */
function isValidMobile(str) {
  return /^[6-9]\d{9}$/.test(str.replace(/\D/g, ''));
}

/** Password strength scoring (1-4) */
function scorePassword(password) {
  if (!password) return 0;
  let score = 0;
  if (password.length >= 8) score++;
  if (/[A-Z]/.test(password)) score++;
  if (/\d/.test(password)) score++;
  if (/[^A-Za-z0-9]/.test(password)) score++;
  return score;
}

/* ═══════════════════════════════════════════
   LOGIN PAGE
═══════════════════════════════════════════ */
if (document.getElementById('loginForm')) {
  const form = document.getElementById('loginForm');
  const identifier = document.getElementById('identifier');
  const password = document.getElementById('password');
  const identifierErr = document.getElementById('identifierErr');
  const passwordErr = document.getElementById('passwordErr');
  const togglePwd = document.getElementById('togglePwd');
  const eyeIcon = document.getElementById('eyeIcon');
  const loginBtn = document.getElementById('loginBtn');
  const loginBtnLabel = document.getElementById('loginBtnLabel');
  const loginBtnLoader = document.getElementById('loginBtnLoader');
  const alertError = document.getElementById('alertError');
  const alertSuccess = document.getElementById('alertSuccess');
  const alertErrorMsg = document.getElementById('alertErrorMsg');

  // Toggle password visibility
  if (togglePwd && eyeIcon) {
    togglePwd.addEventListener('click', () => {
      const isPass = password.type === 'password';
      password.type = isPass ? 'text' : 'password';
      eyeIcon.className = isPass ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
  }

  // Forgot password modal
  const forgotLink = document.getElementById('forgotLink');
  const forgotModal = document.getElementById('forgotModal');
  const closeModal = document.getElementById('closeModal');
  const sendResetBtn = document.getElementById('sendResetBtn');
  const resetEmail = document.getElementById('resetEmail');
  const resetErr = document.getElementById('resetErr');
  const resetSuccess = document.getElementById('resetSuccess');

  if (forgotLink && forgotModal) {
    forgotLink.addEventListener('click', (e) => {
      e.preventDefault();
      forgotModal.classList.add('open');
    });
  }
  if (closeModal && forgotModal) {
    closeModal.addEventListener('click', () => forgotModal.classList.remove('open'));
    forgotModal.addEventListener('click', (e) => {
      if (e.target === forgotModal) forgotModal.classList.remove('open');
    });
  }
  if (sendResetBtn && resetEmail && resetSuccess) {
    sendResetBtn.addEventListener('click', () => {
      const email = resetEmail.value.trim();
      if (!email || !isValidEmail(email)) {
        setInvalid(resetEmail, resetErr, 'Please enter a valid email.');
        shakeField(resetEmail);
        return;
      }
      setValid(resetEmail, resetErr);
      sendResetBtn.disabled = true;
      sendResetBtn.textContent = 'Sending...';

      // Simulate API call
      setTimeout(() => {
        sendResetBtn.disabled = false;
        sendResetBtn.innerHTML = '<span class="btn-label">Send Reset Link</span>';
        resetSuccess.classList.remove('d-none');
        setTimeout(() => {
          forgotModal.classList.remove('open');
          resetSuccess.classList.add('d-none');
          resetEmail.value = '';
          clearState(resetEmail, resetErr);
        }, 2000);
      }, 1200);
    });
  }

  // Live validation — identifier
  if (identifier) {
    identifier.addEventListener('blur', () => {
      const val = identifier.value.trim();
      if (!val) {
        setInvalid(identifier, identifierErr, 'Email or mobile number is required.');
      } else if (!isValidEmail(val) && !isValidMobile(val)) {
        setInvalid(identifier, identifierErr, 'Enter a valid email or 10-digit mobile number.');
      } else {
        setValid(identifier, identifierErr);
      }
    });
    identifier.addEventListener('input', () => {
      if (identifier.classList.contains('is-invalid')) clearState(identifier, identifierErr);
    });
  }

  // Live validation — password
  if (password) {
    password.addEventListener('blur', () => {
      if (!password.value) {
        setInvalid(password, passwordErr, 'Password is required.');
      } else {
        setValid(password, passwordErr);
      }
    });
    password.addEventListener('input', () => {
      if (password.classList.contains('is-invalid')) clearState(password, passwordErr);
    });
  }

  // Form submit
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let valid = true;

      const idVal = identifier ? identifier.value.trim() : '';
      const pwVal = password ? password.value : '';

      if (!idVal) {
        setInvalid(identifier, identifierErr, 'Email or mobile number is required.');
        shakeField(identifier); valid = false;
      } else if (!isValidEmail(idVal) && !isValidMobile(idVal)) {
        setInvalid(identifier, identifierErr, 'Enter a valid email or 10-digit mobile number.');
        shakeField(identifier); valid = false;
      } else {
        setValid(identifier, identifierErr);
      }

      if (!pwVal) {
        setInvalid(password, passwordErr, 'Password is required.');
        shakeField(password); valid = false;
      } else {
        setValid(password, passwordErr);
      }

      if (!valid) {
        if (alertError) {
          alertErrorMsg.textContent = 'Please fix the errors above.';
          alertError.classList.remove('d-none');
        }
        return;
      }

      // Show loading state
      if (alertError) alertError.classList.add('d-none');
      if (loginBtnLabel) loginBtnLabel.classList.add('d-none');
      if (loginBtnLoader) loginBtnLoader.classList.remove('d-none');
      loginBtn.disabled = true;

      // Simulate authentication (demo only — no real backend)
      setTimeout(() => {
        loginBtnLabel.classList.remove('d-none');
        loginBtnLoader.classList.add('d-none');
        loginBtn.disabled = false;

        // Demo: show success on any input, show error if password is "wrong"
        if (pwVal === 'wrongpassword') {
          alertErrorMsg.textContent = 'Invalid email or password. Please try again.';
          alertError.classList.remove('d-none');
          setInvalid(password, passwordErr, 'Incorrect password.');
          shakeField(password);
          showToast('Login failed. Check your credentials.', 'error');
        } else {
          // Save login state to localStorage (demo user: Aditi)
          localStorage.setItem('bh_user', JSON.stringify({
            name:   'Aditi',
            email:  identifier ? identifier.value.trim() : 'aditi@bookhotel.com',
            avatar: 'A'
          }));
          alertSuccess.classList.remove('d-none');
          showToast('Signed in successfully!', 'success');
          setTimeout(() => pageTransition('index.html'), 1200);
        }
      }, 1600);
    });
  }

  // Transition links
  document.querySelectorAll('[id="goSignup"], [id="switchToSignup"]').forEach(link => {
    link.addEventListener('click', (e) => { e.preventDefault(); pageTransition('signup.html'); });
  });
}

/* ═══════════════════════════════════════════
   SIGNUP PAGE
═══════════════════════════════════════════ */
if (document.getElementById('signupForm')) {
  const form            = document.getElementById('signupForm');
  const fullName        = document.getElementById('fullName');
  const email           = document.getElementById('email');
  const mobile          = document.getElementById('mobile');
  const password        = document.getElementById('password');
  const confirmPassword = document.getElementById('confirmPassword');
  const agreeTerms      = document.getElementById('agreeTerms');

  const fullNameErr     = document.getElementById('fullNameErr');
  const emailErr        = document.getElementById('emailErr');
  const mobileErr       = document.getElementById('mobileErr');
  const passwordErr     = document.getElementById('passwordErr');
  const confirmErr      = document.getElementById('confirmErr');
  const termsErr        = document.getElementById('termsErr');

  const signupBtn       = document.getElementById('signupBtn');
  const signupBtnLabel  = document.getElementById('signupBtnLabel');
  const signupBtnLoader = document.getElementById('signupBtnLoader');
  const alertError      = document.getElementById('alertError');
  const alertErrorMsg   = document.getElementById('alertErrorMsg');
  const alertSuccess    = document.getElementById('alertSuccess');

  // Password strength meter
  const strengthWrap  = document.getElementById('strengthWrap');
  const strengthFill  = document.getElementById('strengthFill');
  const strengthLabel = document.getElementById('strengthLabel');
  const ruleLen   = document.getElementById('rule-len');
  const ruleUpper = document.getElementById('rule-upper');
  const ruleNum   = document.getElementById('rule-num');
  const ruleSym   = document.getElementById('rule-sym');

  const strengthText  = ['', 'Weak', 'Fair', 'Good', 'Strong'];
  const strengthColor = ['', '#ef4444', '#f97316', '#eab308', '#22c55e'];

  function updateStrength(pwd) {
    if (!strengthWrap) return;
    if (!pwd) { strengthWrap.style.display = 'none'; return; }
    strengthWrap.style.display = 'block';

    const score = scorePassword(pwd);
    if (strengthFill) {
      strengthFill.setAttribute('data-s', score);
    }
    if (strengthLabel) {
      strengthLabel.textContent = strengthText[score] || '';
      strengthLabel.style.color = strengthColor[score] || '';
    }

    // Rule checkers
    function rulePass(ruleEl, pass) {
      if (!ruleEl) return;
      ruleEl.classList.toggle('pass', pass);
      const icon = ruleEl.querySelector('i');
      if (icon) icon.className = pass ? 'bi bi-check-circle-fill' : 'bi bi-circle';
    }
    rulePass(ruleLen,   pwd.length >= 8);
    rulePass(ruleUpper, /[A-Z]/.test(pwd));
    rulePass(ruleNum,   /\d/.test(pwd));
    rulePass(ruleSym,   /[^A-Za-z0-9]/.test(pwd));
  }

  // Show/hide password toggles
  function initEyeToggle(btnId, iconId, inputEl) {
    const btn = document.getElementById(btnId);
    const icon = document.getElementById(iconId);
    if (!btn || !icon || !inputEl) return;
    btn.addEventListener('click', () => {
      const show = inputEl.type === 'password';
      inputEl.type = show ? 'text' : 'password';
      icon.className = show ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
    });
  }
  initEyeToggle('togglePwd', 'eyeIcon', password);
  initEyeToggle('toggleConfirm', 'eyeConfirmIcon', confirmPassword);

  // Mobile: digits only
  if (mobile) {
    mobile.addEventListener('input', () => {
      mobile.value = mobile.value.replace(/\D/g, '').slice(0, 10);
    });
  }

  // Password strength on input
  if (password) {
    password.addEventListener('input', () => updateStrength(password.value));
  }

  // ── Live validation helpers ──
  function validateFullName() {
    const val = fullName ? fullName.value.trim() : '';
    if (!val)           { setInvalid(fullName, fullNameErr, 'Full name is required.'); return false; }
    if (val.length < 3) { setInvalid(fullName, fullNameErr, 'Name must be at least 3 characters.'); return false; }
    if (!/^[a-zA-Z\s'-]+$/.test(val)) { setInvalid(fullName, fullNameErr, 'Name can only contain letters, spaces, hyphens, or apostrophes.'); return false; }
    setValid(fullName, fullNameErr); return true;
  }
  function validateEmail() {
    const val = email ? email.value.trim() : '';
    if (!val)                { setInvalid(email, emailErr, 'Email address is required.'); return false; }
    if (!isValidEmail(val))  { setInvalid(email, emailErr, 'Enter a valid email address.'); return false; }
    setValid(email, emailErr); return true;
  }
  function validateMobile() {
    const val = mobile ? mobile.value.trim() : '';
    if (!val)                 { setInvalid(mobile, mobileErr, 'Mobile number is required.'); return false; }
    if (!isValidMobile(val))  { setInvalid(mobile, mobileErr, 'Enter a valid 10-digit mobile number.'); return false; }
    setValid(mobile, mobileErr); return true;
  }
  function validatePassword() {
    const val = password ? password.value : '';
    if (!val)              { setInvalid(password, passwordErr, 'Password is required.'); return false; }
    if (val.length < 8)    { setInvalid(password, passwordErr, 'Password must be at least 8 characters.'); return false; }
    if (!/[A-Z]/.test(val)) { setInvalid(password, passwordErr, 'Include at least one uppercase letter.'); return false; }
    if (!/\d/.test(val))    { setInvalid(password, passwordErr, 'Include at least one number.'); return false; }
    setValid(password, passwordErr); return true;
  }
  function validateConfirm() {
    const val = confirmPassword ? confirmPassword.value : '';
    const pwdVal = password ? password.value : '';
    if (!val)           { setInvalid(confirmPassword, confirmErr, 'Please confirm your password.'); return false; }
    if (val !== pwdVal) { setInvalid(confirmPassword, confirmErr, 'Passwords do not match.'); return false; }
    setValid(confirmPassword, confirmErr); return true;
  }

  // Attach blur validators
  if (fullName)        fullName.addEventListener('blur', validateFullName);
  if (email)           email.addEventListener('blur', validateEmail);
  if (mobile)          mobile.addEventListener('blur', validateMobile);
  if (password)        password.addEventListener('blur', validatePassword);
  if (confirmPassword) confirmPassword.addEventListener('blur', validateConfirm);

  // Clear on input
  [
    [fullName, fullNameErr], [email, emailErr], [mobile, mobileErr],
    [password, passwordErr], [confirmPassword, confirmErr]
  ].forEach(([inp, err]) => {
    if (inp) {
      inp.addEventListener('input', () => {
        if (inp.classList.contains('is-invalid')) clearState(inp, err);
      });
    }
  });

  // ── Form submit ──
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      // Run all validators
      const checks = [
        validateFullName(),
        validateEmail(),
        validateMobile(),
        validatePassword(),
        validateConfirm()
      ];

      // Terms check
      let termsOk = true;
      if (agreeTerms && !agreeTerms.checked) {
        if (termsErr) termsErr.textContent = 'You must agree to the Terms of Service.';
        termsOk = false;
      } else {
        if (termsErr) termsErr.textContent = '';
      }

      const allValid = checks.every(Boolean) && termsOk;
      if (!allValid) {
        if (alertError) {
          alertErrorMsg.textContent = 'Please fix the errors above to continue.';
          alertError.classList.remove('d-none');
        }
        // Scroll to first invalid
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) firstInvalid.focus();
        return;
      }

      if (alertError) alertError.classList.add('d-none');

      // Loading state
      if (signupBtnLabel)  signupBtnLabel.classList.add('d-none');
      if (signupBtnLoader) signupBtnLoader.classList.remove('d-none');
      signupBtn.disabled = true;

      // Simulate account creation (frontend demo only)
      setTimeout(() => {
        if (signupBtnLabel)  signupBtnLabel.classList.remove('d-none');
        if (signupBtnLoader) signupBtnLoader.classList.add('d-none');
        signupBtn.disabled = false;

        alertSuccess.classList.remove('d-none');
        showToast('Account created! Welcome to bookHotel 🎉', 'success');
        form.reset();
        if (strengthWrap) strengthWrap.style.display = 'none';

        setTimeout(() => pageTransition('login.html'), 1800);
      }, 1800);
    });
  }
}

/* ═══════════════════════════════════════════
   ENTRANCE ANIMATION on page load
═══════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  const overlay = document.getElementById('pageOverlay');
  if (overlay) {
    // animate out overlay on load (page-in effect)
    overlay.classList.add('slide-in');
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        overlay.classList.remove('slide-in');
        overlay.classList.add('slide-out');
        setTimeout(() => overlay.classList.remove('slide-out'), 500);
      });
    });
  }

  // Stagger form fields fade-in
  const fields = document.querySelectorAll('.fl-group, .check-row, .btn-submit, .or-divider, .social-row, .switch-txt, .form-head');
  fields.forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = `opacity .4s ease ${i * 0.06}s, transform .4s ease ${i * 0.06}s`;
    setTimeout(() => {
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
    }, 80 + i * 60);
  });
});
