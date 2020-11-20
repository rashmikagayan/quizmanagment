<?php 
include 'src/connect.php';

if(!isset($_SESSION['id'])){
    header("Location: admin_login.php");
}
$lectId = $_SESSION['email'];


// Create a paper
//$account = $db->createPaper("Theoritical Physics",$lectId);
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/home.css">
</head>

<body>

    <div class="topnav">
        <a class="active" href="#papers">Papers</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
        <h3>
            <?php echo $lectId; ?>
        </h3>
    </div>

    <?php include 'papers.php'; ?>

</body>

</html>