<?php

//-------------------------------------------------------------------
// <initialize-input>

if (isset($_POST["post_id"]))
    $post_id = $_POST["post_id"];
else {
    header("Location: ./index.php");
    die();
}

$name = "Unknown";
if (isset($_POST["comment_name"]))
    $name = $_POST["comment_name"];

if (isset($_POST["comment_content"]))
    $content = $_POST["comment_content"];
else {
    header("Location: ./index.php?post_id=$post_id");
    die();
}

date_default_timezone_set('Iran');
$date = date("F d, Y"); // F:month name  d:day number, Y:year 4 digit
$time = date("H:i"); // H:24houe i:minute

// </initialize-input>
//-------------------------------------------------------------------



//-------------------------------------------------------------------
// <stablish connection>

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

// </stablish-connectnio>
//-------------------------------------------------------------------



//-------------------------------------------------------------------
// <insert-comment>

try {
    $sql = "INSERT INTO comment (name, content, date, time, post_id)
    VALUES(:name, :content, :date, :time, :post_id)";
    $statement = $connection->prepare($sql);

    $statement->bindParam(":name", $name);
    $statement->bindParam(":content", $content);
    $statement->bindParam(":date", $date);
    $statement->bindParam(":time", $time);
    $statement->bindParam(":post_id", $post_id);

    $statement->execute();
}
catch (PDOException $e) {
    echo "Failed to insert data: <br/>" . $e->getMessage();
    // header("Location: ./index.php?post_id=$post_id");
    die();
}

// </insert-comment>
//-------------------------------------------------------------------


header("Location: ./index.php?post_id=$post_id");
$connection = null;