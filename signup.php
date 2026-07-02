<?php
/**
 * Signup Page — bookHotel Authentication
 */
session_start();
require_once 'db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit();
}

$error   = '';
$success = '';
$form    = ['full_name' => '', 'email' => '', 'mobile' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name       = trim($_POST['full_name']       ?? '');
    $email           = trim($_POST['email']            ?? '');
    $mobile          = trim($_POST['mobile']           ?? '');
    $password        = $_POST['password']              ?? '';
    $confirm_password = $_POST['confirm_password']    ?? '';

    $form = ['full_name' => $full_name, 'email' => $email, 'mobile' => $mobile];

    // ---- Validation ----
    if (empty($full_name) || empty($email) || empty($mobile) || empty($password) || empty($confirm_password)) {
        $error = 'All fields are required.';
    } elseif (strlen($full_name) < 3) {
        $error = 'Full name must be at least 3 characters.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } elseif (!validateMobile($mobile)) {
        $error = 'Please enter a valid 10-digit mobile number.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $error = 'Password must contain at least one uppercase letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = 'Password must contain at least one number.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (emailExists($email)) {
        $error = 'This email is already registered. <a href="login.php">Sign in instead</a>.';
    } elseif (mobileExists($mobile)) {
        $error = 'This mobile number is already registered.';
    } else {
        // Split full name into first + last
        $name_parts = explode(' ', $full_name, 2);
        $first_name = sanitize($name_parts[0]);
        $last_name  = sanitize($name_parts[1] ?? '');
        $email_s    = sanitize($email);
        $mobile_s   = sanitize($mobile);
        $hash       = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $sql = "INSERT INTO users (first_name, last_name, email, mobile, password)
                VALUES ('$first_name', '$last_name', '$email_s', '$mobile_s', '$hash')";

        if (mysqli_query($conn, $sql)) {
            header('Location: login.php?registered=1');
            exit();
        } else {
            $error = 'Registration failed. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Account — bookHotel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="auth.css"/>
</head>
<body class="auth-body">

<div class="auth-wrapper">

  <!-- ===== LEFT PANEL ===== -->
  <div class="auth-left d-none d-lg-flex">
    <div class="auth-left-inner">
      <a href="index.html" class="brand-logo">
        <i class="bi bi-building-fill"></i>
        <span>bookHotel</span>
      </a>

      <div class="left-content">
        <div class="travel-illustration signup-illus">
          <div class="illus-circle illus-circle--1"></div>
          <div class="illus-circle illus-circle--2"></div>
          <div class="illus-circle illus-circle--3"></div>
          <div class="illus-hotel-img">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=520&q=85"
                 alt="Luxury Resort" class="illus-photo"/>
            <div class="illus-badge illus-badge--top">
              <i class="bi bi-percent text-warning me-1"></i>
              <span>Up to 50% Off</span>
            </div>
            <div class="illus-badge illus-badge--bottom">
              <i class="bi bi-gift-fill text-danger me-1"></i>
              <span>₹1000 Welcome Bonus</span>
            </div>
          </div>
        </div>

        <h2 class="left-heading">Unlock Exclusive<br/>Member Benefits</h2>
        <p class="left-subtext">Create your free account and get instant access to member-only deals and early bird offers.</p>

        <div class="benefit-list">
          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-tag-fill"></i></div>
            <span>Member-only prices up to 50% off</span>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-bookmark-star-fill"></i></div>
            <span>Save favourite hotels & wishlists</span>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-receipt-cutoff"></i></div>
            <span>Track all bookings in one place</span>
          </div>
          <div class="benefit-item">
            <div class="benefit-icon"><i class="bi bi-bell-fill"></i></div>
            <span>Price drop alerts on saved hotels</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== RIGHT PANEL ===== -->
  <div class="auth-right">
    <div class="auth-form-wrap">

      <!-- Mobile brand -->
      <a href="index.html" class="brand-logo brand-logo--mobile d-flex d-lg-none">
        <i class="bi bi-building-fill"></i>
        <span>bookHotel</span>
      </a>

      <div class="form-header">
        <h1 class="form-title">Create account</h1>
        <p class="form-subtitle">Start booking your dream stays today</p>
      </div>

      <?php if ($error): ?>
      <div class="alert-msg alert-msg--error" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i><?= $error ?>
      </div>
      <?php endif; ?>

      <form method="POST" action="signup.php" id="signupForm" novalidate>

        <div class="field-group">
          <label class="field-label" for="full_name">Full Name</label>
          <div class="field-wrap">
            <span class="field-icon"><i class="bi bi-person-fill"></i></span>
            <input
              type="text"
              id="full_name"
              name="full_name"
              class="field-input"
              placeholder="Enter your full name"
              value="<?= htmlspecialchars($form['full_name']) ?>"
              autocomplete="name"
              required
            />
          </div>
          <span class="field-error" id="fullNameError"></span>
        </div>

        <div class="field-group">
          <label class="field-label" for="email">Email Address</label>
          <div class="field-wrap">
            <span class="field-icon"><i class="bi bi-envelope-fill"></i></span>
            <input
              type="email"
              id="email"
              name="email"
              class="field-input"
              placeholder="Enter your email"
              value="<?= htmlspecialchars($form['email']) ?>"
              autocomplete="email"
              required
            />
          </div>
          <span class="field-error" id="emailError"></span>
        </div>

        <div class="field-group">
          <label class="field-label" for="mobile">Mobile Number</label>
          <div class="field-wrap">
            <span class="field-icon"><i class="bi bi-phone-fill"></i></span>
            <span class="field-prefix">+91</span>
            <input
              type="tel"
              id="mobile"
              name="mobile"
              class="field-input field-input--prefix"
              placeholder="10-digit mobile number"
              value="<?= htmlspecialchars($form['mobile']) ?>"
              autocomplete="tel"
              maxlength="10"
              required
            />
          </div>
          <span class="field-error" id="mobileError"></span>
        </div>

        <div class="row g-3">
          <div class="col-12 col-sm-6">
            <div class="field-group mb-0">
              <label class="field-label" for="password">Password</label>
              <div class="field-wrap">
                <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="field-input"
                  placeholder="Min. 8 characters"
                  autocomplete="new-password"
                  required
                />
                <button type="button" class="toggle-password" id="togglePassword" aria-label="Show/hide password">
                  <i class="bi bi-eye-fill" id="toggleIcon"></i>
                </button>
              </div>
              <span class="field-error" id="passwordError"></span>
            </div>
          </div>
          <div class="col-12 col-sm-6">
            <div class="field-group mb-0">
              <label class="field-label" for="confirm_password">Confirm Password</label>
              <div class="field-wrap">
                <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
                <input
                  type="password"
                  id="confirm_password"
                  name="confirm_password"
                  class="field-input"
                  placeholder="Re-enter password"
                  autocomplete="new-password"
                  required
                />
                <button type="button" class="toggle-password" id="toggleConfirmPassword" aria-label="Show/hide password">
                  <i class="bi bi-eye-fill" id="toggleConfirmIcon"></i>
                </button>
              </div>
              <span class="field-error" id="confirmPasswordError"></span>
            </div>
          </div>
        </div>

        <!-- Password strength -->
        <div class="password-strength mt-2" id="strengthContainer" style="display:none">
          <div class="strength-bar">
            <div class="strength-fill" id="strengthFill"></div>
          </div>
          <span class="strength-label" id="strengthLabel"></span>
        </div>

        <div class="terms-row mt-3">
          <label class="remember-label">
            <input type="checkbox" name="agree_terms" id="agree_terms" class="remember-check" required/>
            <span class="remember-custom"></span>
            I agree to the <a href="#" class="switch-link">Terms of Service</a> and <a href="#" class="switch-link">Privacy Policy</a>
          </label>
          <span class="field-error" id="termsError"></span>
        </div>

        <button type="submit" class="btn-auth mt-3" id="signupBtn">
          <span class="btn-auth-text">Create Account</span>
          <i class="bi bi-person-check-fill ms-2"></i>
        </button>

        <p class="switch-auth">
          Already have an account?
          <a href="login.php" class="switch-link">Sign in</a>
        </p>

      </form>
    </div>
  </div>
</div>

<script src="auth.js"></script>
</body>
</html>
