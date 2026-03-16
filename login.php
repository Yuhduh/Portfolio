
<?php
session_start();
require_once 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (!empty($username) && !empty($password)) {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            if ($password === $admin['password']) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                header("Location: admin.php");
                exit;
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $error = 'Please fill in all fields';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-box {
            background-color: var(--card-bg);
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            padding: 3rem;
            max-width: 450px;
            width: 100%;
        }
        .login-box h2 {
            color: var(--text-white);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        .login-box p {
            color: var(--text-gray);
            margin-bottom: 2rem;
        }
        .back-link {
            display: inline-block;
            color: var(--primary-orange);
            text-decoration: none;
            margin-bottom: 2rem;
            transition: color 0.3s ease;
        }
        .back-link:hover {
            color: var(--secondary-orange);
        }
        .login-box form {
            width: 100%;
        }
        .login-box .form-group {
            margin-bottom: 1.2rem;
        }
        .login-btn-custom {
            width: 100% !important;
        }
        .login-box .btn-submit {
            width: 100% !important;
            box-sizing: border-box;
            display: inline-flex;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <a href="index.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Portfolio</a>
            <h2>Admin Login</h2>
            <p>Enter your credentials to access the admin panel</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                </div>
                
                <button type="submit" class="btn-submit login-btn-custom">
                    Login
                    <i class="fas fa-sign-in-alt"></i>
                </button>
            </form>
            
            <p style="margin-top: 1.5rem; font-size: 0.9rem;">
                Default credentials: <strong>admin</strong> / <strong>password</strong>
            </p>
        </div>
    </div>
</body>
</html>
