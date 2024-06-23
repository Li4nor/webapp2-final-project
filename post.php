<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Post Page</title>

    <style>
      body {
        font-family: 'Times New Roman', Times, serif;
        display: flex;
        align-items: center;
        justify-content: center;
        background: black; 
        min-height: 100vh;
        margin: 0;
        padding: 0;
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

      .post-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border: 5px solid white;
        border-radius: 5px;
        backdrop-filter: blur(2px);
        font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS",
          sans-serif;
        font-size: 25px;
        color: white; 
      }

      #postDetails h3 {
        color: white;
        text-shadow: 1px 1px 2px orange, 0 0 5px white;
      }

      #postDetails p {
        color: white;
        text-align: justify;
        text-justify: inter-word;
      }

      h1 {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
      }
    </style>
  </head>

  <body>

    <video autoplay loop muted id="video-background">
        <source src="three.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="post-container">
      <h1>Post Page</h1>
      <div id="postDetails">
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
              if (isset($_GET['id'])) {
                  $id = $_GET['id'];

                  $query = "SELECT * FROM `posts` WHERE id = :id";
                  $statement = $pdo->prepare($query);
                  $statement->execute([':id' => $id]);

                  $post = $statement->fetch(PDO::FETCH_ASSOC);

                  if ($post) {
                      echo '<h3>Title: ' . $post['title'] . '</h3>';
                      echo '<p>Body: ' . $post['body'] . '</p>';
                  } else {
                      echo "No post found with ID $id!";
                  }
              } else {
                  echo "No post ID provided!";
              }
          }
      } catch (PDOException $e) {
          echo $e->getMessage();
      }
      ?>
      </div>
    </div>
  </body>
</html>
