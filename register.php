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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Gabarito:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.cdnfonts.com/css/hatton" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #D4AF37;
      --dark-gold: #B8860B;
      --green: #2E8B57;
      --dark-green: #1E453E;
      --ivory: #FFFFF0;
      --light-bg: #F5F5F0;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
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
      animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
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
      transform-style: preserve-3d;
      perspective: 1000px;
    }
    .logo { margin-bottom: 30px; transition: var(--transition); }
    .logo:hover { transform: scale(1.02); }
    .logo h1 {
      font-family: 'Hatton', serif;
      font-size: 70px;
      margin: 0;
      background: linear-gradient(to right, var(--green), var(--dark-green));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1px;
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
    .user-type {
      display: flex; justify-content: center; gap: 20px; margin-bottom: 20px;
    }
    .user-type-option {
      flex: 1; padding: 15px; border: 2px solid var(--gold); border-radius: 5px;
      cursor: pointer; transition: var(--transition);
      background-color: var(--light-bg); position: relative; overflow: hidden;
    }
    .user-type-option::before {
      content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
      background: linear-gradient(to right, transparent, rgba(212, 175, 55, 0.1), transparent);
      transition: var(--transition);
    }
    .user-type-option:hover::before { left: 100%; }
    .user-type-option.selected {
      background: linear-gradient(to right, var(--green), var(--dark-green));
      color: white; border-color: var(--green);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.3);
    }
    .user-type-option input { display: none; }
    .form-box input, .form-box select {
      display: block; width: 100%; padding: 15px; margin: 15px 0;
      background-color: var(--light-bg); color: var(--dark-green);
      border: 1px solid var(--gold); border-radius: 5px; font-size: 16px;
      transition: var(--transition);
    }
    .form-box input:focus, .form-box select:focus {
      outline: none; border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(46, 139, 87, 0.1);
      transform: scale(1.02);
    }
    .form-box input::placeholder { color: rgba(30, 69, 62, 0.6); font-size: 16px; }
    .form-box .submit-btn {
      width: 100%; padding: 15px; margin-top: 20px;
      background: linear-gradient(to right, var(--green), var(--dark-green));
      color: white; border: none; border-radius: 5px; font-size: 18px;
      font-weight: 600; cursor: pointer; transition: var(--transition);
      text-transform: uppercase; letter-spacing: 1px; position: relative;
      overflow: hidden;
    }
    .submit-btn::after {
      content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: var(--transition);
    }
    .submit-btn:hover::after { left: 100%; }
    .form-box .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(46, 139, 87, 0.4);
    }
    .login-link {
      display: block; margin-top: 20px; color: var(--green);
      text-decoration: none; font-size: 14px; font-weight: 500;
      transition: var(--transition); position: relative;
    }
    .login-link::after {
      content: ''; position: absolute; bottom: -2px; left: 0;
      width: 0; height: 1px; background: var(--green);
      transition: var(--transition);
    }
    .login-link:hover::after { width: 100%; }
    .nav-links { display: flex; justify-content: center; align-items: center;
      gap: 30px; font-weight: 600; font-size: 22px; margin-bottom: 30px;
      position: relative;
    }
    .nav-links a { color: var(--dark-green); text-decoration: none;
      transition: var(--transition); padding: 8px 15px; border-radius: 30px;
      position: relative;
    }
    .nav-links a.active { color: var(--green); }
    .nav-links a.active::after {
      content: ''; position: absolute; bottom: 0; left: 0;
      width: 100%; height: 2px; background: var(--gold);
      animation: underlineGrow 0.3s ease-out;
    }
    @keyframes underlineGrow {
      from { transform: scaleX(0); } to { transform: scaleX(1); }
    }
    .nav-links a:hover { background-color: rgba(46, 139, 87, 0.1); transform: translateY(-3px); }
    .vendor-fields { display: none; animation: slideDown 0.5s ease-out; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    .password-strength { width: 100%; height: 5px; background: #eee; border-radius: 5px; margin-top: 5px; overflow: hidden; }
    .strength-meter { height: 100%; width: 0; transition: var(--transition); }
    .password-container { position: relative; }
    .toggle-password { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: var(--dark-green); }
    .form-step { display: none; }
    .form-step.active { display: block; animation: fadeIn 0.5s ease-in-out; }
    .progress-bar { width: 100%; height: 5px; background: var(--light-bg); border-radius: 5px; margin-bottom: 20px; overflow: hidden; }
    .progress { height: 100%; width: 33%; background: linear-gradient(to right, var(--green), var(--dark-green)); transition: var(--transition); }
    .step-navigation { display: flex; justify-content: space-between; margin-top: 20px; }
    .step-btn { padding: 12px 0; background: var(--light-bg); border: 1px solid var(--gold); border-radius: 5px; cursor: pointer; transition: var(--transition); width: 48%; font-size: 16px; font-weight: 600; }
    .next-btn { background: linear-gradient(to right, var(--green), var(--dark-green)); color: white; margin-left: auto; }
    .step-btn:hover { background: rgba(46, 139, 87, 0.1); }
    .next-btn:hover { background: linear-gradient(to right, var(--dark-green), var(--green)); }
    .step-btn:disabled { opacity: 0.5; cursor: not-allowed; }
    @keyframes shake { 0%,100%{transform:translateX(0);}20%,60%{transform:translateX(-5px);}40%,80%{transform:translateX(5px);} }
    .shake { animation: shake 0.5s; }
  </style>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <div class="logo">
        <h1>Sunne</h1><p>Your Dream Wedding, Perfectly Organized</p>
      </div>
      <div class="nav-links">
        <a href="login.php" class="signin-btn">SIGN IN</a>
        <a href="#" class="active">SIGN UP</a>
      </div>
      <h2>REGISTER</h2>
      <div class="progress-bar"><div class="progress" id="progress"></div></div>
      <form action="register.php" method="POST" id="registration-form">
        <div class="form-step active" id="step1">
          <div class="user-type">
            <label class="user-type-option selected" onclick="selectUserType(this,'client')"><input type="radio" name="user_type" value="client" checked><i class="fas fa-user" style="font-size:24px;margin-bottom:10px;"></i><h3>Client</h3><p>Looking for wedding services</p></label>
            <label class="user-type-option" onclick="selectUserType(this,'vendor')"><input type="radio" name="user_type" value="vendor"><i class="fas fa-briefcase" style="font-size:24px;margin-bottom:10px;"></i><h3>Vendor</h3><p>Providing wedding services</p></label>
          </div>
          <div class="step-navigation"><button type="button" class="step-btn next-btn" onclick="nextStep()">Next</button></div>
        </div>
        <div class="form-step" id="step2">
          <input type="text" name="username" placeholder="USERNAME" required>
          <input type="email" name="email" placeholder="EMAIL" required>
          <input type="text" name="notelp" placeholder="PHONE NUMBER" required>
          <input type="date" name="birth" placeholder="DATE OF BIRTH" required>
          <div class="step-navigation"><button type="button" class="step-btn" onclick="prevStep()">Back</button><button type="button" class="step-btn next-btn" onclick="nextStep()">Next</button></div>
        </div>
        <div class="form-step" id="step3">
          <input type="text" name="address" placeholder="ADDRESS" required>
          <div class="password-container"><input type="password" name="password" id="password" placeholder="PASSWORD" required><span class="toggle-password" onclick="togglePassword('password')"><i class="fas fa-eye"></i></span><div class="password-strength"><div class="strength-meter" id="strength-meter"></div></div></div>
          <div class="password-container"><input type="password" name="confirm_password" id="confirm_password" placeholder="CONFIRM PASSWORD" required><span class="toggle-password" onclick="togglePassword('confirm_password')"><i class="fas fa-eye"></i></span></div>
          <div id="vendor-fields" class="vendor-fields"><input type="text" name="company_name" placeholder="COMPANY NAME"><select name="service_type"><option value="" disabled selected>SELECT SERVICE TYPE</option><option value="photography">Photography</option><option value="venue">Venue</option><option value="catering">Catering</option><option value="florist">Florist</option><option value="music">Music</option><option value="other">Other</option></select></div>
          <div class="step-navigation"><button type="button" class="step-btn" onclick="prevStep()">Back</button><button type="submit" class="submit-btn">SIGN UP</button></div>
        </div>
      </form>
      <a href="login.php" class="login-link">Already have an account? Login here</a>
    </div>
  </div>
  <script>
    let currentStep=1,totalSteps=3,userType='client';
    function selectUserType(el,type){document.querySelectorAll('.user-type-option').forEach(o=>o.classList.remove('selected'));el.classList.add('selected');userType=type;updateProgressBar();}
    function nextStep(){if(!validateStep(currentStep))return;document.getElementById('step'+currentStep).classList.remove('active');currentStep++;document.getElementById('step'+currentStep).classList.add('active');updateProgressBar();if(currentStep===totalSteps){const vf=document.getElementById('vendor-fields');const svc=vf.querySelector('select[name="service_type"]');const comp=vf.querySelector('input[name="company_name"]');if(userType==='vendor'){vf.style.display='block';svc.required=true;comp.required=true;}else{vf.style.display='none';svc.required=false;comp.required=false;}}}
    function prevStep(){document.getElementById('step'+currentStep).classList.remove('active');currentStep--;document.getElementById('step'+currentStep).classList.add('active');updateProgressBar();}
    function updateProgressBar(){document.getElementById('progress').style.width=(currentStep/totalSteps*100)+'%';}
    function validateStep(step){let valid=true;const el=document.getElementById('step'+step);el.querySelectorAll('input[required],select[required]').forEach(i=>{if(!i.value.trim()){valid=false;i.style.borderColor='red';i.classList.add('shake');setTimeout(()=>i.classList.remove('shake'),500);}else i.style.borderColor='';});if(step===2){const e=el.querySelector('input[type="email"]');if(e&&!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e.value)){e.style.borderColor='red';valid=false;setTimeout(()=>e.style.borderColor='',500);}}return valid;}
    document.getElementById('password').addEventListener('input',function(e){const pwd=e.target.value;let s=0;if(pwd.length>=8)s++;if(pwd.length>=12)s++;if(/[A-Z]/.test(pwd))s++;if(/[0-9]/.test(pwd))s++;if(/[^A-Za-z0-9]/.test(pwd))s++;const m=document.getElementById('strength-meter');m.style.width=(s/5*100)+'%';m.style.backgroundColor=s<=2?'red':s<=4?'orange':'green';});
    function togglePassword(id){const f=document.getElementById(id),i=f.nextElementSibling.querySelector('i');if(f.type==='password'){f.type='text';i.classList.replace('fa-eye','fa-eye-slash');}else{f.type='password';i.classList.replace('fa-eye-slash','fa-eye');}}
    document.getElementById('registration-form').addEventListener('submit',e=>{if(!validateStep(currentStep))e.preventDefault();});
  </script>
</body>
</html>
