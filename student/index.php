<?php 
include 'src/connect.php';

if(isset($_GET['logout'])){
    $db->logout();
    header("Refresh:0");
}

if(!isset($_SESSION['id'])){
    header("Location: student_login.php");
}
$studentId = $_SESSION['email'];


if(isset($_GET['deletepaper'])){
    // echo $_GET['deletepaper'];
    $db->deletePaper($_GET['deletepaper']);
}

if(isset($_GET['joinPaper'])){
    $subjcetCode = $_GET['subjcetCode'];
    $db->joinPaper($subjcetCode,$studentId);

}




// Create a paper
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/student/css/home.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <?php include 'papers.php'; ?>

</body>

</html>