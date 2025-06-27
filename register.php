<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sunne - Sign Up</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/hatton" rel="stylesheet">
  <style>
    :root {
      --gold: #D4AF37;
      --dark-gold: #B8860B;
      --green: #2E8B57;
      --dark-green: #1E453E;
      --ivory: #FFFFF0;
      --light-bg: #F5F5F0;
    }
    
    body {
      margin: 0;
      font-family: 'Gabarito', sans-serif;
      background: linear-gradient(rgba(245, 245, 240, 0.9), rgba(245, 245, 240, 0.9)), 
                  url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat fixed;
      color: var(--dark-green);
      min-height: 100vh;
    }
    
    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .form-box {
      background: white;
      padding: 50px;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(46, 139, 87, 0.2);
      width: 100%;
      max-width: 500px;
      text-align: center;
      border: 1px solid var(--gold);
    }
    
    .logo {
      margin-bottom: 30px;
    }
    
    .logo h1 {
      font-family: 'Hatton', serif;
      font-size: 70px;
      margin: 0;
      color: var(--green);
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
      letter-spacing: 1px;
      background: linear-gradient(to right, var(--green), var(--dark-green));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    .logo p {
      margin: 10px 0 0;
      font-size: 18px;
      letter-spacing: 1px;
      color: var(--dark-green);
      font-weight: 400;
    }
    
    .form-box h2 {
      margin-bottom: 30px;
      font-family: 'Hatton', serif;
      font-size: 30px;
      color: var(--dark-green);
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    
    .form-box input {
      display: block;
      width: 100%;
      padding: 15px;
      margin: 15px 0;
      background-color: var(--light-bg);
      color: var(--dark-green);
      border: 1px solid var(--gold);
      border-radius: 5px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    
    .form-box input:focus {
      outline: none;
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
    }
    
    .form-box input::placeholder {
      color: rgba(30, 69, 62, 0.6);
      font-size: 16px;
    }
    
    .form-box .submit-btn {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      background: linear-gradient(to right, var(--green), var(--dark-green));
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .form-box .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
    }
    
    .login-link {
      display: block;
      margin-top: 20px;
      color: var(--green);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .login-link:hover {
      text-decoration: underline;
      color: var(--dark-green);
    }
    
    .nav-links {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 30px;
      font-weight: 600;
      font-size: 22px;
      margin-bottom: 30px;
      position: relative;
    }
    
    .nav-links a {
      color: var(--dark-green);
      text-decoration: none;
      transition: all 0.3s ease;
      padding: 8px 15px;
      border-radius: 30px;
    }
    
    .nav-links a.active {
      position: relative;
      color: var(--green);
    }
    
    .nav-links a.active::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--gold);
    }
    
    .nav-links a:hover {
      background-color: rgba(46, 139, 87, 0.1);
      transform: translateY(-3px);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <div class="logo">
        <h1>Sunne</h1>
        <p>Your Dream Wedding, Perfectly Organized</p>
      </div>
      
      <div class="nav-links">
        <a href="login.php" class="signin-btn">SIGN IN</a>
        <a href="#" class="active">SIGN UP</a>
      </div>
      
      <h2>REGISTER</h2>
      <form action="register.php" method="post">
        <input type="text" name="username" placeholder="USERNAME" required>
        <input type="email" name="email" placeholder="EMAIL" required>
        <input type="text" name="notelp" placeholder="PHONE NUMBER" required>
        <input type="date" name="birth" placeholder="DATE OF BIRTH" required>
        <input type="text" name="address" placeholder="ADDRESS" required>
        <input type="password" name="password" placeholder="PASSWORD" required>
        <input type="password" name="confirm_password" placeholder="CONFIRM PASSWORD" required>
        <button type="submit" class="submit-btn">SIGN UP</button>
      </form>
      <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>
  </div>
</body>
</html>