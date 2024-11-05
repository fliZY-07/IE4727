<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Profile (View Info)</title>
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
                        <li><a href="profile.php" class="active">
                        <i class="fa-solid fa-circle-info"></i>&nbsp View Account Information</a></li><br>
                        <li><a href="updateInfo.php">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp Update Information</a></li><br>
                        <li><a href="orderTracking.php">
                        <i class="fa-solid fa-store"></i>&nbsp My Orders</a></li>
                    </ul>
                </nav>
            </div>

            <a href="userLogout.php">Logout &nbsp<i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
         
        <div id="rightColumn">
            <h2><i class="fa-solid fa-circle-info"></i>&nbsp View Account Information</h2>
            <?php
                    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                    
                    if (mysqli_connect_errno()) {
                        echo "Error: Could not connect to the database. Please try again later.";
                        exit;
                    }

                    $customerId = $_SESSION['customerId'];
                    $stmt = $db->prepare("SELECT * FROM users WHERE customerId = ?");
                    $stmt->bind_param("s", $customerId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $user = $result->fetch_assoc();
                        echo '<div>';
                        echo '<h2>Name: ' . htmlspecialchars($user["firstName"]) . ' ' . htmlspecialchars($user["lastName"]) . '</h2>';
                        echo '<h2>Email: ' . htmlspecialchars($user["email"]) . '</h2>';
                        echo '<h2>Phone Number: ' . htmlspecialchars($user["phoneNo"]) . '</h2>';
                        echo '<h2>Address: ' . htmlspecialchars($user["customerAddress"]) . '</h2>';
                        echo '</div>';
                    } else {
                        echo "<p>No details available</p>";
                    }

                    $stmt->close();
                    $db->close();
            ?>
            <a href="updateInfo.php"><button>Update Details</button></a>
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
    </footer>

</body>
</html>