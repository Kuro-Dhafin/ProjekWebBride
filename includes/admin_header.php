<?php
// Start session and connect to DB if needed
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - Sunne</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Gabarito&display=swap" rel="stylesheet">
  <style>
    body { margin: 0; font-family: 'Gabarito', sans-serif; background: #f5f5f5; color: #333; }
    header, nav, footer { background-color: #2E8B57; color: white; }
    header { padding: 1rem 2rem; }
    nav { padding: 0.5rem 2rem; display: flex; gap: 1rem; }
    nav a { color: white; text-decoration: none; font-weight: 600; }
    nav a:hover { text-decoration: underline; }
    .container { padding: 2rem; }
    .card { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .card h3 { margin: 0; font-size: 1.2rem; color: #2E8B57; }
    .card p { font-size: 2rem; font-weight: bold; margin-top: 0.5rem; }
  </style>
</head>
<body>
<header>
  <h1>Sunne Admin Dashboard</h1>
</header>
<?php include 'navbar.php'; ?>
