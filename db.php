<?php
/**
 * Database Configuration and Connection
 * bookHotel Hotel Booking System
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bookhotel_db');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4 for full Unicode support
mysqli_set_charset($conn, "utf8mb4");

/**
 * Function to create database and tables if they don't exist
 */
function initializeDatabase() {
    // Create database connection without selecting database
    $init_conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    
    if (!$init_conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    if (!mysqli_query($init_conn, $sql)) {
        die("Error creating database: " . mysqli_error($init_conn));
    }
    
    mysqli_close($init_conn);
    
    // Now connect to the database
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Create users table
    $create_users_table = "CREATE TABLE IF NOT EXISTS users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        mobile VARCHAR(20) NOT NULL,
        password VARCHAR(255) NOT NULL,
        profile_image VARCHAR(255) DEFAULT NULL,
        status ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        email_verified TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        last_login TIMESTAMP NULL DEFAULT NULL,
        INDEX idx_email (email),
        INDEX idx_mobile (mobile),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if (!mysqli_query($conn, $create_users_table)) {
        die("Error creating users table: " . mysqli_error($conn));
    }
    
    // Create password_resets table
    $create_resets_table = "CREATE TABLE IF NOT EXISTS password_resets (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expires_at TIMESTAMP NOT NULL,
        used TINYINT(1) DEFAULT 0,
        INDEX idx_email (email),
        INDEX idx_token (token)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if (!mysqli_query($conn, $create_resets_table)) {
        die("Error creating password_resets table: " . mysqli_error($conn));
    }
    
    // Create login_attempts table for security
    $create_attempts_table = "CREATE TABLE IF NOT EXISTS login_attempts (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        ip_address VARCHAR(45) NOT NULL,
        attempted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        success TINYINT(1) DEFAULT 0,
        INDEX idx_email (email),
        INDEX idx_ip (ip_address)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if (!mysqli_query($conn, $create_attempts_table)) {
        die("Error creating login_attempts table: " . mysqli_error($conn));
    }
    
    mysqli_close($conn);
    
    return true;
}

/**
 * Function to sanitize user input
 */
function sanitize($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

/**
 * Function to validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Function to validate mobile number (Indian format)
 */
function validateMobile($mobile) {
    // Remove any non-digit characters
    $mobile = preg_replace('/[^0-9]/', '', $mobile);
    
    // Check if it's a 10-digit number
    if (preg_match('/^[6-9][0-9]{9}$/', $mobile)) {
        return true;
    }
    return false;
}

/**
 * Function to check if email exists
 */
function emailExists($email) {
    global $conn;
    $email = sanitize($email);
    $sql = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

/**
 * Function to check if mobile exists
 */
function mobileExists($mobile) {
    global $conn;
    $mobile = sanitize($mobile);
    $sql = "SELECT id FROM users WHERE mobile = '$mobile' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

/**
 * Function to get user IP address
 */
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * Function to check login attempts (prevent brute force)
 */
function checkLoginAttempts($email, $max_attempts = 5, $lockout_time = 900) {
    global $conn;
    $email = sanitize($email);
    $ip = getUserIP();
    
    // Check attempts in last lockout_time seconds (default 15 minutes)
    $time_threshold = date('Y-m-d H:i:s', time() - $lockout_time);
    
    $sql = "SELECT COUNT(*) as attempts FROM login_attempts 
            WHERE (email = '$email' OR ip_address = '$ip') 
            AND attempted_at > '$time_threshold' 
            AND success = 0";
    
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    return $row['attempts'] < $max_attempts;
}

/**
 * Function to log login attempt
 */
function logLoginAttempt($email, $success = false) {
    global $conn;
    $email = sanitize($email);
    $ip = getUserIP();
    $success_int = $success ? 1 : 0;
    
    $sql = "INSERT INTO login_attempts (email, ip_address, success) 
            VALUES ('$email', '$ip', $success_int)";
    
    mysqli_query($conn, $sql);
}

/**
 * Function to clean old login attempts (run periodically)
 */
function cleanOldLoginAttempts($days = 30) {
    global $conn;
    $threshold = date('Y-m-d H:i:s', time() - ($days * 24 * 60 * 60));
    $sql = "DELETE FROM login_attempts WHERE attempted_at < '$threshold'";
    mysqli_query($conn, $sql);
}

// Initialize database on first run (uncomment if needed)
// initializeDatabase();

?>
