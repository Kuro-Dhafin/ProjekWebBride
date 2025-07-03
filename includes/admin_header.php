<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Sunne</title>

  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Gabarito&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-pink: #e83e8c;
      --soft-pink: #ff85a2;
      --light-pink: #ffdeeb;
      --dark-pink: #c2185b;
      --pink-gradient: linear-gradient(135deg, #e83e8c 0%, #ff85a2 100%);
      --pearl-white: #fff9fb;
    }
    
    body {
      margin: 0;
      font-family: 'Gabarito', sans-serif;
      background: var(--pearl-white);
      color: #333;
    }
    
    header {
      padding: 1.5rem 2rem;
      background: var(--pink-gradient);
      color: white;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(232, 62, 140, 0.3);
    }
    
    header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, 
        rgba(255,255,255,0) 0%, 
        rgba(255,255,255,0.8) 50%, 
        rgba(255,255,255,0) 100%);
      animation: shimmer 3s infinite;
    }
    
    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }
    
    header h1 {
      margin: 0;
      font-size: 2rem;
      font-weight: 800;
      text-shadow: 0 2px 4px rgba(0,0,0,0.1);
      position: relative;
      display: inline-block;
    }
    
    header h1::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 3px;
      background: white;
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.3s ease;
    }
    
    header:hover h1::after {
      transform: scaleX(1);
      transform-origin: left;
    }
    
    nav {
      padding: 0.8rem 2rem;
      display: flex;
      gap: 1.5rem;
      background: var(--dark-pink);
      box-shadow: 0 2px 10px rgba(194, 24, 91, 0.2);
    }
    
    nav a {
      color: white;
      text-decoration: none;
      font-weight: 600;
      position: relative;
      padding: 0.3rem 0;
      transition: all 0.3s ease;
    }
    
    nav a::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: white;
      transition: width 0.3s ease;
    }
    
    nav a:hover::before {
      width: 100%;
    }
    
    nav a:hover {
      transform: translateY(-2px);
    }
    
    .container {
      padding: 2rem;
    }
    
    .card {
      background: white;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(232, 62, 140, 0.1);
      border-left: 4px solid var(--primary-pink);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(232, 62, 140, 0.2);
    }
    
    .card h3 {
      margin: 0;
      font-size: 1.2rem;
      color: var(--dark-pink);
    }
    
    .card p {
      font-size: 2rem;
      font-weight: bold;
      margin-top: 0.5rem;
      color: var(--primary-pink);
    }
  </style>
</head>
<body>
<header>
  <h1><i class="fas fa-crown mr-2"></i>Sunne Admin Dashboard</h1>
</header>
<?php include 'admin_nav.php'; ?>