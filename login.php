<?php
/**
 * Login Page — bookHotel Authentication
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
$email_val = '';

// Handle Remember Me cookie
if (isset($_COOKIE['remember_email'])) {
    $email_val = htmlspecialchars($_COOKIE['remember_email']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier  = trim($_POST['identifier'] ?? '');
    $password    = trim($_POST['password']   ?? '');
    $remember_me = isset($_POST['remember_me']);

    // Basic validation
    if (empty($identifier) || empty($password)) {
        $error = 'Please fill in all fields.';
    } elseif (!checkLoginAttempts($identifier)) {
        $error = 'Too many failed attempts. Please try again after 15 minutes.';
    } else {
        // Support login by email OR mobile
        $identifier_safe = sanitize($identifier);
        $sql = "SELECT id, first_name, last_name, email, password, status
                FROM users
                WHERE email = '$identifier_safe' OR mobile = '$identifier_safe'
                LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            if ($user['status'] !== 'active') {
                $error = 'Your account has been suspended. Please contact support.';
                logLoginAttempt($identifier, false);
            } elseif (password_verify($password, $user['password'])) {
                // Success
                logLoginAttempt($identifier, true);

                $_SESSION['user_id']        = $user['id'];
                $_SESSION['user_name']      = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email']     = $user['email'];
                $_SESSION['user_firstname'] = $user['first_name'];

                // Update last login
                $uid = (int)$user['id'];
                mysqli_query($conn, "UPDATE users SET last_login = NOW() WHERE id = $uid");

                // Remember Me cookie (30 days)
                if ($remember_me) {
                    setcookie('remember_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
                } else {
                    setcookie('remember_email', '', time() - 3600, '/');
                }

                header('Location: index.html');
                exit();
            } else {
                $error = 'Invalid email/mobile or password.';
                logLoginAttempt($identifier, false);
            }
        } else {
            $error = 'Invalid email/mobile or password.';
            logLoginAttempt($identifier, false);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — bookHotel</title>
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
        <div class="travel-illustration">
          <div class="illus-circle illus-circle--1"></div>
          <div class="illus-circle illus-circle--2"></div>
          <div class="illus-circle illus-circle--3"></div>
          <div class="illus-hotel-img">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=520&q=85"
                 alt="Luxury Hotel" class="illus-photo"/>
            <div class="illus-badge illus-badge--top">
              <i class="bi bi-star-fill text-warning me-1"></i>
              <span>4.9 / 5.0 Rating</span>
            </div>
            <div class="illus-badge illus-badge--bottom">
              <i class="bi bi-shield-check-fill text-success me-1"></i>
              <span>Verified Stays</span>
            </div>
          </div>
        </div>

        <h2 class="left-heading">Your Next Adventure<br/>Awaits You</h2>
        <p class="left-subtext">Join 10M+ travellers who trust bookHotel for seamless hotel bookings at the best prices.</p>

        <div class="left-stats">
          <div class="stat-item">
            <span class="stat-num">1M+</span>
            <span class="stat-label">Properties</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num">200+</span>
            <span class="stat-label">Countries</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num">24/7</span>
            <span class="stat-label">Support</span>
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
        <h1 class="form-title">Welcome back</h1>
        <p class="form-subtitle">Sign in to continue booking amazing stays</p>
      </div>

      <?php if ($error): ?>
      <div class="alert-msg alert-msg--error" role="alert">
        <i class="bi bi-exclamation-circle-fill me-2"></i><?= htmlspecialchars($error) ?>
      </div>
      <?php endif; ?>

      <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
      <div class="alert-msg alert-msg--success" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>Account created successfully! Please sign in.
      </div>
      <?php endif; ?>

      <form method="POST" action="login.php" id="loginForm" novalidate>

        <div class="field-group">
          <label class="field-label" for="identifier">Email or Mobile Number</label>
          <div class="field-wrap">
            <span class="field-icon"><i class="bi bi-person-fill"></i></span>
            <input
              type="text"
              id="identifier"
              name="identifier"
              class="field-input"
              placeholder="Enter email or mobile number"
              value="<?= htmlspecialchars($email_val) ?>"
              autocomplete="username"
              required
            />
          </div>
          <span class="field-error" id="identifierError"></span>
        </div>

        <div class="field-group">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <label class="field-label mb-0" for="password">Password</label>
            <a href="forgot-password.php" class="forgot-link">Forgot password?</a>
          </div>
          <div class="field-wrap">
            <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
            <input
              type="password"
              id="password"
              name="password"
              class="field-input"
              placeholder="Enter your password"
              autocomplete="current-password"
              required
            />
            <button type="button" class="toggle-password" id="togglePassword" aria-label="Show/hide password">
              <i class="bi bi-eye-fill" id="toggleIcon"></i>
            </button>
          </div>
          <span class="field-error" id="passwordError"></span>
        </div>

        <div class="remember-row">
          <label class="remember-label">
            <input type="checkbox" name="remember_me" class="remember-check"
              <?= !empty($email_val) ? 'checked' : '' ?>/>
            <span class="remember-custom"></span>
            Remember me for 30 days
          </label>
        </div>

        <button type="submit" class="btn-auth" id="loginBtn">
          <span class="btn-auth-text">Sign In</span>
          <i class="bi bi-arrow-right-circle-fill ms-2"></i>
        </button>

        <div class="divider-or">
          <span>or continue with</span>
        </div>

        <div class="social-auth">
          <button type="button" class="btn-social">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
              <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
              <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
              <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            Google
          </button>
          <button type="button" class="btn-social">
            <i class="bi bi-facebook" style="color:#1877f2;font-size:1.1rem"></i>
            Facebook
          </button>
        </div>

        <p class="switch-auth">
          Don't have an account?
          <a href="signup.php" class="switch-link">Create account</a>
        </p>

      </form>
    </div>
  </div>
</div>

<script src="auth.js"></script>
</body>
</html>
