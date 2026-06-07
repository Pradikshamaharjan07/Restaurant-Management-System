CREATE DATABASE rms;
USE rms;
-- USERS (login + roles)
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(15) NOT NULL,
    password VARCHAR(20) NOT NULL,
    role ENUM('admin','waiter','kitchen','cashier') NOT NULL
);
-- Default users for testing
INSERT INTO users (username, password, role) VALUES
('admin','admin123','admin'),
('waiter','waiter123','waiter'),
('kitchen','kitchen123','kitchen'),
('cashier','cashier123','cashier');

-- Table Management
CREATE TABLE restaurant_tables (
    table_id INT AUTO_INCREMENT PRIMARY KEY,
    table_number INT NOT NULL,
    status ENUM('Available','Occupied') DEFAULT 'Available'
);

/*Menu Management*/
CREATE TABLE menu (
    menu_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

/*Inventory Management*/
CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(100) NOT NULL,
    quantity INT NOT NULL
);

/*Orders(Waiter + Kitchen)*/
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    table_id INT NOT NULL,
    order_status ENUM('Pending','Preparing','Ready','Paid') DEFAULT 'Pending',
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

/*Order Item*/
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL
);

/*Payments*/
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_date DATETIME DEFAULT CURRENT_TIMESTAMP
);