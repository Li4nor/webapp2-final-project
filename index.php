<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: posts.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Georgia, "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000;
        }

        #video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
        }

        .login-container {
            width: 300px;
            padding: 20px;
            border: 5px solid black;
            background-color: rgba(255, 255, 255, 0.5);
            text-align: center;
        }

        .login-container h2 {
            color: black;
            font-size: 40px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-bottom: 3px solid orange;
            background-color: transparent;
            color: white;
            font-size: 16px;
            outline: none;
        }

        .login-container input[type="text"]::placeholder,
        .login-container input[type="password"]::placeholder {
            color: white;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: orange;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
            transition: transform 0.2s;
        }

        .login-container button:active {
            transform: scale(0.95);
        }

        .login-container button:hover {
            background-color: black;
        }
    </style>
</head>
<body>
    <video autoplay loop muted id="video-background">
        <source src="wan.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="login-container">
        <h2>Northwings</h2>
        <form id="loginForm" class="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="input-box">
                <input type="text" id="username" placeholder="Enter username" name="username" required>
            </div>
            <div class="input-box">
                <input type="password" id="password" placeholder="Enter password" name="password" required>
            </div>
            <button type="submit" id="submit">Login</button>
        </form>
    </div>

</body>
</html>
