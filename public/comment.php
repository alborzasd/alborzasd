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
    // header("Location: ./index.php?post_id=$post_id");
    die();
}
$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


$sql = "SELECT * FROM comment WHERE post_id = :post_id";
$statement = $connection->prepare($sql);
$statement->bindParam(":post_id", $post->id);
$statement->execute();
$comment_table = $statement->fetchAll();


$connection = null;
?>

<div class="post">


    <div class="post-title comment-title">
        <h1>
            Comments (<?php echo count($comment_table); ?>)
        </h1>
    </div>


    <div class="post-content">

        <form action="./comment_inserter.php" method="post" class="comments-form">
            <input type="text" name="post_id" value="<?php echo $post->id ?>" style="display:none;">

            <div class="comment-fullName">
                <label for="fullName">your name <span class="required-mark">*</span></label>
                <input type="text" name="comment_name" id="fullName" required placeholder="your name...">
            </div>
            <div class="comment-message">
                <label for="message">your comment <span class="required-mark">*</span></label>
                <textarea id="message" name="comment_content" required placeholder="add a comment ..."></textarea>
            </div>
            <div class="comment-submit">
                <input id="submit" type="submit" value="Add">
            </div>
        </form>

        <div class="comments-list">
            <?php foreach($comment_table as $index => $comment): ?>
            <div class="comments-item">
                <div>
                    <i class="fas fa-user"></i>
                    <span class="author-name"><?php echo htmlentities($comment->name); ?></span>
                </div>
                <div class="date-time">
                    <div>
                        <i class="far fa-calendar-alt"></i>
                        <span><?php echo $comment->date; ?></span>
                    </div>
                    <div>
                        <i class="far fa-clock"></i>
                        <span><?php echo $comment->time; ?></span>
                    </div>
                </div>
                <div><?php echo htmlentities($comment->content); ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>