<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Shopping Cart</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/cart.css">
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
        <div> 
            <h2><i class="fa-solid fa-cart-shopping"></i>  SHOPPING CART
            <?php
                include './utils/loginStatus.php';

                // connect database
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                
                if (mysqli_connect_errno()) {
                    echo "Error: Could not connect to the database. Please try again later.";
                    exit;
                }

                // sent query -> total no. of item in cart
                $customerId = $_SESSION['customerId'];
                $stmt = $db->prepare("SELECT SUM(quantity) AS numItems FROM shoppingCart WHERE customerId = ?");
                $stmt->bind_param("s", $customerId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if the query was successful and fetch the result
                $numItems = 0;
                if ($result && $row = $result->fetch_assoc()) {
                    $numItems = (int)$row["numItems"]; // Cast to int for safety
                } 

                // Display the total number of items in the cart
                echo "($numItems) </h2>";

                // Close the database connection
                $stmt->close();
                $db->close(); 
            ?>
        </div>

        <!-- display cart items -->
        <div id="cart">
            <form id="shoppingCart" action="./checkOut.php" method="POST">
                <div id="itemsInCart">
                    <?php
                        $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                        // sent query to database
                        $stmt = $db->prepare("SELECT * FROM shoppingCart WHERE customerId = ?");
                        $stmt->bind_param("s", $_SESSION['customerId']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $totalPrice = 0;
                        // loop & bring all items in cart from database to browser 
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $productId = $row['productId'];
                                $product_query = $db->prepare("SELECT * FROM products WHERE productId = ?");
                                $product_query->bind_param("d", $productId);
                                $product_query->execute();
                                $product_result = $product_query->get_result();
                                $product_query->close();
                                $product = 0;
                                if ($product_result) {
                                    $products = $product_result->fetch_assoc();
                                    if ($products) {
                                        $product = $products;
                                    }
                                }

                                $subtotal = $product["price"] * intval($row["quantity"]);
                                $totalPrice += $subtotal;

                                echo '<div class="cartItem">';

                                // Checkbox for selecting the item
                                echo '<input type="checkbox" name="selected[]" value="' . $product['productId'] . '" class="itemCheckbox">';

                                // Product image
                                echo '<img src="' . $product['productImage'] . '" alt="Product Image">';

                                echo '<div class="productDetails">';
                                echo '<h3>'.$product['productName'].'</h3>';
                                // echo '<p>'.$product['descrip'].'</p><br>';
                                echo '<input type="hidden" name="descrip[]" value="'.$product['descrip'].'">'.$product['descrip'].'</input><br>';
                                echo '<span>Unit Price: </span>';
                                echo '<span class="unit_price">'.$product["price"].'</span><br>';
                                echo '<div class="quantity">Quantity: 
                                        <input class="quantity_input" type="number" name="quantity[]" value="'.$row['quantity'].'" min="1">
                                    </div>';
                                echo '<div class="size">Size: ';
                                echo '<select name="size[]">';
                                
                                $sizes = ['S', 'M', 'L', 'XL'];
                                foreach ($sizes as $size) {
                                    $selected = ($size == $row['size']) ? 'selected' : '';
                                    echo '<option value="'.$size.'" '.$selected.'>'.$size.'</option>';
                                }

                                echo '</select></div>';
                                echo '</div>';
                                echo '<div class="subtotalremove">';
                                echo '<div class="price">$'.number_format($subtotal, 2).'</div>';
                                

                                // "X" button to remove item from cart
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p>Your cart is empty.</p>';
                        }

                        echo "<div id='test' style='display: flex; flex-direction: row-reverse; justify-content: space-between; align-items: center;'>";
                        echo '<div class="total" style="text-align:right;">Total: $'.number_format($totalPrice, 2).'</div>';
                        $db->close(); 
                    ?>
                    <!-- Select all checkbox -->
                    <div style="text-align:left;">
                        <input type="checkbox" name="selectAll" id="selectAll" onclick="toggleSelectAll(this)">
                        <label for="selectAll">Select all</label>
                        <script>
                        function toggleSelectAll(selectAllCheckbox) {
                            // Select all checkboxes with class 'itemCheckbox'
                            const itemCheckboxes = document.querySelectorAll('.itemCheckbox');
                        
                            // Set each item's checked status to match 'Select All' checkbox
                            itemCheckboxes.forEach(checkbox => {
                                checkbox.checked = selectAllCheckbox.checked;
                            });
                        }
                        </script>
                    </div>
                    </div>
                </div>

                <!-- buttons for actions -->
                <div id="action">
                    <button type="button" id="backToShopping" 
                    onclick="window.location.href='mens.php'">&lt; Back to Shopping</button>
                    <!-- Remove From Cart -->
                    <button type="button" id="removeFromCart"><i class="fa-solid fa-trash"></i></button>
                    <button type="submit" id="checkOut" onclick="redirectToCheckout(this)">Check Out &gt;</button>
                </div>
            </form>
        </div>
        
        <!-- suggestions -->
        <!-- <div id="guess">
            <h2>Guess you might like...</h2>
            <div class="suggestionGrid"> -->
            <!-- //     $categoryQuery = $db->query("SELECT category FROM shoppingCart JOIN products ON shoppingCart.productId = products.productId GROUP BY category");
            //     $suggestedCategory = ($categoryQuery->fetch_assoc()['category'] ?? 'both');
                
            //     // Determine the suggested category
            //     if ($suggestedCategory == 'both') {
            //         // Query for 2 men's products and 3 women's products
            //         $suggestionQueryMen = "SELECT * FROM products WHERE category = 'men' LIMIT 2";
            //         $suggestionQueryWomen = "SELECT * FROM products WHERE category = 'women' LIMIT 3";

            //         // Execute the queries
            //         $suggestionResultMen = $db->query($suggestionQueryMen);
            //         $suggestionResultWomen = $db->query($suggestionQueryWomen);

            //         // Display suggested men's products
            //         if ($suggestionResultMen) {
            //             while ($product = $suggestionResultMen->fetch_assoc()) {
            //                 echo '<div class="suggestionItem">';
            //                 echo '<img src="../../static/images/'.$product['productImage'].'" alt="'.$product['productName'].'">';
            //                 echo '<form method="POST" action="addToCart.php">';
            //                 echo '<input type="hidden" name="productId" value="'.$product['productId'].'">';
            //                 echo '<button type="submit">Add to Cart</button>';
            //                 echo '</form>';
            //                 echo '</div>';
            //             }
            //         }

            //         // Display suggested women's products
            //         if ($suggestionResultWomen) {
            //             while ($product = $suggestionResultWomen->fetch_assoc()) {
            //                 echo '<div class="suggestionItem">';
            //                 echo '<img src="../../static/images/'.$product['productImage'].'" alt="'.$product['productName'].'">';
            //                 echo '<form method="POST" action="addToCart.php">';
            //                 echo '<input type="hidden" name="productId" value="'.$product['productId'].'">';
            //                 echo '<button type="submit">Add to Cart</button>';
            //                 echo '</form>';
            //                 echo '</div>';
            //             }
            //         }
            //     } else {
            //         // If not "both," select up to 5 products from the suggested category
            //         $suggestionQuery = "SELECT * FROM products WHERE category = '$suggestedCategory' LIMIT 5";
            //         $suggestionResult = $db->query($suggestionQuery);

            //         // Display products from the single category
            //         if ($suggestionResult) {
            //             while ($product = $suggestionResult->fetch_assoc()) {
            //                 echo '<div class="suggestionItem">';
            //                 echo '<img src="../../static/images/'.$product['productImage'].'" alt="'.$product['productName'].'">';
            //                 echo '<form method="POST" action="addToCart.php">';
            //                 echo '<input type="hidden" name="productId" value="'.$product['productId'].'">';
            //                 echo '<button type="submit">Add to Cart</button>';
            //                 echo '</form>';
            //                 echo '</div>';
            //             }
            //         } else {
            //             echo '<p>No suggestions available at the moment.</p>';
            //         }
            //     } -->
            <!-- </div>
        </div> -->
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

<script src="../static/js/cart.js"></script>
</body>
</html>