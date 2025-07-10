<?php
require_once 'includes/db.php';
require_once 'includes/class.register.php';

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $reg = new Register($conn);
  $data = $_POST;

  // Password confirmation
  if ($data['password'] !== $data['confirm_password']) {
    die("Password confirmation does not match.");
  }

  // Email already used?
  if ($reg->isEmailTaken($data['email'])) {
    die("Email already registered.");
  }

  // Register
  if ($reg->registerUser($data)) {
    header("Location: login.php?success=1");
    exit;
  } else {
    die("Registration failed.");
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sunne - Sign Up</title>
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
    * { box-sizing: border-box; margin: 0; padding: 0; }
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
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .register-container {
      width: 100%;
      max-width: 500px;
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
    .logo:hover { transform: scale(1.02); }
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
      color: var(--dark-pink);
      text-decoration: none;
      transition: var(--transition);
      padding: 8px 15px;
      border-radius: 30px;
      position: relative;
    }
    .nav-links a.active { color: var(--primary-pink); }
    .nav-links a.active::after {
      content: '';
      position: absolute;
      bottom: 0; left: 0;
      width: 100%; height: 2px;
      background: var(--primary-pink);
      animation: underlineGrow 0.3s ease-out;
    }
    @keyframes underlineGrow {
      from { transform: scaleX(0); } to { transform: scaleX(1); }
    }
    .nav-links a:hover {
      background-color: rgba(255, 105, 180, 0.08);
      transform: translateY(-3px);
    }
    .register-title {
      margin-bottom: 30px;
      font-family: 'Playfair Display', serif;
      font-size: 30px;
      color: var(--dark-pink);
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .progress-bar {
      width: 100%;
      height: 5px;
      background: var(--soft-pink);
      border-radius: 5px;
      margin-bottom: 20px;
      overflow: hidden;
    }
    .progress {
      height: 100%;
      width: 33%;
      background: linear-gradient(to right, var(--primary-pink), var(--dark-pink));
      transition: var(--transition);
    }
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn 0.5s ease-in-out; }
    .user-type {
      display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;
    }
    .user-type-option {
      flex: 1; padding: 15px; border: 2px solid var(--primary-pink); border-radius: 5px;
      cursor: pointer; transition: var(--transition);
      background-color: var(--soft-pink); position: relative; overflow: hidden;
      color: var(--dark-pink);
      font-weight: 500;
    }
    .user-type-option.selected {
      background: linear-gradient(to right, var(--primary-pink), var(--dark-pink));
      color: white; border-color: var(--primary-pink);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(219, 112, 147, 0.2);
    }
    .user-type-option input { display: none; }
    .user-type-option h3 { margin: 10px 0 0; font-size: 18px; }
    .user-type-option p { margin: 5px 0 0; font-size: 13px; }
    .form-group {
      position: relative;
      margin-bottom: 22px;
      text-align: left;
    }
    .form-group i {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--dark-pink);
      opacity: 0.6;
    }
    .form-control, .form-select {
      width: 100%;
      padding: 15px 15px 15px 45px;
      border: 1px solid var(--light-pink);
      border-radius: 8px;
      font-size: 16px;
      background-color: var(--soft-pink);
      transition: var(--transition);
      color: var(--dark-pink);
      margin-bottom: 0;
    }
    .form-control:focus, .form-select:focus {
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
    .toggle-password:hover { opacity: 1; }
    .password-strength {
      width: 100%; height: 5px; background: #eee; border-radius: 5px; margin-top: 5px; overflow: hidden;
    }
    .strength-meter { height: 100%; width: 0; transition: var(--transition); }
    .step-navigation {
      display: flex; justify-content: space-between; margin-top: 20px;
    }
    .step-btn {
      padding: 12px 0;
      background: var(--soft-pink);
      border: 1px solid var(--primary-pink);
      border-radius: 5px;
      cursor: pointer;
      transition: var(--transition);
      width: 48%;
      font-size: 16px;
      font-weight: 600;
      color: var(--dark-pink);
    }
    .next-btn {
      background: linear-gradient(to right, var(--primary-pink), var(--dark-pink));
      color: white;
      margin-left: auto;
    }
    .step-btn:hover {
      background: rgba(255, 105, 180, 0.08);
    }
    .next-btn:hover {
      background: linear-gradient(to right, var(--dark-pink), var(--primary-pink));
    }
    .step-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    .btn-register {
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
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .btn-register::after {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: var(--transition);
    }
    .btn-register:hover::after { left: 100%; }
    .btn-register:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(219, 112, 147, 0.4);
    }
    .login-link {
      display: block;
      margin-top: 25px;
      color: var(--dark-pink);
      text-decoration: none;
      font-size: 15px;
      transition: var(--transition);
    }
    .login-link a {
      color: var(--primary-pink);
      font-weight: 600;
      text-decoration: none;
    }
    .login-link a:hover { text-decoration: underline; }
    .vendor-fields { display: none; animation: slideDown 0.5s ease-out; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shake { 0%,100%{transform:translateX(0);}20%,60%{transform:translateX(-5px);}40%,80%{transform:translateX(5px);} }
    .shake { animation: shake 0.5s; }
    @media (max-width: 576px) {
      .register-container { padding: 30px 10px; margin: 0 10px; }
      .logo h1 { font-size: 36px; }
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="logo">
      <h1>Sunne</h1>
      <p>Your Dream Wedding, Perfectly Organized</p>
    </div>
    <div class="nav-links">
      <a href="login.php" class="signin-btn">SIGN IN</a>
      <a href="#" class="active">SIGN UP</a>
    </div>
    <div class="register-title">REGISTER</div>
    <div class="progress-bar"><div class="progress" id="progress"></div></div>
    <form action="register.php" method="POST" id="registration-form" autocomplete="off">
      <div class="form-step active" id="step1">
        <div class="user-type">
          <label class="user-type-option selected" onclick="selectUserType(this,'client')">
            <input type="radio" name="user_type" value="client" checked>
            <i class="fas fa-user" style="font-size:24px;margin-bottom:10px;"></i>
            <h3>Client</h3>
            <p>Looking for wedding services</p>
          </label>
          <label class="user-type-option" onclick="selectUserType(this,'vendor')">
            <input type="radio" name="user_type" value="vendor">
            <i class="fas fa-briefcase" style="font-size:24px;margin-bottom:10px;"></i>
            <h3>Vendor</h3>
            <p>Providing wedding services</p>
          </label>
        </div>
        <div class="step-navigation">
          <button type="button" class="step-btn next-btn" onclick="nextStep()">Next</button>
        </div>
      </div>
      <div class="form-step" id="step2">
        <div class="form-group">
          <i class="fas fa-user"></i>
          <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="form-group">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
          <i class="fas fa-phone"></i>
          <input type="text" name="notelp" class="form-control" placeholder="Phone Number" required>
        </div>
        <div class="form-group">
          <i class="fas fa-calendar"></i>
          <input type="date" name="birth" class="form-control" placeholder="Date of Birth" required>
        </div>
        <div class="step-navigation">
          <button type="button" class="step-btn" onclick="prevStep()">Back</button>
          <button type="button" class="step-btn next-btn" onclick="nextStep()">Next</button>
        </div>
      </div>
      <div class="form-step" id="step3">
        <div class="form-group">
          <i class="fas fa-map-marker-alt"></i>
          <input type="text" name="address" class="form-control" placeholder="Address" required>
        </div>
        <div class="form-group password-container">
          <i class="fas fa-lock"></i>
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
          <span class="toggle-password" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span>
          <div class="password-strength"><div class="strength-meter" id="strength-meter"></div></div>
        </div>
        <div class="form-group password-container">
          <i class="fas fa-lock"></i>
          <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
          <span class="toggle-password" onclick="togglePassword('confirm_password')"><i class="fas fa-eye"></i></span>
        </div>
        <div id="vendor-fields" class="vendor-fields">
          <div class="form-group">
            <i class="fas fa-building"></i>
            <input type="text" name="company_name" class="form-control" placeholder="Company Name">
          </div>
          <div class="form-group">
            <i class="fas fa-briefcase"></i>
            <select name="service_type" class="form-select">
              <option value="" disabled selected>Select Service Type</option>
              <option value="photography">Photography</option>
              <option value="venue">Venue</option>
              <option value="catering">Catering</option>
              <option value="florist">Florist</option>
              <option value="music">Music</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>
        <div class="step-navigation">
          <button type="button" class="step-btn" onclick="prevStep()">Back</button>
          <button type="submit" class="btn-register">SIGN UP</button>
        </div>
      </div>
    </form>
    <div class="login-link">
      Already have an account? <a href="login.php">Login here</a>
    </div>
  </div>
  <script>
    let currentStep=1,totalSteps=3,userType='client';
    function selectUserType(el,type){
      document.querySelectorAll('.user-type-option').forEach(o=>o.classList.remove('selected'));
      el.classList.add('selected');
      userType=type;updateProgressBar();
    }
    function nextStep(){
      if(!validateStep(currentStep))return;
      document.getElementById('step'+currentStep).classList.remove('active');
      currentStep++;
      document.getElementById('step'+currentStep).classList.add('active');
      updateProgressBar();
      if(currentStep===totalSteps){
        const vf=document.getElementById('vendor-fields');
        const svc=vf.querySelector('select[name="service_type"]');
        const comp=vf.querySelector('input[name="company_name"]');
        if(userType==='vendor'){
          vf.style.display='block';svc.required=true;comp.required=true;
        }else{
          vf.style.display='none';svc.required=false;comp.required=false;
        }
      }
    }
    function prevStep(){
      document.getElementById('step'+currentStep).classList.remove('active');
      currentStep--;
      document.getElementById('step'+currentStep).classList.add('active');
      updateProgressBar();
    }
    function updateProgressBar(){
      document.getElementById('progress').style.width=(currentStep/totalSteps*100)+'%';
    }
    function validateStep(step){
      let valid=true;
      const el=document.getElementById('step'+step);
      el.querySelectorAll('input[required],select[required]').forEach(i=>{
        if(!i.value.trim()){
          valid=false;i.style.borderColor='red';i.classList.add('shake');
          setTimeout(()=>i.classList.remove('shake'),500);
        }else i.style.borderColor='';
      });
      if(step===2){
        const e=el.querySelector('input[type="email"]');
        if(e&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e.value)){
          e.style.borderColor='red';valid=false;setTimeout(()=>e.style.borderColor='',500);
        }
      }
      return valid;
    }
    document.getElementById('password').addEventListener('input',function(e){
      const pwd=e.target.value;let s=0;
      if(pwd.length>=8)s++;if(pwd.length>=12)s++;
      if(/[A-Z]/.test(pwd))s++;if(/[0-9]/.test(pwd))s++;
      if(/[^A-Za-z0-9]/.test(pwd))s++;
      const m=document.getElementById('strength-meter');
      m.style.width=(s/5*100)+'%';
      m.style.backgroundColor=s<=2?'red':s<=4?'orange':'green';
    });
    function togglePassword(id){
      const f=document.getElementById(id),i=f.nextElementSibling.querySelector('i');
      if(f.type==='password'){
        f.type='text';i.classList.replace('fa-eye','fa-eye-slash');
      }else{
        f.type='password';i.classList.replace('fa-eye-slash','fa-eye');
      }
    }
    document.getElementById('registration-form').addEventListener('submit',e=>{
      if(!validateStep(currentStep))e.preventDefault();
    });
  </script>
</body>
</html>
