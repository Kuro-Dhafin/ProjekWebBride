-- DATABASE: wedstory_lite
CREATE DATABASE IF NOT EXISTS wedstory_lite CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wedstory_lite;

-- USERS TABLE
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','vendor','member') NOT NULL DEFAULT 'member',
  phone VARCHAR(20),
  birth DATE,
  address TEXT,
  profile_image VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- VENDORS TABLE
CREATE TABLE IF NOT EXISTS vendors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  company_name VARCHAR(100) NOT NULL,
  service_type ENUM('photography','venue','catering','florist','music','other') NOT NULL,
  location VARCHAR(150),
  description TEXT,
  profile_image VARCHAR(255),
  price INT DEFAULT 0,
  rating DECIMAL(2,1) DEFAULT 0.0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- VENDOR GALLERY
CREATE TABLE IF NOT EXISTS vendor_gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- CART ITEMS
CREATE TABLE IF NOT EXISTS cart_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  vendor_id INT NOT NULL,
  quantity INT DEFAULT 1,
  added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- TRANSACTIONS
CREATE TABLE IF NOT EXISTS transactions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total INT NOT NULL,
  status ENUM('pending','completed','cancelled') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- TRANSACTION ITEMS
CREATE TABLE IF NOT EXISTS transaction_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  transaction_id INT NOT NULL,
  vendor_id INT NOT NULL,
  price INT NOT NULL,
  quantity INT DEFAULT 1,
  FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
  FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- TESTIMONIALS
CREATE TABLE IF NOT EXISTS testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor_id INT NOT NULL,
  user_id INT NOT NULL,
  rating DECIMAL(2,1) NOT NULL CHECK (rating BETWEEN 0 AND 5),
  message TEXT,
  image_path VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- INDEXES
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_vendors_service_type ON vendors(service_type);
CREATE INDEX idx_transactions_user ON transactions(user_id);
CREATE INDEX idx_cart_user ON cart_items(user_id);

-- SAMPLE DATA
INSERT INTO users (name, email, password, role, profile_image)
VALUES
('Admin User', 'admin@example.com', '$2y$10$examplehashedpassword', 'admin', NULL),
('Vendor User', 'vendor@example.com', '$2y$10$examplehashedpassword', 'vendor', 'vendor1.jpg'),
('Client User', 'member@example.com', '$2y$10$examplehashedpassword', 'member', 'member.jpg');

INSERT INTO vendors (user_id, company_name, service_type, location, description, profile_image, price, rating)
VALUES
(2, 'Studio Lens', 'photography', 'Jakarta', 'Professional wedding photography with elegant touch', 'studio.jpg', 2500000, 4.9);

INSERT INTO vendor_gallery (vendor_id, image_path)
VALUES
(1, 'gallery1.jpg'),
(1, 'gallery2.jpg'),
(1, 'gallery3.jpg');

INSERT INTO testimonials (vendor_id, user_id, rating, message, image_path)
VALUES
(1, 3, 4.8, 'Absolutely amazing photos and great service!', 'testi1.jpg');

INSERT INTO cart_items (user_id, vendor_id, quantity)
VALUES
(3, 1, 1);

INSERT INTO transactions (user_id, total, status)
VALUES
(3, 2500000, 'completed');

INSERT INTO transaction_items (transaction_id, vendor_id, price, quantity)
VALUES
(1, 1, 2500000, 1);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    notelp VARCHAR(20),
    birth DATE,
    address VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    user_type ENUM('client','vendor') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    service_type VARCHAR(50) NOT NULL,
    profile_image VARCHAR(255),
    location VARCHAR(100),
    description TEXT,
    price INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE

    -- Tabel utama vendor
CREATE TABLE vendors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    location VARCHAR(100),
    service_type VARCHAR(50),
    description TEXT,
    price INT,
    profile_image VARCHAR(255)
);

-- Tabel galeri vendor (relasi ke vendors)
CREATE TABLE vendor_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    vendor_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vendor_id) REFERENCES vendors(id) ON DELETE CASCADE
);

-- (Opsional) Tabel users jika ingin relasi vendor ke user
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('client','vendor') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
);