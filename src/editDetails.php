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
        <div id="leftColumn">
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
            <h2><i class="fa-regular fa-pen-to-square"></i>Edit Product Details</h2>
            <?php
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                if ($db->connect_errno) {
                    $logger->logError(''. $db->connect_error);
                    echo "Error loading contents. Please try again later.";
                }

                // Form rendering starts here
                // Connect to the database
                $productId = htmlspecialchars($_GET['id']);

                $query = $db->prepare("SELECT * FROM products WHERE productId = ?");
                $query->bind_param("s", $productId);
                $query->execute();
                $result = $query->get_result();
                if ($result) {
                    $row = $result->fetch_assoc(); 
    
                    $categoryQuery = $db->prepare("SELECT * FROM categories WHERE categoryId = ?");
                    $categoryQuery->bind_param("s", $row['categoryId']);
                    $categoryQuery->execute();
                    $categoryResult = $categoryQuery->get_result();
                    $category = $categoryResult->fetch_assoc();
                    $gender = $category['gender'];
                    $clothCategory = $category['category'];

                    echo 
                    '<form action="editDetails.php?id=' . htmlspecialchars($productId) . '" method="POST" id="editDetailsForm" enctype="multipart/form-data">
                        <div>
                            <label for="productName">Product Name</label>
                            <input type="text" name="productName" value="'. htmlspecialchars($row["productName"]) . '"/>
                        </div>

                        <div>
                            <label for="descrip">Description</label>
                            <input type="text" name="descrip" value="'. htmlspecialchars($row["descrip"]) . '"/>
                        </div>

                        <div>
                            <label for="price">Price</label>
                            <input type="number" name="price" min="0" step="0.01" oninput="validity.valid||(value=\'\');" value="'. htmlspecialchars($row["price"]) . '"/>
                        </div>';

                    echo '<div>
                            <label for="category">Category</label>
                            <select name="category">';

                    // Set the options based on gender and default the selected one
                    if ($gender == 'Men') {
                        $categories = ['T-shirts', 'Polo', 'Long Sleeve', 'Shorts', 'Trousers'];
                    } else {
                        $categories = ['Tops', 'Dresses', 'Shirts & Blouses', 'Skirts', 'Shorts', 'Trousers'];
                    }

                    foreach ($categories as $option) {
                        // Check if this option matches the current category
                        $selected = ($option == $clothCategory) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($option) . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
                    }

                    echo '  </select>
                        </div>';

                    // Display the current image if available
                    $currentImage = htmlspecialchars($row['productImage']);
                    if ($currentImage) {
                        echo '
                        <div>
                            <label for="currentImage">Current Image</label>
                            <img src="'.$currentImage.'" alt="Current Product Image" style="width: 200px; height: 200px;"/>
                        </div>';
                    }

                    echo '
                    <div>
                        <label for="image">Upload New Image (Optional)</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                        <input type="submit">
                    </form>'; 
                }
                $db->close();

            ?>
            <?php
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                if ($db->connect_errno) {
                    $logger->logError(''. $db->connect_error);
                    echo "Error loading contents. Please try again later.";
                }

                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Sanitize inputs
                    $productName = htmlspecialchars(trim($_POST['productName']));
                    $descrip = htmlspecialchars(trim($_POST['descrip']));
                    $price = floatval($_POST['price']); // Convert to float
                    $productId = htmlspecialchars(trim($_GET['id'])); // Assuming you're getting productId from GET

                    $productImage = null; // Default value if no image is uploaded

                    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['image']['tmp_name'];
                        $fileName = $_FILES['image']['name'];
                        $fileSize = $_FILES['image']['size'];
                        $fileType = $_FILES['image']['type'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));

                        // Define a list of allowed file extensions
                        $allowedExts = ['jpg', 'jpeg', 'png'];

                        if (in_array($fileExtension, $allowedExts)) {
                            // Specify the directory to save the uploaded file
                            $uploadFileDir = '../static/asset/image/';

                            // Check if the directory exists, if not, create it
                            if (!is_dir($uploadFileDir)) {
                                mkdir($uploadFileDir, 0755, true); // Create directory with appropriate permissions
                            }

                            // Create a unique file name
                            $newFileName = $productName . '.' . $fileExtension; 
                            $dest_path = $uploadFileDir . $newFileName;

                            // Move the file to the specified directory
                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $productImage = $dest_path; // Update productImage with the new path
                                echo "File uploaded successfully<br>";
                            } else {
                                echo "Error moving the uploaded file.<br>";
                            }
                        } else {
                            echo "Upload failed. Only JPG, JPEG, and PNG files are allowed.<br>";
                        }

                        $stmt = $db->prepare("UPDATE products 
                                                SET productName = ?, descrip = ?, price = ?, productImage = ?
                                                WHERE productId = ?"); 
                        $stmt->bind_param("ssdsi", $productName, $descrip, $price, $productImage, $productId);
                    } else {
                        $stmt = $db->prepare("UPDATE products 
                                                SET productName = ?, descrip = ?, price = ?
                                                WHERE productId = ?"); 
                        $stmt->bind_param("ssdi", $productName, $descrip, $price, $productId);
                    }

                    // Execute the statement and check for errors
                    if ($stmt->execute()) {
                        echo "<p>Product details updated successfully!</p>";
                    } else {
                        echo "<p>Error updating product details: " . $stmt->error . "</p>";
                    }
                    
                    // Add alert will be redirecting back

                    sleep(5);
                    // Close the statement
                    $stmt->close();
                    header("Location: productManagement.php");
                    // header("Refresh: 0");
                }

                // Close the database connection
                $db->close();
            ?>
        </div>
    </div>

    <footer>
        <div>
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>
    </footer>
</body>
</html>