<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Order Tracking</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/home.css">
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
                    <li><a href="home.php" class="active">Home</a></li>
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
         <!-- New Collections Section -->
        <div id="new-collections">
                <img src="../static/asset/image/homeimage1.jpg" alt="New Collection Image">
                <div class="text-content">
                    <h2>New Collections</h2>
                    <p>Discover the latest trends and styles for the season. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tempore, dolorum saepe molestias libero vel similique sunt unde, laborum quaerat distinctio nemo amet optio facere neque velit officia. Maxime similique quasi natus id aliquid vitae, amet beatae fugit vel alias eos temporibus ut! Inventore odio quis quaerat a laborum. Deserunt, sapiente.</p>
                    <div id="getSame">
                        <button>Get Same</button>
                    </div>
                </div>
        </div>

        <!-- Style Section -->
        <div id="style">
            <div id="style-content">
                <hr>
                <div id="style-header">
                    <button>Get Same</button>
                    <h1>Style</h1>
                </div>
                <p>Find your unique style with our curated collections. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi illum omnis vitae odit eaque, delectus iure quo iusto ducimus cumque? Voluptate deleniti cupiditate ratione rerum, hic ipsam ut vel mollitia nulla tempora! Voluptatem temporibus beatae doloremque omnis tempora quasi vel maxime repudiandae facilis voluptatibus voluptates, laborum rem molestiae reprehenderit nihil.</p>
            </div>
            <img src="../static/asset/image/styleimage1.jpg" alt="">
        </div>

        <!-- Hot Deals Section -->
        <div id="sm-banner">
            <div class="banner-box">
                <h4>Spring Summer Collection</h4>
                <h2>Shop the trendiest trends now!</h2>
                <span>Buy 1 get 1 free</span>
                <button>Learn More</button>
            </div>
        </div>

        <!-- Best Seller Section -->
        <div id="best-seller">
            <div id="best-seller-left">
                <h2>Best Sellers</h2>
                <hr><br>
                <p>Explore our best-selling products loved by customers. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus illo velit inventore minima aliquam placeat, molestias eligendi maxime non in pariatur! Architecto eum doloribus dolore pariatur, quo ab voluptate nam placeat ad et molestiae reprehenderit velit voluptatibus cumque obcaecati? Laborum.</p>
                <div id="products">
                <?php
                    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                    
                    if (mysqli_connect_errno()) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    $query = "SELECT * FROM products WHERE productId IN (1, 21, 50)";
                    $result = $db->query($query);

                    if ($result->num_rows > 0) {
                        while($product = $result->fetch_assoc()){
                            echo '<div class="productcard">';
                            echo '<img src="' . htmlspecialchars($product["productImage"]) . '" alt="' . htmlspecialchars($product["productName"]) . '">';
                            echo '<div class="description">';
                            echo '<h3>' . htmlspecialchars($product["productName"]) . '</h3>';
                            echo '<p>' . htmlspecialchars($product["descrip"]) . '</p>';
                            echo '</div>';
                            echo '<h4>$' . number_format($product["price"], 2) . '</h4>';
                            echo '<a href="#"><i class="fa-solid fa-cart-shopping cart"></i></a>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No Products available</p>";
                    }

                    $db->close();
                ?>
                </div>
                <button><a href="mens.php">View More</a></button>
            </div>
            <img src="../static/asset/image/homeimage3.jpg" alt="" id="best-seller-img">
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