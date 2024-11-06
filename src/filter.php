<?php
$json = file_get_contents('php://input');
$data = json_decode($json, true); // Convert JSON to associative array
if (isset($data['categories']) && isset( $data['gender'])) {
    $db = new mysqli('localhost', 'root', '', 'myStyleLoft');

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Error: Could not connect to the database. Please try again later.";
        exit;
    }

    $categories = $data['categories'];
    $gender = $data['gender'];
    $query = ($gender === 'Men') ? "SELECT * FROM products WHERE categoryId in (1, 2, 3, 4, 5)" :
                                    "SELECT * FROM products WHERE categoryId in (6, 7, 8, 9, 10)";
    $finalQuery = $query; // Initialize with the default query

    $categoryPairs = ($gender === 'Men') ? [ 'tshirts' => 1, 'polo' => 2, 'longsleeve' => 3, 'shorts' => 4, 'trousers' => 5] :
                                            [ 'tops' => 6, 'dresses' => 7, 'shirtsNBlouses' => 8, 'skirts' => 9, 'shorts' => 10, 'trousers' => 11];

    if (in_array('all', $categories)) {
        // If 'all' is present, select all products (already set in $finalQuery)
        $finalQuery = $query; 
    } else {
        // Map the selected categories to their corresponding IDs
        $categoryIds = array_map(function($category) use ($categoryPairs) {
            return isset($categoryPairs[$category]) ? $categoryPairs[$category] : null;
        }, $categories);

        // Filter out null values (in case an invalid category was provided)
        $categoryIds = array_filter($categoryIds);

        // Create a comma-separated string of category IDs for the WHERE clause
        if (!empty($categoryIds)) {
            $categoryIdsList = implode(',', $categoryIds);
            $finalQuery = "SELECT * FROM products WHERE categoryId IN ($categoryIdsList)";
        }
    }

    // Execute the final query
    $result = $db->query($finalQuery);

    $output = '';
    if ($result && $result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
            // $output .= '<div class="productcard">';
            $output .= '<div class="productcard"  data-productId="'.$product["productId"].'"
                                                            data-productImage="'.htmlspecialchars($product["productImage"]).'"
                                                            data-productName="'.htmlspecialchars($product["productName"]).'"
                                                            data-description="'.htmlspecialchars($product["descrip"]).'"
                                                            data-price="'.number_format($product["price"], 2).'"
                                                            onclick="openForm(this)">';
            $output .= '<img src="' . htmlspecialchars($product["productImage"]) . '" alt="' . htmlspecialchars($product["productName"]) . '">';
            $output .= '<div class="description">';
            $output .= '<h2>' . htmlspecialchars($product["productName"]) . '</h2>';
            $output .= '<p>' . htmlspecialchars($product["descrip"]) . '</p>';
            $output .= '</div>';
            $output .= '<div id="testing">';
            $output .= '<h4>$' . number_format($product["price"], 2) . '</h4>';
            $output .= '<a><i class="fa-solid fa-cart-shopping cart"></i></a>';
            $output .= '</div>';
            $output .= '</div>';
        }
    } else {
        echo "<p>No Products available</p>";
    }

    // Close the database connection
    $db->close();
    // header('Content-Type: application/json');
    // echo json_encode($output);
    echo $output;
    exit;
}