CREATE TABLE users (
    customerId INT PRIMARY KEY AUTO_INCREMENT,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    passwordHash VARCHAR(200) NOT NULL,
    phoneNo VARCHAR(20),
    customerAddress TEXT,
    registeredAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    categoryId INT PRIMARY KEY AUTO_INCREMENT,
    gender VARCHAR(50) NOT NULL,
    category VARCHAR(50) NOT NULL
);

CREATE TABLE products (
    productId INT PRIMARY KEY AUTO_INCREMENT,
    productName VARCHAR(100) NOT NULL,
    descrip TEXT,
    price DECIMAL(10, 2) NOT NULL,
    productImage VARCHAR(200) NOT NULL,

    categoryId INT,
    FOREIGN KEY (categoryId) REFERENCES categories(categoryId) ON DELETE SET NULL
);

CREATE TABLE shoppingCart (
    cartId INT PRIMARY KEY AUTO_INCREMENT,
    productSize VARCHAR(5) NOT NULL,
    quantity INT NOT NULL,
    
    customerId INT,
    productId INT,
    FOREIGN KEY (customerId) REFERENCES users(customerId) ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES products(productId) ON DELETE CASCADE
);

CREATE TABLE orders (
    orderId INT PRIMARY KEY AUTO_INCREMENT,
    orderDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    orderStatus ENUM('Paid', 'Shipped', 'Out for delivery', 'Received') NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    
    customerId INT,
    FOREIGN KEY (customerId) REFERENCES users(customerId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE orderedItems (
    orderItemId INT PRIMARY KEY AUTO_INCREMENT,
    productSize VARCHAR(5) NOT NULL CHECK (productSize IN ('S', 'M', 'L', 'XL')),
    quantity INT NOT NULL,
    subTotal DECIMAL(10, 2) NOT NULL,
    
    orderId INT,
    productId INT,
    FOREIGN KEY (orderId) REFERENCES orders(orderId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (productId) REFERENCES products(productId) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE payments (
    paymentId INT PRIMARY KEY AUTO_INCREMENT,
    paymentMethod VARCHAR(50) NOT NULL,
    paymentDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    paymentStatus VARCHAR(50) NOT NULL,

    orderId INT,
    FOREIGN KEY (orderId) REFERENCES orders(orderId) ON DELETE CASCADE
);

CREATE TABLE shipping (
    shippingId INT PRIMARY KEY AUTO_INCREMENT,
    receiverName VARCHAR(50) NOT NULL,
    shippingAddress TEXT NOT NULL,
    shippingMethod VARCHAR(50) NOT NULL,
    shippedDate TIMESTAMP NULL,
    deliveryDate TIMESTAMP NULL,
    receivedDate TIMESTAMP NULL,

    orderId INT,
    FOREIGN KEY (orderId) REFERENCES orders(orderId)
);
