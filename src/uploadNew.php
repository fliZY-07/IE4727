<!DOCTYPE html>
<html lang="en">
<head> 
<title>My Style Loft - Upload New Product</title>
<link rel="stylesheet" href="../static/css/adminPanelGeneral.css">
<link rel="stylesheet" href="../static/css/uploadNew.css">
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
                    <li><a href="productManagement.php">
                        <i class="fa-solid fa-shirt"></i>Product Management</a></li>
                    <li><a href="orderManagement.php">
                        <i class="fa-solid fa-list-check"></i> Order Management</a></li>
                    <li><a href="uploadNew.php" class="active">
                        <i class="fa-solid fa-square-plus"></i> Upload New Product</a></li>
                </ul>
            </nav>
        </div>

        <div id="rightColumn">
            <h2><i class="fa-solid fa-square-plus"></i> Upload New Product</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                    <td style="width: 120px;"><label for="product-image">Product Image:</label></td>
                    <td style="width: 300px;"> <input type="file" id="product-image" name="productImage"><br></td>
                    </tr>
                    <tr>
                    <td><label for="product-name" >Product Name:</label></td>
                    <td> <input type="text" id="product-name" name="productName"><br></td>
                    <td><span id="name-error"></span></td>
                    </tr>
                    <tr>
                    <td><label for="product-category">Category:</label></td>
                    <td> <select name="productCategory" id="product-category">
                        <option value="T-shirts">Men T-Shirts</option>
                        <option value="polo">Men Polo</option>
                        <option value="Long Sleeve">Men Long Sleeve</option>
                        <option value="Shorts">Men Shorts</option>
                        <option value="Trousers">Men Trousers</option>
                        <option value="Tops">Women Tops</option>
                        <option value="Dresses">Women Dresses</option>
                        <option value="Shirts & Blouses">Womens Shirts & Blouses</option>
                        <option value="Skirts">Women Skirts</option>
                        <option value="Shorts">Women Shorts</option>
                        <option value="Trousers">Women Trousers</option>
                    </select><br></td>
                    </tr>
                    <tr>
                    <td><label for="product-price">Price:</label></td>
                    <td> <input type="number" id="product-price" name="productPrice" min="0" step="0.01" oninput="validity.valid||(value='');"><br></td>
                    <td><span id="price-error"></span></td>
                    </tr>
                    <tr>
                    <td><label for="product-desc">Description:</label></td>
                    <td> <input type="text" id="desc-box" name="productDesc"><br></td>
                    <td><span id="description-error"></span></td>
                    </tr>
                </table>
                <button type="submit" id="submit-btn">Upload Product</button>
            </form>

            <?php
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

                if ($db->connect_errno) {
                    $logger->logError(''. $db->connect_error);
                    echo "Error loading contents. Please try again later.";
                }
                
                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Collect and sanitize form data, with isset checks
                    $productName = isset($_POST['productName']) ? htmlspecialchars($_POST['productName']) : '';
                    $productCategory = isset($_POST['productCategory']) ? htmlspecialchars($_POST['productCategory']) : '';
                    $productPrice = isset($_POST['productPrice']) ? floatval($_POST['productPrice']) : 0;
                    $productDesc = isset($_POST['productDesc']) ? htmlspecialchars($_POST['productDesc']) : '';
                
                    // Check if required fields are not empty
                    if (empty($productName) || empty($productCategory) || empty($productPrice) || empty($productDesc)) {
                        echo "All fields are required.";
                    } else {
                        // Check if the file input exists and if the file was uploaded without errors
                        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
                            // Define upload directory and path
                            $imageDir = '../static/uploads/';
                            $imagePath = $imageDir . basename($_FILES['productImage']['name']);
                            
                            // Attempt to move the uploaded file
                            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath)) {
                                // Prepare statement to insert product details
                                $stmt = $db->prepare("INSERT INTO products (productName, descrip, price, productImage, categoryId) 
                                                      VALUES (?, ?, ?, ?, 
                                                      (SELECT categoryId FROM categories WHERE category = ?))");
                                $stmt->bind_param("ssdss", $productName, $productDesc, $productPrice, $imagePath, $productCategory);
                
                                // Execute and check for errors
                                if ($stmt->execute()) {
                                    echo "Product uploaded successfully!";
                                } else {
                                    echo "Error: " . $stmt->error;
                                }
                
                                // Close statement
                                $stmt->close();
                            } else {
                                echo "Failed to upload image. Ensure the upload directory has the correct permissions.";
                            }
                        } else {
                            echo "Image file is required and must be a valid file.";
                        }
                    }
                }
                
                // Close connections
                $db->close();
            ?>
        </div>
    </div>
    <script>
        const submit = document.getElementById('submit-btn');
        const productImg = document.getElementById('product-image');
        const productName = document.getElementById('product-name');
        const productPrice = document.getElementById("product-price");
        const productDesc = document.getElementById('desc-box');
        const nameError = document.getElementById('name-error');
        const priceError = document.getElementById('price-error');
        const descError = document.getElementById('description-error');

        productName.addEventListener('input', validateName);
        productPrice.addEventListener('input', validatePrice);
        productDesc.addEventListener("input", validateDesc);
        submit.addEventListener('click', validateForm);

        function validateForm(event) {
            // Check if all fields have values
            if (!productName.value.trim() || !productImg.value || !productPrice.value || !productDesc.value.trim()) {
                alert("Please fill in all fields");
                event.preventDefault();
            } else {
                // Run individual validations
                validateName();
                validatePrice();
                validateDesc();

                // Check if there are any error messages
                if (nameError.textContent || priceError.textContent || descError.textContent) {
                    event.preventDefault();
                }
            }
        }

        function validateName() {
            const namePattern = /^[A-Za-z\s]+$/; // Allows alphabets and spaces
            if (!productName.value.match(namePattern)) {
                nameError.textContent = "Name should only contain alphabets and spaces";
            } else {
                nameError.textContent = "";
            }
        }

        function validatePrice() {
            if (productPrice.value <= 0) {
                priceError.textContent = "Please enter a valid price";
            } else {
                priceError.textContent = "";
            }
        }

        function validateDesc() {
            if (productDesc.value.trim().length === 0) {
                descError.textContent = "Description is required";
            } else {
                descError.textContent = "";
            }
        }

    </script>

    <footer>
        <div>
            Copyright &copy; the Style LOFT
            <br>by Joshua & ZhiYi<br>
        </div>
    </footer>
</body>
</html>