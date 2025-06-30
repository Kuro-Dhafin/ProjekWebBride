<?php
require_once 'includes/config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user;
    header("Location: dashboard.php");
    exit;
  } else {
    echo "<script>alert('Invalid email or password');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sunne - Sign In</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/hatton" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #D4AF37;
      --dark-gold: #B8860B;
      --emerald: #2E8B57;
      --forest: #1E453E;
      --ivory: #FFFFF0;
      --light-bg: #F5F5F0;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    * {
      box-sizing: border-box;
    }
    
    body {
      margin: 0;
      font-family: 'Gabarito', sans-serif;
      background: linear-gradient(rgba(245, 245, 240, 0.9), rgba(245, 245, 240, 0.9)), 
                  url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat fixed;
      color: var(--forest);
      min-height: 100vh;
      animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    .container {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      padding: 2rem;
    }
    
    .logo {
      margin-bottom: 2rem;
      transition: var(--transition);
    }
    
    .logo:hover {
      transform: scale(1.02);
    }
    
    .logo h1 {
      font-family: 'Hatton', serif;
      font-size: 4.5rem;
      margin: 0;
      background: linear-gradient(to right, var(--emerald), var(--forest));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 2px;
      line-height: 1.1;
    }
    
    .logo p {
      margin: 0.8rem 0 0;
      font-size: 1.1rem;
      letter-spacing: 1px;
      color: var(--forest);
      font-weight: 400;
    }
    
    .illustration {
      margin: 2.5rem 0;
      transition: var(--transition);
      animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-10px) scale(1.02); }
    }
    
    .illustration img {
      width: 15rem;
      filter: drop-shadow(0 5px 15px rgba(46, 139, 87, 0.3));
    }
    
    .nav-links {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 2rem;
      font-weight: 600;
      font-size: 1.4rem;
      margin-bottom: 2rem;
      position: relative;
    }
    
    .nav-links span {
      color: var(--emerald);
      position: relative;
      padding-bottom: 0.3rem;
    }
    
    .nav-links span::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--gold);
      transform-origin: left;
      animation: underlineGrow 0.5s ease-out forwards;
    }
    
    @keyframes underlineGrow {
      from { transform: scaleX(0); }
      to { transform: scaleX(1); }
    }
    
    .nav-links a {
      color: var(--forest);
      text-decoration: none;
      transition: var(--transition);
      padding: 0.5rem 1rem;
      border-radius: 2rem;
    }
    
    .nav-links a:hover {
      background-color: rgba(46, 139, 87, 0.1);
      color: var(--emerald);
      transform: translateY(-3px);
    }
    
    .desc {
      margin-top: 2rem;
      max-width: 40rem;
      font-size: 1.1rem;
      line-height: 1.6;
      color: var(--forest);
      font-weight: 400;
      opacity: 0;
      animation: fadeInUp 0.8s ease-out 0.3s forwards;
    }
    
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .auth-form {
      background: white;
      padding: 2.5rem;
      border-radius: 0.6rem;
      box-shadow: 0 10px 30px rgba(46, 139, 87, 0.2);
      width: 100%;
      max-width: 25rem;
      margin-top: 2rem;
      border: 1px solid var(--gold);
      transform: translateY(20px);
      opacity: 0;
      animation: fadeInUp 0.8s ease-out 0.5s forwards;
    }
    
    .auth-form h2 {
      font-family: 'Hatton', serif;
      font-size: 1.9rem;
      color: var(--forest);
      margin-bottom: 1.5rem;
      letter-spacing: 1px;
    }
    
    .input-group {
      position: relative;
      margin: 1rem 0;
    }
    
    .auth-form input {
      width: 100%;
      padding: 1rem;
      margin: 0.5rem 0;
      border: 1px solid var(--gold);
      border-radius: 0.3rem;
      font-size: 1rem;
      background-color: var(--light-bg);
      transition: var(--transition);
      padding-left: 3rem;
    }
    
    .auth-form input:focus {
      outline: none;
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
      transform: translateY(-2px);
    }
    
    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--forest);
      opacity: 0.6;
    }
    
    .password-container {
      position: relative;
    }
    
    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--forest);
      opacity: 0.6;
      transition: var(--transition);
    }
    
    .toggle-password:hover {
      opacity: 1;
    }
    
    .auth-form button {
      width: 100%;
      padding: 1rem;
      margin-top: 1.5rem;
      background: linear-gradient(to right, var(--emerald), var(--forest));
      color: white;
      border: none;
      border-radius: 0.3rem;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .auth-form button::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: var(--transition);
    }
    
    .auth-form button:hover::after {
      left: 100%;
    }
    
    .auth-form button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
    }
    
    .forgot-link {
      display: block;
      text-align: right;
      margin-top: 0.5rem;
      color: var(--emerald);
      text-decoration: none;
      font-size: 0.9rem;
      transition: var(--transition);
    }
    
    .forgot-link:hover {
      text-decoration: underline;
    }
    
    @media (max-width: 768px) {
      .logo h1 {
        font-size: 3.5rem;
      }
      
      .illustration img {
        width: 12rem;
      }
      
      .auth-form {
        padding: 2rem;
      }
    }
    
    @media (max-width: 480px) {
      .container {
        padding: 1.5rem;
      }
      
      .logo h1 {
        font-size: 2.8rem;
      }
      
      .nav-links {
        font-size: 1.2rem;
        gap: 1.5rem;
      }
      
      .auth-form {
        padding: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <h1>Sunne</h1>
      <p>Your Dream Wedding, Perfectly Organized</p>
    </div>

    <div class="illustration">
      <img src="https://cdn-icons-png.flaticon.com/512/2583/2583344.png" alt="Wedding Rings Illustration">
    </div>

    <div class="nav-links">
      <span>SIGN IN</span>
      <a href="register.php">SIGN UP</a>
    </div>

    <div class="auth-form">
      <h2>WELCOME BACK</h2>
      <form method="post" id="loginForm">
        <div class="input-group">
          <i class="fas fa-envelope input-icon"></i>
          <input type="email" id="email" placeholder="Email Address" required>
        </div>
        
        <div class="input-group password-container">
          <i class="fas fa-lock input-icon"></i>
          <input type="password" id="password" placeholder="Password" required>
          <span class="toggle-password" onclick="togglePassword()">
            <i class="fas fa-eye"></i>
          </span>
        </div>
        
        
        <button type="submit">SIGN IN</button>
      </form>
    </div>

    <div class="desc">
      <p>Begin your journey to the perfect wedding day. Sign in to access your personalized wedding planning dashboard, where every detail comes together beautifully.</p>
    </div>
  </div>

  <script>
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
    
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      
      if (!email || !password) {
        showError('Please fill in all fields');
        return;
      }
      
      if (!validateEmail(email)) {
        showError('Please enter a valid email address');
        return;
      }
      
      simulateLogin();
    });
    
    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }
    
    function showError(message) {
      console.error(message);
      alert(message);
    }
    
    function simulateLogin() {
      const submitBtn = document.querySelector('#loginForm button');
      const originalText = submitBtn.textContent;
      
    
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> SIGNING IN...';
      submitBtn.disabled = true;
      
      
      setTimeout(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        
       
        alert('Login successful! Redirecting...');
   
      }, 2000);
    }
    
    
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