INSERT INTO users (firstName, lastName, email, passwordHash, phoneNo, customerAddress) VALUES
('Alice', 'Johnson', 'alice.johnson@example.com', 'hashed_password_1', '123-456-7890', '123 Elm St, Springfield'),
('Bob', 'Smith', 'bob.smith@example.com', 'hashed_password_2', '987-654-3210', '456 Maple Ave, Springfield'),
('Carol', 'Williams', 'carol.williams@example.com', 'hashed_password_3', '555-123-4567', '789 Oak Dr, Springfield'),
('David', 'Brown', 'david.brown@example.com', 'hashed_password_4', '555-987-6543', '321 Pine Rd, Springfield'),
('Eve', 'Davis', 'eve.davis@example.com', 'hashed_password_5', '555-000-1111', '654 Cedar Blvd, Springfield'),
('James', 'Smith', 'alice@example.com', 'hashed_password_6', '1234567890', '123 Apple St, Wonderland'),
('Laurent', 'Brown', 'bob@example.com', 'hashed_password_7', '0987654321', '456 Orange Ave, Dreamland');

INSERT INTO categories (gender, category) VALUES
('Men', 'T-shirts'),
('Men', 'Polo'),
('Men', 'Long Sleeve'),
('Men', 'Shorts'),
('Men', 'Trousers'),
('Women', 'Tops'),
('Women', 'Dresses'),
('Women', 'Shirts & Blouses'),
('Women', 'Skirts'),
('Women', 'Shorts'),
('Women', 'Trousers');

