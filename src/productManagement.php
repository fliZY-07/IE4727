<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Product Management</title>
<link rel="stylesheet" href="../static/css/adminPanelGeneral.css">
<link rel="stylesheet" href="../static/css/productManagement.css">
<script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <a href="#"><img src="../static/asset/image/logo.png" class="logo" alt="logo"></a>
        <h2>ADMIN PANEL</h2>
    </header>


    <div id="wrapper">
        <div>
            <nav>
                <ul>
                    <li><a href="productManagement.php" class="active">
                        <i class="fa-solid fa-shirt"></i>Product Management</a></li>
                    <li><a href="orderManagement.php">
                        <i class="fa-solid fa-list-check"></i> Order Management</a></li>
                    <li><a href="uploadNew.php">
                        <i class="fa-solid fa-square-plus"></i> Upload New Product</a></li>
                </ul>
            </nav>
        </div>

        <div id="rightColumn">
            <h2><i class="fa-solid fa-shirt"></i>Product Management</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product's Name</th>
                        <th>Description</th>
                        <th>Current Price ($)</th>
                        <th>Category</th>
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
                $query = "SELECT * FROM products JOIN categories ON products.categoryId = categories.categoryId";
                $result = $db->query($query);
            
                if ($result) {
                    while ($row = $result->fetch_assoc()) {  
                        echo "<tr>";
                        echo '<td>'.$row['productId'].'</td>';
                        echo '<td><img src="'.$row['productImage'].'"></td>';
                        echo '<td>'.htmlspecialchars($row['productName']).'</td>';
                        echo '<td>'.htmlspecialchars($row['descrip']).'</td>';
                        echo '<td>$'.number_format($row['price'], 2).'</td>';
                        echo '<td>'.htmlspecialchars($row['gender']).', '.htmlspecialchars($row['category']).'</td>';
                        echo '<td><button type="button" id="edit" onclick="window.location.href=\'editDetails.php?id=' . $row['productId'] . '\'">Edit</button>';
                        echo '<button type="button" class="delete" data-productId = "'.$row['productId'].'">Delete</button></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found.</td></tr>";
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
    <script src="../static/js/productManagement.js" defer></script>
</body>
</html>