<?php 
include 'src/connect.php';

if(!isset($_SESSION['id'])){
    header("Location: student_login.php");
}
$studentId = $_SESSION['email'];

$paperId = $_GET['get'];

?>



<!DOCTYPE html>
<html>

<head>
    <style>

    </style>
    <link rel="stylesheet" href="/student/css/home.css">
    <!-- Ajax library -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div id="questions">

        <?php 
        $questions = $db->startPaper($paperId);
        $numOfQuestions = count($questions);
        foreach ($questions as $question) {
            $qno = $question['qno'];
            echo "
            <div class='question' id='question".$qno."' >
                <div class='quest'><h2>".$qno.".".$question['question']."</h2></div>
                <div><h3>I.<input type='radio' id='".$qno."1' name='".$qno."'  value='1'><label for='".$qno."1'>".$question['ans1']."</label></h3></div>
                <div><h3>II.<input type='radio' id='".$qno."2' name='".$qno."' value='2'><label for='".$qno."2'>".$question['ans2']."</label></h3></div>
                <div><h3>III.<input type='radio' id='".$qno."3' name='".$qno."'value='3'><label for='".$qno."3'>".$question['ans3']."</label></h3></div>
                <div><h3>IV.<input type='radio' id='".$qno."4' name='".$qno."' value='4'><label for='".$qno."4'>".$question['ans4']."</label></h3></div>
            </div>";
        }
  ?>
    </div>

        <div class="buttons">
            <!-- $paperId; -->
            <button class='savebutton' onclick="savePaper('<?php echo $paperId; ?>','<?php echo $studentId; ?>')" ;>Submit Paper</button>
            <button class='savebutton' onclick="home();">Cancel</button>

        </div>
</body>

</html>
<script src="/student/js/editpaper.js"></script>