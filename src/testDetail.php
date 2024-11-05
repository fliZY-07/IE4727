<?php
session_start();
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mystyleloft";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch product details from the database
$sql = "SELECT productName, price FROM products WHERE id = 1"; // Replace `id = 1` with the desired product's ID
$result = $conn->query($sql);

// Fetch the product data
$product = $result->fetch_assoc();


if ($SERVER['REQUEST_METHOD'] == "POST"){
    $productId = 1;
    $size = $_POST["size"] ?? "";
    $color = $_POST["color"] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    $customerId = $_SESSION['customerId'];


    if(!$size || !$color || !$quantity){
        $errorMessage = "Please fill all required fields";
    }else {
        $stmt = $conn->prepare("INSERT INTO shoppingCart (customerID, productID, productSize, productColor, quantity) VALUES (?, ?, ?, ?, ?)");        $stmt->bind_param("iissi", $customerId, $productId, $size, $color, $quantity);

        if($stmt->execute()){
            $successMsg = "Product added to cart";
        } else{
            $errorMessage = "Error: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./productpage.css">
    <script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>

</head>
<body>
    <section id="header">
        <div id="logosearch">
            <a href="#"><img src="./assets/logo.png" class="logo" alt=""></a>
        <input type="text" placeholder="search">
        </div>
        <div>
            <ul id="navbar">
                <li><a href="blog.html"><i class="fa-solid fa-user"></i></a></li>
                <li><a href="about.html"><i class="fa-solid fa-heart"></i></a></li>
                <li><a href="contact.html"><i class="fa-solid fa-box"></i></a></li>
                <li><a href="cart.html"><i class="fa-solid fa-cart-shopping"></i></a></li>
            </ul>
        </div>
    </section>
    <div id="header2">
        <ul id="navbar2">
            <li><a href="index.html" class="active">Home</a></li>
            <li><a href="shop.html">About</a></li>
            <li><a href="blog.html">Men's</a></li>
            <li><a href="about.html">Women's</a></li>>
    </div>
    <div class="container">
        <div class="product">
            <div class="gallery">
                <img src="./assets/blackshirt.jpg" alt="" id="productImg">
                <div class="controls">
                    <span class="btn active"></span>
                    <span class="btn"></span>
                    <span class="btn"></span>
                </div>
            </div>
            <div class="details">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <h2>$<?php echo number_format($product['price'], 2); ?></h2>
                <h3>30% OFF</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate, consequuntur.</p>
                <form action="" method="post">
                    <div class="size-select">
                        <p>Size</p>
                        <label for="small">
                            <input type="radio" name="size" id="small" value="S">
                            <span>S</span>
                        </label>
                        <label for="medium">
                            <input type="radio" name="size" id="medium" value="M">
                            <span>M</span>
                        </label>
                        <label for="large">
                            <input type="radio" name="size" id="large" value="L">
                            <span>L</span>
                        </label>
                        <label for="x-large">
                            <input type="radio" name="size" id="x-large" value="XL">
                            <span>XL</span>
                        </label>
                    </div>

                    <div class="color-select">
                        <p>Color</p>
                        <label for="red">
                            <input type="radio" name="color" id="red" value="red">
                            <span class="color-red"></span>
                        </label>
                        <label for="green">
                            <input type="radio" name="color" id="green" value="green">
                            <span class="color-green"></span>
                        </label>
                        <label for="blue">
                            <input type="radio" name="color" id="blue" value="blue">
                            <span class="color-blue"></span>
                        </label>
                        <label for="purple">
                            <input type="radio" name="color" id="purple" value="purple">
                            <span class="color-purple"></span>
                        </label>
                    </div>

                    <div class="quantity-select">
                        <p>Quantity</p>
                        <input type="number" name="quantity" value="1">
                    </div>
                    <button>Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer">
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
    </footer>
</body>

<script>
    const productImg = document.getElementById("productImg");
    const btn = document.getElementsByClassName('btn');

    btn[0].onclick = function(){
        productImg.src = "./assets/greenshirt.jpg";

        for(bt of btn){
            bt.classList.remove('active');
        }
        this.classList.add("active");
    }
    btn[1].onclick = function(){
        productImg.src = "./assets/blackshirt.jpg";
        for(bt of btn){
            bt.classList.remove('active');
        }
        this.classList.add("active");
    }
    btn[2].onclick = function(){
        productImg.src = "./assets/red shirt.jpg";
        for(bt of btn){
            bt.classList.remove('active');
        }
        this.classList.add("active");
    }
</script>
</html>

<?php
// Close the database connection
$conn->close();
?>