INSERT INTO products (productName, descrip, price, productImage, categoryId) VALUES
 -- Men: T-shirts (categoryId = 1)
    ('Basic White T-Shirt', 'Classic white t-shirt, comfortable and versatile.', 15.99, '../static/asset/image/white_tshirt.jpg', 1),
    ('Graphic Tee', 'Stylish t-shirt with a unique graphic design.', 18.99, '../static/asset/image/graphic_tee.jpg', 1),
    ('Sports T-Shirt', 'Breathable fabric, ideal for sports and workouts.', 20.99, '../static/asset/image/sports_tshirt.jpg', 1),
    ('Vintage Print T-Shirt', 'Retro style t-shirt with a vintage print.', 17.99, '../static/asset/image/vintage_print_tshirt.jpg', 1),
    ('Colorful Striped T-Shirt', 'Vibrant striped t-shirt for a fresh look.', 19.99, '../static/asset/image/striped_tshirt.jpg', 1),

    -- Men: Polo (categoryId = 2)
    ('Casual Polo', 'Everyday casual polo shirt, easy to match.', 25.99, '../static/asset/image/casual_polo.jpg', 2),
    ('Striped Polo', 'Polo shirt with a stylish striped pattern.', 27.99, '../static/asset/image/striped_polo.jpg', 2),
    ('Classic Black Polo', 'Essential black polo for every occasion.', 29.99, '../static/asset/image/black_polo.jpg', 2),
    ('Slim Fit Polo', 'Tailored fit polo for a modern look.', 31.99, '../static/asset/image/slim_fit_polo.jpg', 2),
    ('Short Sleeve Polo', 'Comfortable short sleeve polo for warm days.', 23.99, '../static/asset/image/short_sleeve_polo.jpg', 2),

    -- Men: Long Sleeve (categoryId = 3)
    ('Denim Long Sleeve Shirt', 'Classic denim shirt, perfect for layering.', 35.99, '../static/asset/image/denim_long_sleeve.jpg', 3),
    ('Plaid Flannel Shirt', 'Cozy flannel shirt, great for colder weather.', 29.99, '../static/asset/image/plaid_flannel.jpg', 3),
    ('Button-Up Long Sleeve', 'Versatile button-up for casual or formal wear.', 32.99, '../static/asset/image/button_up_long_sleeve.jpg', 3),
    ('Hooded Long Sleeve', 'Comfortable hooded shirt for casual outings.', 28.99, '../static/asset/image/hooded_long_sleeve.jpg', 3),
    ('Basic Long Sleeve Tee', 'Essential long sleeve tee for layering.', 21.99, '../static/asset/image/basic_long_sleeve_tee.jpg', 3),

    -- Men: Shorts (categoryId = 4)
    ('Cargo Shorts', 'Utility cargo shorts with multiple pockets.', 22.99, '../static/asset/image/cargo_shorts.jpg', 4),
    ('Chino Shorts', 'Classic chino shorts for a smart-casual look.', 24.99, '../static/asset/image/chino_shorts.jpg', 4),
    ('Denim Shorts', 'Stylish denim shorts for summer.', 26.99, '../static/asset/image/denim_shorts.jpg', 4),
    ('Athletic Shorts', 'Comfortable shorts for sports and workouts.', 19.99, '../static/asset/image/athletic_shorts.jpg', 4),
    ('Linen Shorts', 'Lightweight linen shorts for hot weather.', 23.99, '../static/asset/image/linen_shorts.jpg', 4),

    -- Men: Trousers (categoryId = 5)
    ('Slim Fit Trousers', 'Modern slim fit trousers for a tailored look.', 39.99, '../static/asset/image/slim_fit_trousers.jpg', 5),
    ('Relaxed Fit Trousers', 'Comfortable relaxed fit for everyday wear.', 37.99, '../static/asset/image/relaxed_fit_trousers.jpg', 5),
    ('Chino Trousers', 'Stylish chinos for a smart-casual appearance.', 34.99, '../static/asset/image/chino_trousers.jpg', 5),
    ('Formal Dress Trousers', 'Perfect trousers for formal occasions.', 45.99, '../static/asset/image/dress_trousers.jpg', 5),
    ('Jogger Trousers', 'Casual joggers for a comfortable fit.', 29.99, '../static/asset/image/jogger_trousers.jpg', 5),

    -- Women: Tops (categoryId = 6)
    ('V-Neck Top', 'Stylish and elegant V-neck top.', 19.99, '../static/asset/image/v_neck_top.jpg', 6),
    ('Ruffle Sleeve Blouse', 'Chic blouse with ruffle sleeves.', 22.99, '../static/asset/image/ruffle_sleeve_blouse.jpg', 6),
    ('Casual Tank Top', 'Comfortable tank top for hot days.', 15.99, '../static/asset/image/tank_top.jpg', 6),
    ('Satin Camisole', 'Elegant camisole, perfect for layering.', 18.99, '../static/asset/image/satin_camisole.jpg', 6),
    ('Long Sleeve Knit Top', 'Cozy knit top for cooler weather.', 24.99, '../static/asset/image/knit_top.jpg', 6),

    -- Women: Dresses (categoryId = 7)
    ('Maxi Dress', 'Flowy maxi dress perfect for summer.', 45.99, '../static/asset/image/maxi_dress.jpg', 7),
    ('Wrap Dress', 'Classic wrap dress for a flattering silhouette.', 42.99, '../static/asset/image/wrap_dress.jpg', 7),
    ('A-Line Dress', 'Versatile A-line dress for various occasions.', 39.99, '../static/asset/image/a_line_dress.jpg', 7),
    ('Shift Dress', 'Simple shift dress for easy styling.', 36.99, '../static/asset/image/shift_dress.jpg', 7),
    ('Off-Shoulder Dress', 'Stylish off-shoulder dress for summer outings.', 49.99, '../static/asset/image/off_shoulder_dress.jpg', 7),

    -- Women: Shirts & Blouses (categoryId = 8)
    ('Silk Blouse', 'Elegant silk blouse for formal events.', 34.99, '../static/asset/image/silk_blouse.jpg', 8),
    ('Cotton Button-Up', 'Comfortable cotton button-up shirt.', 28.99, '../static/asset/image/cotton_button_up.jpg', 8),
    ('Floral Print Blouse', 'Bright floral print for a cheerful look.', 30.99, '../static/asset/image/floral_b blouse.jpg', 8),
    ('Peplum Top', 'Trendy peplum top for a stylish silhouette.', 25.99, '../static/asset/image/peplum_top.jpg', 8),
    ('Chiffon Blouse', 'Lightweight chiffon blouse for elegant layering.', 27.99, '../static/asset/image/chiffon_blouse.jpg', 8),

    -- Women: Skirts (categoryId = 9)
    ('A-Line Skirt', 'A-line skirt, versatile and stylish.', 27.99, '../static/asset/image/a_line_skirt.jpg', 9),
    ('Pencil Skirt', 'Classic pencil skirt for a professional look.', 32.99, '../static/asset/image/pencil_skirt.jpg', 9),
    ('Pleated Skirt', 'Fashionable pleated skirt for a fun style.', 29.99, '../static/asset/image/pleated_skirt.jpg', 9),
    ('Denim Skirt', 'Casual denim skirt for everyday wear.', 24.99, '../static/asset/image/denim_skirt.jpg', 9),
    ('Maxi Skirt', 'Flowy maxi skirt for a relaxed look.', 34.99, '../static/asset/image/maxi_skirt.jpg', 9),

    -- Women: Shorts (categoryId = 10)
    ('High-Waisted Shorts', 'Trendy high-waisted shorts.', 23.99, '../static/asset/image/high_waisted_shorts.jpg', 10),
    ('Denim Cutoffs', 'Stylish denim cutoff shorts.', 21.99, '../static/asset/image/denim_cutoffs.jpg', 10),
    ('Linen Blend Shorts', 'Light and breathable shorts for summer.', 19.99, '../static/asset/image/linen_blend_shorts.jpg', 10),
    ('Printed Shorts', 'Fun printed shorts for a vibrant look.', 18.99, '../static/asset/image/printed_shorts.jpg', 10),
    ('Sporty Running Shorts', 'Comfortable shorts for running and workouts.', 20.99, '../static/asset/image/sporty_running_shorts.jpg', 10),

    -- Women: Trousers (categoryId = 11)
    ('Wide Leg Trousers', 'Comfortable wide-leg trousers.', 36.99, '../static/asset/image/wide_leg_trousers.jpg', 11),
    ('High-Waisted Trousers', 'Stylish high-waisted trousers for a chic look.', 38.99, '../static/asset/image/high_waisted_trousers.jpg', 11),
    ('Tailored Trousers', 'Classic tailored trousers for a professional appearance.', 45.99, '../static/asset/image/tailored_trousers.jpg', 11),
    ('Culottes', 'Fashionable culottes for a relaxed fit.', 33.99, '../static/asset/image/culottes.jpg', 11),
    ('Jogger Trousers', 'Casual joggers for a comfortable fit.', 29.99, '../static/asset/image/women_jogger_trousers.jpg', 11);


