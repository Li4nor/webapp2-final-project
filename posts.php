<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            overflow: hidden; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            background: black; 
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
            object-fit: cover;
        }

        .posts-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px 20px;
            border: 2px solid orange;
            border-radius: 5px;
            backdrop-filter: blur(3px);
            background-color: rgba(255, 255, 255, 0.5); 
            text-align: center; 
        }

        ul {
            padding: 0;
            list-style-type: none;
        }

        li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: whitesmoke;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        li:hover {
            background-color: orange;
            transform: translateY(-3px);
        }

        .posts-container li a {
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 18px;
            font-family: 'Arial', sans-serif;
            outline: none; 
        }

        .posts-container li a:hover {
            color: white;
            text-decoration: underline; 
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
            object-fit: cover; 
        }

        h1 {
            color: black;
        }
    </style>
</head>
<body>

    <video autoplay loop muted id="video-background">
        <source src="two.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

  
    <div class="posts-container">
        <h1>Menu</h1>
        <ul id="postLists">
            <?php
            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM posts WHERE userId = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
</html>
