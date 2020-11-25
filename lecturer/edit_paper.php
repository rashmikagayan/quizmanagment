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
    <link rel="stylesheet" href="/lecturer/css/home.css">
    <!-- Ajax library -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div id="questions">

        <?php 
        $questions = $db->editPaper($lectemail,$paperId);
        $numOfQuestions = count($questions);
        foreach ($questions as $question) {
            $qno = $question['qno'];
        echo "
        <div class='question' id='question".$qno."' >
            <div class='quest'><h2>".$qno.".</h2> <textarea id='quest".$qno."' >".$question['question']."</textarea></div>
            <div><h3>I.<h3> <textarea id='quest".$qno."ans1' >".$question['ans1']."</textarea></div>
            <div><h3>II.<h3> <textarea id='quest".$qno."ans2' >".$question['ans2']."</textarea></div>
            <div><h3>III.<h3> <textarea id='quest".$qno."ans3' >".$question['ans3']."</textarea></div>
            <div><h3>IV.<h3> <textarea id='quest".$qno."ans4' >".$question['ans4']."</textarea></div> 
            <div><h3>Correct answer :<textarea id='quest".$qno."crctansw' row='1'>".$question['correct_answer']."</textarea></div>
                <div><button  onclick='deleteQuest($qno)'>Delete</button></div>
        </div>";
    }
  ?>
    </div>

        <div class="buttons">
            <!-- $paperId; -->
            <button class='savebutton' onclick="savePaper('<?php echo $paperId; ?>')" ;>Save Paper</button>
            <button class='savebutton' onclick="addQuestion(3);">Add Question</button>
            <button class='savebutton' onclick="home();">Cancel</button>

        </div>
</body>

</html>
<script src="/lecturer/js/editpaper.js"></script>