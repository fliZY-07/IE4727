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
            <form action="" method="post">
                <table>
                    <tr>
                    <td style="width: 120px;"><label for="product-image">Product Image:</label></td>
                    <td style="width: 300px;"> <input type="file" id="product-image"><br></td>
                    </tr>

                    <tr>
                    <td><label for="product-name" >Product Name:</label></td>
                    <td> <input type="text" id="product-name"><br></td>
                    <td><span id="name-error"></span></td>
                    </tr>

                    <tr>
                    <td><label for="gender">Gender:</label></td>
                    <td> <select name="gender" id="">
                        <option value="Men">Men</option>
                        <option value="Women">Women</option>
                    </select><br></td>
                    </tr>

                    <tr>
                    <td><label for="product-category">Category:</label></td>
                    <td> <select name="product-category" id="">
                        <option value="Shirts">Shirts</option>
                        <option value="Jackets">Jackets</option>
                        <option value="Pants">Pants</option>
                        <option value="Underwear">Underwear</option>
                    </select><br></td>
                    </tr>

                    <tr>
                    <td><label for="product-price">Price:</label></td>
                    <td> <input type="number" id="product-price"><br></td>
                    <td><span id=price-error></span></td>
                    </tr>

                    <tr>
                    <td><label for="product-desc">Description:</label></td>
                    <td> <input type="text" id="desc-box"><br></td>
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
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Collect form data
                    $productName = htmlspecialchars($_POST['productName']);
                    $productCategory = htmlspecialchars($_POST['productCategory']);
                    $productPrice = htmlspecialchars($_POST['productPrice']);
                    $productDesc = htmlspecialchars($_POST['productDesc']);
                    
                    // can change the directiory based on where we store the files
                    $imageDir = 'uploads/';
                    $imagePath = $imageDir . basename($_FILES['productImage']['name']);
                    move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath);
                
                
                    $stmt = $conn->prepare("INSERT INTO products (productName, descrip, price, productImage, categoryId) 
                                            VALUES (?, ?, ?, ?, 
                                            (SELECT categoryId FROM categories WHERE category = ?))");
                    $stmt->bind_param("ssdss", $productName, $productDesc, $productPrice, $imagePath, $productCategory);
                
                    if ($stmt->execute()) {
                        echo "Product uploaded successfully!";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                
                    // Close connections
                    $stmt->close();
                    $db->close();
                }
            ?>
        </div>
    </div>
    <script>
    const submit = document.getElementById('submit-btn');
    const productImg = document.getElementById('product-image')
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


    function validateForm(){
    if (!productName || !productImg || !productPrice || !productDesc){
        alert("Please fill in all fields")
        event.preventDefault();
    } //check if all fields have been filled in

}

    function validateName(){
        const namePattern = /^[A-Za-z]+$/;
        if(!productName.value.match(namePattern)){
            nameError.textContent = "Name should only contain alphabets"
            e.preventDefault()
        } else{
            name.Error.textContent = ""
        }

    }


    function validatePrice(){
        if(productPrice <= 0){
            priceError.textContent = "Please key in a valid price"
            e.preventDefault();
        }else{
            priceError.textContent = ""
        }
    }

    function validateDesc(){
        if(productDesc.value.trim.length = 0){
            descError.textContent = "Description is required"
            e.preventDefault()
        } else{
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