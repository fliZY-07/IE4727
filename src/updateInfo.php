<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Profile (Update Info)</title>
<link rel="stylesheet" href="../static/css/general.css">
<link rel="stylesheet" href="../static/css/profile.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<?php include './utils/loginStatus.php' ?>

<div>
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
        <div id="leftColumn">
            <div>
                <nav id="profile">
                    <ul>
                        <li><a href="profile.php">
                        <i class="fa-solid fa-circle-info"></i>&nbsp View Account Information</a></li><br>
                        <li><a href="updateInfo.php"  class="active">
                        <i class="fa-solid fa-pen-to-square"></i>&nbsp Update Information</a></li><br>
                        <li><a href="orderTracking.php">
                        <i class="fa-solid fa-store"></i>&nbsp My Orders</a></li>
                    </ul>
                </nav>
            </div>

            <a href="userLogout.php">Logout &nbsp<i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
         
        <div id="rightColumn">
            <h2><i class="fa-solid fa-pen-to-square"></i>&nbsp Update Information</h2>
            <form action="updateInfo.php" method="POST" id="profile-form">
                <div>
                    <label for="firstName">First Name</label>
                    <input type="text" placeholder='Your first name here' name="firstName"/>
                </div>

                <div>
                    <label for="lastName">Last Name</label>
                    <input type="text" placeholder="Your las name here" name="lastName"/>
                </div>

                <div>
                    <label for="email">Email</label>
                    <input type="email" placeholder='example@email.com' name="email"/>
                </div>

                <div>
                    <label for="phone">Phone Number</label>
                    <input type="tel" placeholder='XXXX-XXXX' name="phone" pattern="[0-9]{4}-[0-9]{4}"/>
                </div>

                <div>
                    <label for="address">Address</label>
                    <input type="text" placeholder='Your Address here' name="address"/>
                </div>

                <br>

                <input type="submit">

            </form>

            <div>
                <?php
                    include './utils/errorLogger.php';

                    // Initialize the ErrorLogger with a log file
                    $logger = new ErrorLogger("./logging/error_log.txt");

                    // Check if the request method is POST
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Check if the required POST fields are set
                        $requiredFields = ["firstName", "lastName", "email", "phone", "address"];
                        foreach ($requiredFields as $field) {
                            if (empty($_POST[$field])) {
                                $logger->logError("Missing required field: $field");
                            }
                        }

                        // Database connection
                        $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                        // Check database connection
                        if ($db->connect_errno) {
                            $logger->logError("Database connection failed: " . $db->connect_error);
                            echo "Error loading current page.";
                            exit;
                        }

                        // Prepare statement
                        $stmt = $db->prepare("UPDATE users SET 
                                                firstName = ?, 
                                                lastName = ?, 
                                                email = ?, 
                                                phoneNo = ?, 
                                                customerAddress = ? 
                                                WHERE customerId = ?");

                        if (!$stmt) {
                            $logger->logError("Error preparing statement: " . $db->error);
                            $db->close();
                            exit;
                        }

                        // Bind parameters
                        $customerId = $_SESSION["customerId"];
                        $stmt->bind_param(
                            "sssssi", 
                            $_POST["firstName"],
                            $_POST["lastName"],
                            $_POST["email"],
                            $_POST["phone"],
                            $_POST["address"],
                            $customerId
                        );

                        // Execute statement
                        if ($stmt->execute()) {
                            echo "User information updated successfully!";
                        } else {
                            $logger->logError("Error executing statement: " . $stmt->error);
                        }

                        // Clean up
                        $stmt->close();
                        $db->close();
                        header("location: ./profile.php");
                }
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

</body>
</html>