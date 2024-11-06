<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Women's Product</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/product.css">
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
                    <li><a href="womens.php" class="active">Women's</a></li>
                </ul>
            </nav>
        </div>

        <div>
            <ul id="iconbar">
                <li><a href="userLogin.php"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="orderTracking.php"><i class="fa-solid fa-box"></i></a></li>
                <li><a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </header>


    <div id="wrapper">
        <!-- banner -->
        <div class="banner-box">
            <h4>Spring Summer Collection</h4>
            <h2>Shop the trendiest trends now!</h2>
            <span>Buy 1 get 1 free</span>
            <button>Learn More</button>
        </div>


        <div class="form-popup" id="myForm">
        <form class="form-container" method="POST" action="./addToCart.php">
            <div class="productInfo">
                <img src="#" alt="Product Image" id="popupImage">
                <div>
                    <input type="hidden" value="" name="productId" id="popupProductId">
                    <h1 id="popupName">Proudct Name</h1>
                    <p id="popupDescrip">Product Description</p>
                    
                    <label for="size">Size: </label>
                    <select name="size">
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    <br>
                    <label for="quantity">Quantity: </label>
                    <input type="number" min="1" step="1" name="quantity" value="1">
                    <p id="popupPrice">Unit Price</p>
                </div>
            </div>
            <div class="buttons">
            <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
            <button type="submit" class="btn">Add to cart</button>
            </div>
        </form>
        </div>

        <div id="productsWrapper">
            <div id="filter">
                <h3><i class="fa-solid fa-filter"></i> Filter & Sort</h3>
                <form id="filter-sort">
                    <div class="filter-option">
                        <input type="checkbox" id="all" name="category" value="all">
                        <label for="all">All</label>
                        <input type="hidden" value="Women" name="gender">
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="dresses" name="category" value="dresses">
                        <label for="dresses">Dresses</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="shirtsNBlouses" name="category" value="shirtsNBlouses">
                        <label for="shirtsNBlouses">Shirts & Blouses</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="skirts" name="category" value="skirts">
                        <label for="skirts">Skirst</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="Shorts" name="category" value="shorts">
                        <label for="shorts">Shorts</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="trousers" name="category" value="trousers">
                        <label for="trousers">Trousers</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="tops" name="category" value="tops">
                        <label for="tops">Tops</label>
                    </div>
                </form>
            </div>

            <div id="products">
                <?php
                    // Prepare the default query
                    $query = "SELECT * FROM products WHERE categoryId in (6, 7, 8, 9, 10, 11)";

                    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                    // Check connection
                    if (mysqli_connect_errno()) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    $result = $db->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($product = $result->fetch_assoc()) {
                            echo '<div class="productcard"  data-productId="'.$product["productId"].'"
                                                            data-productImage="'.htmlspecialchars($product["productImage"]).'"
                                                            data-productName="'.htmlspecialchars($product["productName"]).'"
                                                            data-description="'.htmlspecialchars($product["descrip"]).'"
                                                            data-price="'.number_format($product["price"], 2).'"
                                                            onclick="openForm(this)">';
                            echo '<img src="' . htmlspecialchars($product["productImage"]) . '" alt="' . htmlspecialchars($product["productName"]) . '">';
                            echo '<div class="description">';
                            echo '<h2>' . htmlspecialchars($product["productName"]) . '</h2>';
                            echo '<p>' . htmlspecialchars($product["descrip"]) . '</p>';
                            echo '</div>';
                            echo '<div id="testing">';
                            echo '<h4>$' . number_format($product["price"], 2) . '</h4>';
                            echo '<a><i class="fa-solid fa-cart-shopping cart"></i></a>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No Products available</p>";
                    }

                    // Close the database connection
                    $db->close();
                    ?>
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
    <script src="../static/js/women.js" defer></script>
</body>
</html>