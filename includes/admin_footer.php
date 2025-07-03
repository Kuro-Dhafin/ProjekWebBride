<footer style="
  padding: 1.5rem 2rem;
  text-align: center;
  background: linear-gradient(135deg, #ff6b9d 0%, #e83e8c 100%);
  color: white;
  position: relative;
  overflow: hidden;
  box-shadow: 0 -4px 20px rgba(232, 62, 140, 0.3);
  font-family: 'Gabarito', sans-serif;
  font-weight: 600;
">
  <!-- Animated border top -->
  <div style="
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, 
      rgba(255,255,255,0) 0%, 
      rgba(255,255,255,0.8) 50%, 
      rgba(255,255,255,0) 100%);
    animation: shimmer 3s infinite;
  "></div>

  <!-- Main footer content -->
  <div style="
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
  ">
    <!-- Floating heart icon -->
    <div style="
      font-size: 1.5rem;
      animation: float 3s ease-in-out infinite;
      margin-bottom: 0.5rem;
      color: #fff9fb;
      text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    ">
      <i class="fas fa-heart"></i>
    </div>

    <!-- Copyright text with glow effect -->
    <div style="
      font-size: 1.1rem;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    ">
      &copy; <?= date('Y') ?> Sunne Wedding Management
    </div>

    <!-- Social media links -->
    <div style="
      display: flex;
      gap: 1.5rem;
      margin-top: 0.5rem;
    ">
      <a href="#" style="
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        transform: scale(1);
      " onmouseover="this.style.transform='scale(1.2)'" 
      onmouseout="this.style.transform='scale(1)'">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="#" style="
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        transform: scale(1);
      " onmouseover="this.style.transform='scale(1.2)'" 
      onmouseout="this.style.transform='scale(1)'">
        <i class="fab fa-facebook"></i>
      </a>
      <a href="#" style="
        color: white;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        transform: scale(1);
      " onmouseover="this.style.transform='scale(1.2)'" 
      onmouseout="this.style.transform='scale(1)'">
        <i class="fab fa-whatsapp"></i>
      </a>
    </div>
  </div>

  <!-- CSS Animations -->
  <style>
    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
  </style>
</footer>
</body>
</html>