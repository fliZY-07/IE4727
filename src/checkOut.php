<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Check Out</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/checkOut.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
<script src="../static/js/payment.js" defer></script>
</head>

<body>
    <header>
        <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
        <h2>CHECK OUT</h2>
    </header>

    <div id="wrapper">
        <!-- back to shopping cart -->
        <div>
            <button type="button" id="backToCart" 
                    onclick="window.location.href='cart.php'">&lt; Back to Cart</button>
        </div>

        <div class="checkOut">
            <form id="newOrder" method="POST" action="./payment.php">
                <div id="leftColumn">
                    <!-- shipping address bar -->
                    <div class="shippingAddress"> 
                        <i class="fa-solid fa-map-location-dot"></i>
                        <?php
                            include("./utils/loginStatus.php");

                            // Connect to the database
                            $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                            if ($db->connect_errno) {
                                echo "Error: Could not connect to the database. Please try again later.";
                                exit;
                            }

                            // Fetch user ID
                            $customerId = $_SESSION['customerId'];

                            // Get user's name and shipping address
                            $query = "SELECT firstName, lastName, customerAddress FROM users WHERE customerId = ?";
                            $stmt = $db->prepare($query);
                            $stmt->bind_param("i", $customerId);
                            $stmt->execute();
                            $stmt->bind_result($firstName, $lastName, $customerAddress);

                            // Fetch results
                            if ($stmt->fetch()) {
                                echo "<div>";
                                echo "<h2>Name: $firstName $lastName</h2>";
                                echo "<p>Address: $customerAddress</p>";
                                echo "</div>";

                                // Check if address exists
                                if (empty($customerAddress)) {
                                    echo "<p>Please input your shipping address</p>";
                                    echo "<input type='text'>";
                                }
                            } else {
                                echo "<p>No user found. Please log in.</p>";
                            }

                            $stmt->close();
                            ?>
                    </div>

                    <!-- display ordered products -->
                    <h3>Your order at a glance...</h3>
                    <div class="checkOutProduct">
                        
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $productIds = $_POST['selected'];
                                $descrips = $_POST['descrip'];
                                $quantites = $_POST['quantity'];
                                $sizes = $_POST['size'];
                                $subtotal = 0;
                                
                                for ($i = 0; $i < sizeof($productIds); $i++) {
                                    $productId = $productIds[$i];
                                    $descrip = $descrips[$i];
                                    $quantity = $quantites[$i];
                                    $size = $sizes[$i];

                                    // show all checked products here 
                                    $query = $db->prepare("SELECT productName, productImage, price FROM products WHERE productId = ?");
                                    $query->bind_param("i", $productId);
                                    $query->execute();
                                    $result = $query->get_result();

                                    $row = $result->fetch_assoc();
                                    $productImage = $row['productImage'];
                                    $productName = $row['productName'];
                                    $price = $row['price'];
                                    $subprice = $quantity * $price;
                                    $subtotal += $subprice;

                                    echo "<div style='border: 1;border-radius: 1;'>";
                                    echo "<img src='$productImage' style='height: 200px; width: 200px;'>";
                                    echo "<div>";
                                    echo "<label font-size=20; text=bold>$productName</label><br>";
                                    echo "<input type='hidden' value='$productName' name='productName[]'>";
                                    echo "<label>Quantity: $quantity</label><br>";
                                    echo "<input type='hidden' value='$quantity' name='quantity[]'>";
                                    echo "<label style='align:right; text: bold'>Size: $size</label><br>";
                                    echo "<input type='hidden' value='$size' name='size[]'>";
                                    echo "<label style='align:right; text: bold'>$ $subprice</label>";
                                    echo "<input type='hidden' value='$subprice' name='subtotals[]'>";
                                    echo "<input type='hidden' value='$productId' name='productIds[]'>";
                                    echo "</div></div>";
                                }
                                echo "<input type='hidden' value='$subtotal' id='subtotalValue'>";
                            }
                        ?>
                    </div>

                    <!-- delivery option -->
                    <div>
                        <h3><i class="fa-solid fa-truck-fast"></i>&nbsp Delivery option</h3>
                        <div class="deliveryOption">
                            <button type="button" value="fastDe" class="deliveryButton" onclick="setShippingFee(3.99)">
                                <span style="float: left;">Fast Delivery</span>
                                <span style="float: right;">$3.99</span>
                            </button>
                            <button type="button" value="standardDe" class="deliveryButton" onclick="setShippingFee(0.00)">
                                <span style="float: left;">Standard Delivery</span>
                                <span style="float: right;">FREE</span>
                            </button>
                        </div>
                    </div>

                </div>

                <div id="rightColumn">
                    <!-- order summary -->
                    <h3><i class="fa-solid fa-list"></i>&nbsp Order Summary</h3>
                    <div class="orderSummary">
                        <div id="bill">
                            <div id="subtotal">
                                <h3>Sub-total</h3>
                                <p id="subtotalPrice">$</p>
                            </div>

                            <div id="shipping">
                                <h3>Shipping Fee</h3>
                                <p id="shippingFee">$ 0.00</p>
                            </div>  

                            <div id="total">
                                <h3>Total <small>(Including GST)</small></h3>
                                <p id="totalPrice">$</p>
                            </div>
                        </div>
                    </div>

                    <!-- payment details -->
                    <h3><i class="fa-solid fa-bag-shopping"></i>&nbsp Payment Details</h3>
                    <p>Complete your purchase by providing the information below.</p>    
                    <div class="payment">
                        <div id="paymentDetails">
                            <div class="email">
                                <label for="email" style="font-weight:bold;">Email Address</label>
                                <input type="text" id="email" placeholder="Enter your email here" required>
                                <span id="emailError"></span>
                            </div>

                            <label style="font-weight:bold; padding-top:5px;">Card Details</label>
                            <div>
                                <div class="name">
                                <label for="name">Name</label>
                                <input type="text" id="name" placeholder="Enter name on the card here" required>
                                <span id="nameError"></span>
                                </div>
                                
                                <div class="cardNo">
                                <label for="cardNo">Card number</label>
                                <input type="text" id="cardNo" placeholder="XXXX XXXX XXXX XXXX" required>
                                <span id="cardNoError"></span>
                                </div>
                                
                                <div class="expiry-cvv">
                                    <div class="expiry">
                                        <label for="expiry">Valid thru</label>
                                        <input type="text" id="expiry" placeholder="MM/YY" required>
                                        <span id="expiryError"></span>
                                    </div>

                                    <div class="cvv">
                                        <label for="cvv">CVV</label>
                                        <input type="text" id="cvv" placeholder="XXX" required>
                                        <span id="cvvError"></span>
                                    </div>
                                </div>
                            </div>
                            <!-- card details -->
                            <?php echo '<input type="submit" id="paymentSubmit" name="totalPrice" value="Pay $ 0.00">'; ?>
                        </div>
                        <!-- onsubmit: alert payment made successfully, direct to order tracking page -->
                    </div>
                </div>
            </form>
            <script type = "text/javascript"  src = "../js/paymentValidation.js" ></script>
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
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>
    <script src="../static/js/checkOut.js" defer></script>
    </footer>
</body>
</html>