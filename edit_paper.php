<?php 
include 'src/connect.php';

if(!isset($_SESSION['id'])){
    header("Location: admin_login.php");
}
$lectemail = $_SESSION['email'];

$paperId = $_GET['get'];

// Create a paper
//$account = $db->createPaper("Theoritical Physics",$lectId);
?>

<!DOCTYPE html>
<html>
<head>
<style>

</style>
<link rel="stylesheet" href="/css/home.css">

</head>
<body>
<div class="topnav">
        <a href="admin.php">Papers</a>
        <a href="#news">News</a>
        <a href="#contact">Contact</a>
        <a href="#about">About</a>
        <h3>
            <?php echo $lectemail; ?>
        </h3>
    </div>


<div id="questions">
<?php 
    $questions = $db->editPaper($lectemail,$paperId);
    foreach ($questions as $question) {
        echo "
        <div class='question'>
            <div class='quest'><h2>".$question['qno']."</h2> <textarea >".$question['question']."</textarea></div>
            <div><h3>A.<h3> <textarea >".$question['ans1']."</textarea></div>
            <div><h3>B.<h3> <textarea >".$question['ans2']."</textarea></div>
            <div><h3>C.<h3> <textarea >".$question['ans3']."</textarea></div>
            <div><h3>D.<h3> <textarea >".$question['ans4']."</textarea></div> 
            <div class='answer'>Correct answer :<textarea row='1'>".$question['correct_answer']."</textarea></div>
        </div>";
    }
  ?>
  <div>
    <button class="button">Save</button>
    
  </div>
  
</div>



</body>
</html>
<script>
    
</script>