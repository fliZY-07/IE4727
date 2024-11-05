<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Order Management</title>
<link rel="stylesheet" href="../static/css/adminPanelGeneral.css">
<link rel="stylesheet" href="../static/css/orderManagement.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
        <h2>ADMIN PANEL</h2>
    </header>


    <div id="wrapper">
        <div id="leftColumn">
            <nav>
                <ul>
                    <li><a href="productManagement.php">
                        <i class="fa-solid fa-shirt"></i>Product Management</a></li>
                    <li><a href="orderManagement.php" class="active">
                        <i class="fa-solid fa-list-check"></i> Order Management</a></li>
                    <li><a href="uploadNew.php">
                        <i class="fa-solid fa-square-plus"></i> Upload New Product</a></li>
                </ul>
            </nav>
        </div>

        <div id="rightColumn">
            <h2><i class="fa-solid fa-list-check"></i> Order Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order Date</th>
                        <th>Customer</th>
                        <th>Order ID</th>
                        <th>Item(s)</th>
                        <th>Total Price</th>
                        <th>Receiver</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php   
                // connect database
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                
                if (mysqli_connect_errno()) {
                    echo "Error: Could not connect to the database. Please try again later.";
                    exit;
                }

                // retrieve all products data from database
                $query = 
                        "SELECT
                            o.orderId,
                            o.orderDate,
                            o.orderStatus,
                            o.total,
                            o.customerId,
                            u.customerAddress,
                            CONCAT(u.lastName, ' ', u.firstName) AS 'customer',
                            CONCAT(p.productName, ' (Size: ', oi.productSize, ', Quantity: ', oi.quantity, ')') AS 'item',
                            oi.subTotal
                        FROM 
                            orders o
                        JOIN 
                            users u ON o.customerId = u.customerId
                        JOIN 
                            orderedItems oi ON o.orderId = oi.orderId
                        JOIN 
                            products p ON oi.productId = p.productId
                        ORDER BY 
                            o.orderDate DESC;
                        ";

                $result = $db->query($query);
            
                if ($result) {
                    while ($row = $result->fetch_assoc()) {  
                        // echo "<pre>";
                        // print_r($row);  
                        // echo "</pre>";
                        echo "<tr>";
                        echo '<td>'. htmlspecialchars($row['orderDate']) .'</td>';
                        echo '<td>' . htmlspecialchars($row['customer']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['orderId']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['item']) . '</td>';
                        echo '<td>$' . number_format($row['subTotal'], 2) . '</td>';
                        echo '<td>' . htmlspecialchars($row['customer']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['customerAddress']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['orderStatus']) . '</td>';
                        echo '<td>
                                <form method="POST" action="updateOrderStatus.php">
                                    <input type="hidden" name="orderId" value="' . $row['orderId'] . '">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="Shipped">Shipped</option>
                                        <option value="Out For Delivery">Out for Delivery</option>
                                        <option value="Received">Delivered</option>
                                    </select>
                                </form>
                            </td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No orders found.</td></tr>";
                }
                $db->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <div>
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>
    </footer>
</body>
</html>