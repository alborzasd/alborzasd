<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alborzasd";

try {
    // a database name is mandatory for PDO
    $dsn = "mysql:host=$servername;dbname=$dbname";
    $connection = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

if (isset($_GET["post_id"])) {
    $specific_post = true; // this boolean used to show comment section for a specific post

    $sql = "SELECT * FROM post WHERE id = :post_id";
    $statement = $connection->prepare($sql);
    $statement->bindParam('post_id', $_GET["post_id"]);
    $statement->execute();
    $post_table = $statement->fetchAll();

    if(empty($post_table)) {
        header("Location: ./index.php");
        die();
    }

    $sql = "SELECT * FROM post_category WHERE id = :category_id";
    $statement = $connection->prepare($sql);
    $statement->bindParam('category_id', $post_table[0]->category_id);
    $statement->execute();
    $post_category_table = $statement->fetchAll();

    // $sql = "SELECT * FROM post_paragraph WHERE post_id = :post_id";
    // $statement = $connection->prepare($sql);
    // $statement->bindParam('post_id', $_GET["post_id"]);
    // $statement->execute();
    // $post_paragraph_table = $statement->fetchAll();
}
else {
    $specific_post = false;

    $sql = "SELECT * FROM post";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $post_table = $statement->fetchAll();

    $sql = "SELECT * FROM post_category";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $post_category_table = $statement->fetchAll();

    // $sql = "SELECT * FROM post_paragraph";
    // $statement = $connection->prepare($sql);
    // $statement->execute();
    // $post_paragraph_table = $statement->fetchAll();
}

$connection = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/e4e3837ccd.js" crossorigin="anonymous"></script>
    <title>alborzasd.ir</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <!-- ----------------------------------------------------------- -->
    <!-- <header> -->
    <div class="background">
    <header id="js-header">
        <div class="container header">
            <!-- <a href="#" class="logo">Hello, world</a> -->

            <div class="search-container">
                <form action="#">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>

            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="navigation" id="js-nav">
                <li class="active"><a href="./">Home</a></li>
                <li><a href="#">Articles</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </header>
    </div>
    <!-- </header> -->
    <!-- ----------------------------------------------------------- -->

    <!-- ----------------------------------------------------------- -->
    <!-- <main-content> -->
    <div class="container main">

        <!-- <column0-side> -->
        <aside class="col-side">
            <div class="post">
                <div class="post-img">
                    <img src="assets/empty_prof_03.svg" />
                </div>
                <div class="post-title">
                    <h1>About Me</h1>
                </div>
                <div class="post-content">
                    <p>
                        Hello world.
                        <br/>
                        My name is Alborz Asadi and I'm studying Computer Enginerring
                        at Razi University.
                        <br/>
                        I will share my experience here.
                        <br/>
                        You can find my projects on
                        <a class="button-link" href="https://www.github.com/alborzasd">github</a>
                        <br/>
                        Also you can contact me by email or telegram.
                        <br/>
                        <i class="far fa-envelope"></i> alborzasd@gmail.com
                        <br/>
                        <i class="fab fa-telegram-plane"></i> @alborzasd
                    </p>
                </div>
            </div>
        </aside>
        <!-- <column0-side> -->

        <!-- <column1> -->
        <div class="col">

            <?php foreach($post_table as $index => $post): ?>
            <?php
                $post_background_color = "#e3f2fd"; // default
                foreach($post_category_table as $i => $post_category) {
                    if ($post->category_id == $post_category->id) {
                        $post_background_color = $post_category->hex_color;
                    }
                }
            ?>
            <div class="post">
                <div 
                    class="post-title" 
                    style="background-color:<?php echo $post_background_color; ?>">
                    <h1>
                        <a href="?post_id=<?php echo $post->id; ?>"><?php echo $post->title; ?></a>
                    </h1>
                    <div class="post-info">
                        <div>
                            <i class="fas fa-user"></i>
                            <span><?php echo $post->author; ?></span>
                        </div>
                        <div>
                            <i class="far fa-calendar-alt"></i>
                            <span><?php echo $post->date; ?></span>
                        </div>
                        <div>
                            <i class="far fa-clock"></i>
                            <span><?php echo $post->time; ?></span>
                        </div>
                        <div>
                            <i class="fas fa-tag"></i>
                            <span class="tags"><?php echo $post->tag; ?></span>
                        </div>
                    </div>
                </div>
                <div class="post-content">
                    <?php 
                        if($specific_post) {
                            include("./content/posts/$post->filename"); 
                        }
                        else {
                            include("./content/posts/$post->intro_filename");
                        }
                    ?>

                    <?php if($specific_post == false): ?>
                    <a 
                        class="post-link"
                        href="?post_id=<?php echo $post->id; ?>"
                        style="background-color: <?php echo $post_background_color; ?>">
                        Continue to read
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <?php endif ?>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php
                if($specific_post == true) {
                    include("comment.php");
                } 
            ?>

        </div>
        <!-- </column1> -->

    </div>
    <!-- </main-content> -->
    <!-- ----------------------------------------------------------- -->

    <!-- ----------------------------------------------------------- -->
    <!-- <footer> -->
    <footer>
        <div class="container footer">
            <ul class="social">
                <li>
                    <a href="https://www.instagram.com/alborzasd" target="_blank" class="instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.github.com/alborzasd" target="_blank" class="github">
                        <i class="fab fa-github"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.t.me/alborzasd" target="_blank" class="telegram">
                        <i class="fab fa-telegram-plane"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.twitter.com" target="_blank" class="twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
            </ul>
            <div class="copyright">
                <p>
                    Developed by 
                    <a href="https://www.alborzasd.ir" target="_blank">@alborzasd</a>
                </p>
                <p>FREE TO COPY</p>
            </div>
        </div>
    </footer>
    <!-- </footer> -->
    <!-- ----------------------------------------------------------- -->
    
    <script src="script.js"></script>

</body>
</html>