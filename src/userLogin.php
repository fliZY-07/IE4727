<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../static/css/user.css">
    <script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <h1>Login</h1>
        <form method="post" action="userLogin.php">
        <div>
            <label for="email-input"><i class="fa-solid fa-envelope"></i></label>
            <input type="email" id='email-input' placeholder='Email' name="email"/>
        </div>
        <div>
            <label for="password-input"><i class="fa-solid fa-lock"></i></label>
            <input type="password" id='password-input' placeholder='Password' name="password"/>
        </div>
        <button type='submit'>Login</button>
        </form>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Display posted data for debugging purposes (remove in production)
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                session_start();

                // Database connection
                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
    
                // Check database connection
                if ($db->connect_errno) {
                    echo "Error: Could not connect to the database. Please try again later.";
                    exit;
                }

                // Sanitize and retrieve input values
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Query to select the user with the given email
                $query = "SELECT * FROM users WHERE email = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                // Check if user exists
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    // Verify the password
                    if (password_verify($password, $user['passwordHash'])) {
                        echo "Login successfully!";
                        $_SESSION['customerId'] = $user['customerId']; 
                        header("Location: home.php");
                        exit;
                    } else {
                        echo "Please check your password.";
                    }
                } else {
                    echo "No account found with that email address.";
                }
                // Close statements and database connection
                $stmt->close();
                $db->close();
            }
        ?>
        <p>New Here? <a href="userSignup.php">Signup Here!</a></p>
    </div>
</body>
</html>