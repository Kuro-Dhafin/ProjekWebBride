
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
  <style>
    :root {
      --gold: #D4AF37;
      --dark-gold: #B8860B;
      --emerald: #2E8B57;
      --forest: #1E453E;
      --ivory: #FFFFF0;
      --light-bg: #F5F5F0;
    }
    
    body {
      margin: 0;
      font-family: 'Gabarito', sans-serif;
      background: linear-gradient(rgba(245, 245, 240, 0.9), rgba(245, 245, 240, 0.9)), 
                  url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover no-repeat fixed;
      color: var(--forest);
      min-height: 100vh;
    }
    
    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
      padding: 20px;
    }
    
    .logo {
      margin-bottom: 30px;
    }
    
    .logo h1 {
      font-family: 'Hatton', serif;
      font-size: 70px;
      margin: 0;
      background: linear-gradient(to right, var(--emerald), var(--forest));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 2px;
    }
    
    .logo p {
      margin: 10px 0 0;
      font-size: 18px;
      letter-spacing: 1px;
      color: var(--forest);
      font-weight: 400;
    }
    
    .illustration {
      margin: 40px 0;
      transition: all 0.5s ease;
    }
    
    .illustration:hover {
      transform: scale(1.05);
    }
    
    .illustration img {
      width: 250px;
      filter: drop-shadow(0 5px 15px rgba(46, 139, 87, 0.3));
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
    
    .nav-links span {
      color: var(--emerald);
      position: relative;
      padding-bottom: 5px;
    }
    
    .nav-links span::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--gold);
    }
    
    .nav-links a {
      color: var(--forest);
      text-decoration: none;
      transition: all 0.3s ease;
      padding: 8px 15px;
      border-radius: 30px;
    }
    
    .nav-links a:hover {
      background-color: rgba(46, 139, 87, 0.1);
      color: var(--emerald);
      transform: translateY(-3px);
    }
    
    .desc {
      margin-top: 30px;
      max-width: 600px;
      font-size: 18px;
      line-height: 1.6;
      color: var(--forest);
      font-weight: 400;
    }
    
    .auth-form {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 10px 30px rgba(46, 139, 87, 0.2);
      width: 100%;
      max-width: 400px;
      margin-top: 30px;
      border: 1px solid var(--gold);
    }
    
    .auth-form h2 {
      font-family: 'Hatton', serif;
      font-size: 30px;
      color: var(--forest);
      margin-bottom: 20px;
    }
    
    .auth-form input {
      width: 100%;
      padding: 15px;
      margin: 15px 0;
      border: 1px solid var(--gold);
      border-radius: 5px;
      font-size: 16px;
      background-color: var(--light-bg);
      transition: all 0.3s ease;
    }
    
    .auth-form input:focus {
      outline: none;
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
    }
    
    .auth-form button {
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      background: linear-gradient(to right, var(--emerald), var(--forest));
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .auth-form button:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
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
      <input type="email" placeholder="Email Address" required>
      <input type="password" placeholder="Password" required>
      <button type="submit">SIGN IN</button>
    </div>

    <div class="desc">
      <p>Begin your journey to the perfect wedding day. Sign in to access your personalized wedding planning dashboard, where every detail comes together beautifully.</p>
    </div>
  </div>
</body>
</html>
