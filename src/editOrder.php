<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Profile (Edit Order)</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/profile.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<?php include './utils/loginStatus.php' ?>

<div>
    <header>
        <div id="searchbar">
            <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
            <input type="text" placeholder="search">
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
        <div id="leftColumn">
            <div>
                <nav id="profile">
                    <ul>
                        <li><a href="profile.php">
                        <i class="fa-solid fa-circle-info"></i>&nbsp View Account Information</a></li><br>
                        <li><a href="updateInfo.php">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp Update Information</a></li><br>
                        <li><a href="orderTracking.php">
                        <i class="fa-solid fa-store"></i>&nbsp My Orders</a></li><br>
                        <li><a href="editOrder.php"   class="active">
                        <i class="fa-solid fa-file-pen"></i>&nbsp Edit Order</a></li>
                    </ul>
                </nav>
            </div>

            <a href="userLogout.php">Logout &nbsp<i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
         
        <div id="rightColumn">
            <h2><i class="fa-solid fa-file-pen"></i></i>&nbsp Edit Order</h2>
            <form action="editOrder.php" method="POST" id="profile-form">
                <div>
                    <label for="address">Address</label>
                    <input type="text" placeholder='Your Address here' name="address"/>
                </div>

                <?php
                    // Connect to the database
                    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                    if ($db->connect_errno) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    if (isset($_GET['orderId'])) {
                        $orderId = $_GET['orderId'];
                        $userQuery = $db->prepare('SELECT customerId from orders WHERE orderId = ?');
                        $userQuery->bind_param('i', $orderId);
                        $userQuery->execute();
                        $result = $userQuery->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $customerId = $row["customerId"];
                        }

                        $orderQuery = $db->prepare("SELECT products.productName, products.productId, products.productImage, orderedItems.productSize, orderedItems.quantity
                                                            FROM orderedItems
                                                            JOIN products ON products.productId = orderedItems.productId
                                                            WHERE orderedItems.orderId = ?");
                        $orderQuery->bind_param("i", $orderId);
                        $orderQuery->execute();
                        $result = $orderQuery->get_result();

                        echo '<input type="hidden" value="'.$orderId.'" name="orderId">';
                        echo '<input type="hidden" value="'.$customerId.'" name="customerId">';
                        while ($row = $result->fetch_assoc()) {
                            echo '
                                <div>
                                    <h4 style="margin-bottom: 5px;">Product Name: '.$row["productName"].'</h4>
                                    <img src="'.$row["productImage"].'" style="width: 200px; height: 200px">
                                    <p> Quantity: '.$row["quantity"].'</p>
                                    <input type="hidden" value="'.$row['productId'].'" name="productId[]">
                                    <label for="size" style="padding-left: 0px; color: #532e28">Size: 
                                    <select name="size[]">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                    </label>

                                </div> 
                            ';
                        }


                        // Close the prepared statement and the database connection
                        $orderQuery->close();
                    }

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // print_r($_POST);
                        $address = trim($_POST['address']);
                        $userQuery = $db->prepare('UPDATE users SET customerAddress = ? WHERE customerId = ?');
                        $userQuery->bind_param('si', $address, $customerId);
                        $userQuery->execute();

                        $sizes = $_POST['size'];
                        $orderId = $_POST['orderId'];
                        $productIds = $_POST['productId'];
                        $orderQuery = $db->prepare('UPDATE orderedItems SET productSize = ? WHERE orderId = ? AND productId = ?');
                        for ( $i = 0; $i < sizeof($sizes); $i++ ) {
                            $orderQuery->bind_param('sii', $sizes[$i], $orderId, $productIds[$i]);
                            $orderQuery->execute();
                        }
                        echo "<p>Order Updated Successfully!</p>";
                        exit;
                    }

                    $db->close();
                ?>
                <br>

                <input type="submit">
            </form>

            <div>
            </div>
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

</body>
</html>