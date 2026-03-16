<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');

// Installation script
function installDatabase() {
    // Connect without database first
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    $conn->query($sql);
    
    // Select database
    $conn->select_db(DB_NAME);
    
    // Create admins table
    $sql = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    $conn->query($sql);
    
    // Create projects table
    $sql = "CREATE TABLE IF NOT EXISTS projects (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        image_url VARCHAR(255),
        link VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Create messages table
    $sql = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($sql);
    
    // Check if admin exists
    $result = $conn->query("SELECT COUNT(*) as count FROM admins");
    $row = $result->fetch_assoc();
    
    if ($row['count'] == 0) {
        // Insert default admin
        $conn->query("INSERT INTO admins (username, password) VALUES ('admin', 'password')");
        
        // Insert sample projects
        $conn->query("INSERT INTO projects (title, description, image_url, link) VALUES 
            ('Blog CMS', 'Content Management System for blogging with categories, tags, comments, and user roles using PHP and MySQL.', '', 'https://github.com')");
    }
    
    $conn->close();
    
    // Create installation marker
    file_put_contents('installed.txt', date('Y-m-d H:i:s'));
}

// Check if installation is needed
if (!file_exists('installed.txt')) {
    installDatabase();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .install-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .install-box {
            background-color: var(--card-bg);
            border: 2px solid var(--primary-orange);
            border-radius: 10px;
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }
        .install-box h1 {
            color: var(--primary-orange);
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }
        .install-box p {
            color: var(--text-gray);
            margin-bottom: 2rem;
            line-height: 1.8;
        }
        .success-icon {
            font-size: 4rem;
            color: #00c864;
            margin-bottom: 1rem;
        }
        .install-info {
            background-color: rgba(255, 102, 0, 0.1);
            border: 1px solid var(--primary-orange);
            border-radius: 5px;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        .install-info h3 {
            color: var(--primary-orange);
            margin-bottom: 1rem;
        }
        .install-info ul {
            color: var(--text-gray);
            list-style-position: inside;
        }
        .install-info li {
            margin-bottom: 0.5rem;
        }
        .btn-continue {
            background-color: var(--primary-orange);
            color: var(--dark-bg);
            padding: 1rem 2.5rem;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-continue:hover {
            background-color: var(--secondary-orange);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-box">
            <div class="success-icon">✓</div>
            <h1>Installation Complete!</h1>
            <p>Your portfolio database has been successfully set up and configured.</p>
            
            <div class="install-info">
                <h3>What's Been Created:</h3>
                <ul>
                    <li>Database: <strong>portfolio_db</strong></li>
                    <li>Tables: admins, projects, messages</li>
                    <li>Default admin account</li>
                    <li>3 sample projects</li>
                </ul>
            </div>
            
            <div class="install-info">
                <h3>Admin Credentials:</h3>
                <ul>
                    <li>Username: <strong>admin</strong></li>
                    <li>Password: <strong>password</strong></li>
                </ul>
            </div>
            
            <p style="margin-top: 2rem;">You can now access your portfolio website!</p>
            
            <a href="index.php" class="btn-continue">Go to Portfolio →</a>
            <br><br>
            <a href="login.php" class="btn-continue" style="background-color: transparent; border: 2px solid var(--primary-orange); color: var(--primary-orange);">Admin Login →</a>
        </div>
    </div>
</body>
</html>
