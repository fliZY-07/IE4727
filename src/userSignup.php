<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../static/css/user.css">
    <script src="https://kit.fontawesome.com/e617f52b14.js" crossorigin="anonymous"></script>
    <script src="../static/js/userSignup.js" defer></script>
</head>
<body>
    <div class="wrapper">
        <h1>Signup</h1>
        <form method="POST" action="userSignup.php" id="signup-form">
            <div id="username">
                <label for="username-input" class="incorrect"><i class="fa-solid fa-user"></i></label>
                <input type="text" id='username-input' class="incorrect" placeholder='Username' name="username"/>
            </div>
            <span id="username-error-msg"></span>
            <div id="email">
                <label for="email-input"><i class="fa-solid fa-envelope"></i></label>
                <input type="email" id='email-input' placeholder='Email' name="email"/>
            </div>
            <span id="email-error-msg"></span>
            <div id="password">
                <label for="password-input"><i class="fa-solid fa-lock"></i></label>
                <input type="password" id='password-input' placeholder='Password' name="password"/>
            </div>
            <span id="password-error-msg"></span>
            <div id="repeat-password">
                <label for="repeat-password"><i class="fa-solid fa-lock"></i></label>
                <input type="password" id='repeat-password-input' placeholder='Repeat Password'/>
            </div>
            <span id="repeat-password-error-msg"></span>
            <button type='submit'>Submit</button>
        </form>
        <p>Already have an account? <a href="userLogin.php">Login Here!</a></p>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";

                $db = new mysqli('localhost', 'root', '', 'myStyleLoft');
                            
                if (mysqli_connect_errno()) {
                    echo "Error: Could not connect to the database. Please try again later.";
                    exit;
                }

                $email = $_POST["email"];
                $username = $_POST["username"];

                $searchQuery = $db->prepare("SELECT * FROM users WHERE email = ?");
                $searchQuery->bind_param("s", $email);
                $searchQuery->execute();
                $result = $searchQuery->get_result();

                if ($result->num_rows > 0) {
                    echo "You have already registered an account.";
                    exit;
                } else {
                    $password = $_POST["password"];
                    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
                    $query = "INSERT INTO users (email, lastName, passwordHash) VALUES (?, ?, ?)";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param("sss", $email, $username, $passwordHashed);

                    if ($stmt->execute()) {
                        echo "Sign up Successfully!";
                    } else {
                        // echo "Error: " . $stmt->error;
                        echo "Error signing up. Please contact our staff.";
                    }
                    $searchQuery->close();
                    $stmt->close();
                    $db->close();
                }
            }
        ?>
    </div>
</body>
</html>