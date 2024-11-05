<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Men's Product</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/men.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div id="searchbar">
            <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
            <input type="text" placeholder="search">
        </div>

        <div>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="mens.php" class="active">Men's</a></li>
                    <li><a href="womens.php">Women's</a></li>
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

        <div id="productsWrapper">
            <div id="filter">
                <h3><i class="fa-solid fa-filter"></i> Filter & Sort</h3>
                <form id="filter-sort">
                    <div class="filter-option">
                        <input type="checkbox" id="all" name="category" value="all">
                        <label for="all">All</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="tshirts" name="category" value="tshirts">
                        <label for="tshirts">T-shirts</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="polo" name="category" value="polo">
                        <label for="polo">Polo</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="longsleeve" name="category" value="longsleeve">
                        <label for="longsleeve">Long Sleeve</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="shorts" name="category" value="shorts">
                        <label for="shorts">Shorts</label>
                    </div>
                    <div class="filter-option">
                        <input type="checkbox" id="trousers" name="category" value="trousers">
                        <label for="trousers">Trousers</label>
                    </div>
                </form>
            </div>

            <div id="products">
                <?php
                    // Prepare the default query
                    $query = "SELECT * FROM products";

                    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                    // Check connection
                    if (mysqli_connect_errno()) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    $result = $db->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($product = $result->fetch_assoc()) {
                            echo '<div class="productcard">';
                            echo '<img src="' . htmlspecialchars($product["productImage"]) . '" alt="' . htmlspecialchars($product["productName"]) . '">';
                            echo '<div class="description">';
                            echo '<h2>' . htmlspecialchars($product["productName"]) . '</h2>';
                            echo '<p>' . htmlspecialchars($product["descrip"]) . '</p>';
                            echo '</div>';
                            echo '<div id="testing">';
                            echo '<h4>$' . number_format($product["price"], 2) . '</h4>';
                            echo '<i class="fa-solid fa-cart-shopping"></i>';
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
            <script>
                const checkboxes = document.querySelectorAll('input[name="category"]');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', applyFilters);
                });

                
                function applyFilters() {
                    const formData = new FormData(); // Create a new FormData object
                    const checkboxes = document.querySelectorAll('input[name="category"]:checked'); // Select all checked category checkboxes
    
                    // Append checked category values to FormData
                    checkboxes.forEach(cb => formData.append('categories[]', cb.value));
                    // Convert FormData to a plain object for easier logging
                    const categories = [];
                    for (const value of formData.getAll('categories[]')) {
                        categories.push(value);
                    }
                    fetch('./filter.php', {
                        method: 'POST',
                        body: JSON.stringify({ categories: categories }),
                        headers: {
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('products').innerHTML = data; // Update with the complete HTML
                    })
                    .catch(error => console.error('Error:', error));
                }

                function openForm() {
                    document.getElementById("myForm").style.display = "block";
                }

                function closeForm() {
                    document.getElementById("myForm").style.display = "none";
                }
            </script>
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