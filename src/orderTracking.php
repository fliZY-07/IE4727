<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Order Tracking</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/orderTracking.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div id="searchbar">
            <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
            <!-- <input type="text" placeholder="search"> -->
        </div>

        <div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="mens.php">Men's</a></li>
                    <li><a href="womens.php">Women's</a></li>
                </ul>
            </nav>
        </div>

        <div>
            <ul id="iconbar">
                <li><a href="profile.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="orderTracking.php"><i class="fa-solid fa-box"></i></a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </header>

    <div id="wrapper">
        <h2><i class="fa-solid fa-box"></i>  ORDER TRACKING</h2>

        <form method="POST" action="orderTracking.php" id="orderForm">
            <div class="tabs">
                <button id="all-btn" type="submit" name="orderStatus" value="all">ALL</button>
                <button type="submit" name="orderStatus" value="Paid">PAID</button>
                <button type="submit" name="orderStatus" value="Shipped">SHIPPED</button>
                <button type="submit" name="orderStatus" value="Out For Delivery">OUT FOR DELIVERY</button>
                <button id="received-btn" type="submit" name="orderStatus" value="Received">RECEIVED</button>
            </div>
        </form>

        <div class="orders">
        <?php
            include './utils/loginStatus.php';
            include './utils/errorLogger.php';

            $logger = new ErrorLogger();

            // Connect to the database
            $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

            if ($db->connect_errno) {
                $logger->logError('Database connection error: ' . $db->connect_error);
                echo "Error loading contents. Please try again later.";
                exit();
            }

            // Get customerId from session
            $customerId = $_SESSION['customerId'];
            $orderStatus = isset($_POST['orderStatus']) ? $_POST['orderStatus'] : 'all';

            // Prepare the query based on the order status
            $query = $orderStatus === 'all'
                ? "SELECT * FROM orders WHERE customerId = ?"
                : "SELECT * FROM orders WHERE customerId = ? AND orderStatus = ?";

            // Prepare and bind the statement
            $stmt = $db->prepare($query);
            if ($orderStatus === 'all') {
                $stmt->bind_param("s", $customerId);
            } else {
                $stmt->bind_param("ss", $customerId, $orderStatus);
            }

            // Execute the query
            if (!$stmt->execute()) {
                $logger->logError('Query execution error: ' . $stmt->error);
                echo "Error fetching orders. Please try again later.";
                exit();
            }

            $resultOrders = $stmt->get_result();

            // Check if there are results and display them
            if ($resultOrders && $resultOrders->num_rows > 0) {
                while ($rowOrder = $resultOrders->fetch_assoc()) {
                    $orderId = $rowOrder["orderId"];

                    echo '<input type="hidden" id="orderId" value="'.$orderId.'">';

                    // Fetch order items for this order
                    $itemQuery = $db->prepare("SELECT * FROM orderedItems WHERE orderId = ?");
                    $itemQuery->bind_param("i", $orderId);
        
                    if (!$itemQuery->execute()) {
                        $logger->logError('Error fetching order items: ' . $itemQuery->error);
                        continue; // Skip this order if we can't fetch items
                    }

                    $resultItems = $itemQuery->get_result();
        
                    while ($orderItems = $resultItems->fetch_assoc()) {
                        $quantity = $orderItems['quantity'];
                        $subtotal = $orderItems['subTotal'];
                        $productId = $orderItems['productId'];
                        

                        // Fetch product details
                        $productQuery = $db->prepare('SELECT * FROM products WHERE productId = ?');
                        $productQuery->bind_param('i', $productId);
                        $productQuery->execute();
                        $productResult = $productQuery->get_result();
                        $product = $productResult->fetch_assoc();

                        echo '<div class="orderItem">';
                        echo '<div class="orderDetails"><img src="' . htmlspecialchars($product['productImage']) . '" alt="Product Image"">';
                        echo '<div class="orderInfo">';
                        echo '<h3>' . htmlspecialchars($product['productName']) . '</h3>';
                        echo '<p>' . htmlspecialchars($product['descrip']) . '</p>';
                        echo '<p>Quantity: ' . htmlspecialchars($quantity) . '</p>';
                        echo '</div>';
                        echo '<div class="orderPrice">$' . number_format($subtotal, 2) . '</div>';
                        echo '</div>'; // Close order-details
            
                        echo '<hr class="order-divider">';
                        echo '<div class="orderStatus">';
                        echo '<p>Status: ' . htmlspecialchars($rowOrder['orderStatus']) . '</p>';

                        if ($rowOrder['orderStatus'] === 'Out for delivery') {
                            echo '<button id="receive">Received</button>';
                        }

                        if ($rowOrder)
                        echo '</div>';
                        echo '</div>'; // Close order-item
                    }

                    $itemQuery->close();
                }
            } else {
                echo "No orders found for the selected status.";
            }

            // Close the statement and the database connection
            $stmt->close();
            $db->close();
            ?>

        </div>
    </div>

    <footer>
        <div class="socialMedia">
            <div class="icon facebook">
            <div class="tooltip">Facebook</div>
                <span><i><i class="fa-brands fa-facebook"></i></i></span>
            </div>
            <div class="icon X">
            <div class="tooltip">X</div>
                <span><i><i class="fa-brands fa-twitter"></i></i></span>
            </div>
            <div class="icon instagram">
            <div class="tooltip">Instagram</div>
                <span><i><i class="fa-brands fa-instagram"></i></i></span>
            </div>
            <div class="icon youtube">
            <div class="tooltip">Youtube</div>
                <span><i><i class="fa-brands fa-youtube"></i></i></span>
            </div>
        </div>
        
        <div>
            <p>Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br></p>
        </div>

    </footer>

<script src="../static/js/orderTracking.js"></script>
</body>
</html>