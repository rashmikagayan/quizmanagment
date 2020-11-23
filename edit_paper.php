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
    <!-- Ajax library -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
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
        $numOfQuestions = count($questions);
        foreach ($questions as $question) {
        echo "
        <div class='question'>
            <div class='quest'><h2>".$question['qno'].".</h2> <textarea id='quest".$question["qno"]."' >".$question['question']."</textarea></div>
            <div><h3>A.<h3> <textarea id='quest".$question["qno"]."ans1' >".$question['ans1']."</textarea></div>
            <div><h3>B.<h3> <textarea id='quest".$question["qno"]."ans2' >".$question['ans2']."</textarea></div>
            <div><h3>C.<h3> <textarea id='quest".$question["qno"]."ans3' >".$question['ans3']."</textarea></div>
            <div><h3>D.<h3> <textarea id='quest".$question["qno"]."ans4' >".$question['ans4']."</textarea></div> 
            <div class='answer'>Correct answer :<textarea id='quest".$question["qno"]."crctansw' row='1'>".$question['correct_answer']."</textarea></div>
        </div>";
    }
    echo "<div>
        <!-- $paperId; -->
        <button class='button' onclick='savePaper($numOfQuestions)';>Save</button>
    </div>";
  ?>


    </div>



</body>

</html>
<script>
    function savePaper(qno) {
        var paperid = "<?php echo $paperId ?>";
        var questions = Array();
        for (let i = 1; i <= qno; i++) {
            console.log(i);
            var quest = document.getElementById("quest" + i + "").value;
            var answer1 = document.getElementById("quest" + i + "ans1").value;
            var answer2 = document.getElementById("quest" + i + "ans2").value;
            var answer3 = document.getElementById("quest" + i + "ans3").value;
            var answer4 = document.getElementById("quest" + i + "ans4").value;
            var crctAns = document.getElementById("quest" + i + "crctansw").value;
            var question = [paperid, i, quest, answer1, answer2, answer3, answer4, crctAns];

            questions.push(question);

        }
        console.log(questions);
        $.post('savepaper.php', {
                questions: questions
            },
            function(response) {
                alert(response);
            });
    }
</script>