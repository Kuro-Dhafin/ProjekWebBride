<?php
session_start();
require_once 'includes/db.php';

$db = new Database();
$conn = $db->getConnection();

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;

    switch ($user['role']) {
      case 'admin':
        header("Location: admin/dashboard.php");
        break;
      case 'vendor':
        header("Location: Vendor/vendors.php");
        break;
      case 'client':
      case 'member':
        header("Location: Vendor/vendors.php");
        break;
      default:
        $error = "Role tidak dikenal.";
        break;
    }
    exit;
  } else {
    $error = "Login gagal. Email atau password salah.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sunne - Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary-pink: #FF69B4;
      --dark-pink: #DB7093;
      --light-pink: #FFB6C1;
      --soft-pink: #FFF0F5;
      --ivory: #FFFFF0;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(rgba(255, 240, 245, 0.9), rgba(255, 240, 245, 0.9)), 
                  url('https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat fixed;
      color: var(--dark-pink);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    .login-container {
      width: 100%;
      max-width: 450px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(219, 112, 147, 0.2);
      padding: 40px;
      text-align: center;
      border: 1px solid var(--light-pink);
      transform-style: preserve-3d;
      perspective: 1000px;
    }
    
    .logo {
      margin-bottom: 30px;
      transition: var(--transition);
    }
    
    .logo:hover {
      transform: scale(1.02);
    }
    
    .logo h1 {
      font-family: 'Playfair Display', serif;
      font-size: 48px;
      margin: 0;
      background: linear-gradient(to right, var(--primary-pink), var(--dark-pink));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1px;
    }
    
    .logo p {
      margin: 10px 0 0;
      font-size: 16px;
      letter-spacing: 1px;
      color: var(--dark-pink);
    }
    
    .illustration {
      margin: 25px 0;
      transition: var(--transition);
      animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-10px) scale(1.02); }
    }
    
    .illustration img {
      width: 180px;
      filter: drop-shadow(0 5px 15px rgba(219, 112, 147, 0.3));
    }
    
    .form-group {
      position: relative;
      margin-bottom: 25px;
    }
    
    .form-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--dark-pink);
      opacity: 0.6;
    }
    
    .form-control {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 1px solid var(--light-pink);
      border-radius: 8px;
      font-size: 16px;
      background-color: var(--soft-pink);
      transition: var(--transition);
    }
    
    .form-control:focus {
      outline: none;
      border-color: var(--primary-pink);
      box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.1);
      transform: translateY(-2px);
    }
    
    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--dark-pink);
      opacity: 0.6;
      transition: var(--transition);
    }
    
    .toggle-password:hover {
      opacity: 1;
    }
    
    .btn-login {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      background: linear-gradient(to right, var(--primary-pink), var(--dark-pink));
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .btn-login::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: var(--transition);
    }
    
    .btn-login:hover::after {
      left: 100%;
    }
    
    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(219, 112, 147, 0.4);
    }
    
    .forgot-link {
      display: block;
      text-align: right;
      margin-top: 10px;
      color: var(--dark-pink);
      text-decoration: none;
      font-size: 14px;
      transition: var(--transition);
    }
    
    .forgot-link:hover {
      color: var(--primary-pink);
      text-decoration: underline;
    }
    
    .register-link {
      display: block;
      margin-top: 25px;
      color: var(--dark-pink);
      text-decoration: none;
      font-size: 15px;
      transition: var(--transition);
    }
    
    .register-link a {
      color: var(--primary-pink);
      font-weight: 600;
      text-decoration: none;
    }
    
    .register-link a:hover {
      text-decoration: underline;
    }
    
    .error-message {
      color: #e74c3c;
      background-color: #fadbd8;
      padding: 12px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
      animation: shake 0.5s;
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }
    
    @media (max-width: 576px) {
      .login-container {
        padding: 30px 20px;
        margin: 0 15px;
      }
      
      .logo h1 {
        font-size: 36px;
      }
      
      .illustration img {
        width: 140px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="logo">
      <h1>Sunne</h1>
      <p>Your Dream Wedding, Perfectly Organized</p>
    </div>
    
    <div class="illustration">
      <img src="https://cdn-icons-png.flaticon.com/512/2583/2583344.png" alt="Wedding Rings">
    </div>
    
    <?php if (!empty($error)): ?>
      <div class="error-message">
        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
      </div>
    <?php endif; ?>
    
    <form method="POST" action="">
      <div class="form-group">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
      </div>
      
      <div class="form-group password-container">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
        <span class="toggle-password" onclick="togglePassword()">
          <i class="fas fa-eye"></i>
        </span>
      </div>
      
      <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
      
      <button type="submit" class="btn-login">
        <i class="fas fa-sign-in-alt"></i> LOGIN
      </button>
    </form>
    
    <div class="register-link">
      Don't have an account? <a href="register.php">Sign up</a>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.querySelector('.toggle-password i');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
    
    // Add floating animation to illustration on hover
    const illustration = document.querySelector('.illustration');
    illustration.addEventListener('mouseenter', () => {
      illustration.style.animation = 'none';
      setTimeout(() => {
        illustration.style.animation = 'float 3s ease-in-out infinite';
      }, 10);
    });
  </script>
</body>
</html>