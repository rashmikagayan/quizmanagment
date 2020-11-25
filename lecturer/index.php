<?php 
include 'src/connect.php';

if(isset($_GET['logout'])){
    $db->logout();
    header("Refresh:0");
}

if(!isset($_SESSION['id'])){
    header("Location: admin_login.php");
}
$lectemail = $_SESSION['email'];


if(isset($_GET['deletepaper'])){
    // echo $_GET['deletepaper'];
    $db->deletePaper($_GET['deletepaper']);
}

if(isset($_GET['createnewpaper'])){
    $subjectName = $_GET['subjectname'];
    $db->createPaper($subjectName,$lectemail);

}




// Create a paper
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/lecturer/css/home.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <?php include 'papers.php'; ?>

</body>

</html>