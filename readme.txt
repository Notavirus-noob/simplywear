!!readme.txt
database ko name::bridge_courier
CREATE TABLE proddet(
	id int PRIMARY KEY AUTO_INCREMENT,
    image varchar(100),
    prodname varchar(100),
    price int, 
    quantity int
)

CREATE TABLE seller_credentials (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Auto-increment primary key
    username VARCHAR(100) NOT NULL unique,         -- Seller's username
    email VARCHAR(255) NOT NULL UNIQUE, -- Unique email for the seller
    phone_number VARCHAR(15) NOT NULL UNIQUE, -- Unique contact number
    address TEXT NOT NULL,              -- Seller's address
    password VARCHAR(255) NOT NULL,
    status ENUM('pending', 'active') DEFAULT 'pending' -- Status: 'pending' or 'active'
);




CREATE TABLE user_credentials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobile VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