INSERT INTO shoppingCart (productSize, quantity, customerId, productId) VALUES
('M', 2, 22, 1),   
('L', 1, 22, 10),
('S', 3, 22, 20),
('M', 1, 22, 5), 
('M', 2, 22, 15),
('L', 1, 22, 25),
('S', 2, 22, 3), 
('M', 1, 22, 12),
('L', 2, 22, 22),
('M', 1, 22, 6), 
('L', 2, 22, 16),
('S', 1, 22, 26),
('M', 3, 22, 9), 
('L', 1, 22, 19),
('S', 2, 22, 29);

INSERT INTO shoppingCart (productSize, quantity, customerId, productId) VALUES
('M', 2, 22, 1),   
('L', 1, 22, 10),
('S', 3, 22, 20);

INSERT INTO orders (orderDate, orderStatus, total, customerId) VALUES
(NOW(), 'Paid', 75.97, 1),
(NOW(), 'Shipped', 60.99, 1),
(NOW(), 'Out for Delivery', 85.49, 2),
(NOW(), 'Received', 95.99, 2),
(NOW(), 'Completed', 40.00, 3),
(NOW(), 'Paid', 55.00, 3),
(NOW(), 'Shipped', 70.20, 4),
(NOW(), 'Out for Delivery', 30.00, 4),
(NOW(), 'Received', 100.00, 5),


INSERT INTO orderedItems (productSize, quantity, subTotal, orderId, productId) VALUES
('M', 1, 15.99, 1, 1),      -- Order ID 1
('L', 1, 19.99, 1, 10),     -- Order ID 1
('M', 1, 22.99, 2, 5),      -- Order ID 2
('S', 2, 27.99, 3, 3),      -- Order ID 3
('M', 1, 29.99, 4, 6),      -- Order ID 4
('L', 2, 34.99, 5, 12),     -- Order ID 5
('S', 1, 18.99, 6, 20),     -- Order ID 6
('M', 1, 35.99, 7, 8),      -- Order ID 7
('M', 3, 20.99, 8, 30),     -- Order ID 8
('L', 1, 39.99, 9, 22),     -- Order ID 9
('S', 1, 15.99, 10, 15),    -- Order ID 10
('M', 2, 17.99, 10, 25);    -- Order ID 10

INSERT INTO payments (paymentMethod, paymentDate, paymentStatus, orderId) VALUES
('Credit Card', NOW(), 'Completed', 1),
('Debit Card', NOW(), 'Completed', 2),
('Debit Card', NOW(), 'Completed', 3),
('Credit Card', NOW(), 'Completed', 4),
('Credit Card', NOW(), 'Completed', 5),
('Credit Card', NOW(), 'Completed', 6),
('Debit Card', NOW(), 'Completed', 7),
('Credit Card', NOW(), 'Completed', 8),
('Credit Card', NOW(), 'Completed', 9),
('Debit Card', NOW(), 'Completed', 10);

INSERT INTO shipping (receiverName, shippingAddress, shippingMethod, shippedDate, deliveryDate, receivedDate, orderId) VALUES
('John Doe', '123 Main St, Springfield', 'Standard', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NULL, 1),
('Jane Smith', '456 Elm St, Springfield', 'Express', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), NULL, 2),
('Michael Johnson', '789 Oak St, Springfield', 'Standard', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NULL, 3),
('Emily Davis', '321 Pine St, Springfield', 'Express', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), NULL, 4),
('Sarah Williams', '654 Maple St, Springfield', 'Standard', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NULL, 5),
('John Doe', '123 Main St, Springfield', 'Express', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), NULL, 6),
('Jane Smith', '456 Elm St, Springfield', 'Standard', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NULL, 7),
('Michael Johnson', '789 Oak St, Springfield', 'Express', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), NULL, 8),
('Emily Davis', '321 Pine St, Springfield', 'Standard', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NULL, 9),
('Sarah Williams', '654 Maple St, Springfield', 'Express', NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), NULL, 10);
