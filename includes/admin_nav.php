<!-- FontAwesome untuk ikon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<style>
  .nav-container {
    position: sticky;
    top: 0;
    z-index: 1000;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
  }

  .nav-btn {
    position: relative;
    border: none;
    background: white;
    color: #e83e8c;
    padding: 12px 20px;
    border-radius: 30px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(232, 62, 140, 0.1);
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    overflow: hidden;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    margin: 5px;
  }

  .nav-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(135deg, #ffdeeb 0%, #ffb8d9 100%);
    z-index: -1;
    transition: width 0.4s ease;
  }

  .nav-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(232, 62, 140, 0.2);
    color: #c2185b;
  }

  .nav-btn:hover::before {
    width: 100%;
  }

  .nav-btn i {
    transition: transform 0.3s ease;
  }

  .nav-btn:hover i {
    transform: scale(1.2);
  }
</style>

<!-- Navbar Tombol -->
<div class="nav-container">
  <a href="dashboard.php" class="nav-btn">
    <i class="fas fa-home"></i> Dashboard
  </a>

  <a href="transactions.php" class="nav-btn">
    <i class="fas fa-shopping-cart"></i> Transactions
  </a>

  <a href="broadcast_email.php" class="nav-btn">
    <i class="fas fa-envelope"></i> Broadcast
  </a>

  <!-- Tombol Logout arahkan ke register.php -->
  <a href="../logout.php?redirect=register.php" class="nav-btn">
    <i class="fas fa-sign-out-alt"></i> Logout
  </a>
</div>
