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
    <button onclick="addQuestion(3);">Add</button>

    <div id="questions">
        <?php 
        $questions = $db->editPaper($lectemail,$paperId);
        $numOfQuestions = count($questions);
        foreach ($questions as $question) {
            $qno = $question['qno'];
        echo "
        <div class='question' id='question'>
            <div class='quest'><h2>".$qno.".</h2> <textarea id='quest".$qno."' >".$question['question']."</textarea></div>
            <div><h3>A.<h3> <textarea id='quest".$qno."ans1' >".$question['ans1']."</textarea></div>
            <div><h3>B.<h3> <textarea id='quest".$qno."ans2' >".$question['ans2']."</textarea></div>
            <div><h3>C.<h3> <textarea id='quest".$qno."ans3' >".$question['ans3']."</textarea></div>
            <div><h3>D.<h3> <textarea id='quest".$qno."ans4' >".$question['ans4']."</textarea></div> 
            <div><h3>Correct answer :answer<textarea id='quest".$qno."crctansw' row='1'>".$question['correct_answer']."</textarea></div>
                <div><button onclick='deleteQuest($qno)'>Delete</button></div>
        </div>";
    }
    echo "<div>
        <!-- $paperId; -->
        <button class='savebutton' onclick='savePaper()';>Save</button>
    </div>";
  ?>
    </div>
</body>

</html>
<script>
    function savePaper() {
        var qno = $("div[class*='question']").length;
        var paperid = "<?php echo $paperId ?>";
        var questions = Array();
        for (let i = 1; i <= qno; i++) {
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
                alert("Successfully edited");
                location.reload();
            });
    }

    function addQuestion() {
        var qno = $("div[class*='question']").length + 1;
        const qstDiv = document.createElement("div");
        qstDiv.setAttribute("id", "question");
        qstDiv.setAttribute("class", "question");

        const questioDiv = document.createElement("div");
        questioDiv.setAttribute("class", "quest");

        var h = document.createElement("H2");
        var t = document.createTextNode(qno + ".")
        h.appendChild(t);
        var textarea = document.createElement("textarea");
        textarea.setAttribute("id", 'quest' + qno);
        questioDiv.appendChild(h);
        questioDiv.appendChild(textarea);
        qstDiv.appendChild(questioDiv);

        // Answers 1
        var Numbers = ["A.", "B.", "C.", "D.", "Correct Answer:"]
        var ids = ["ans1", "ans2", "ans3", "ans4", "crctansw"]
        for (let i = 0; i < Numbers.length; i++) {
            var normQuest = document.createElement("div");
            var h = document.createElement("H3");
            var t = document.createTextNode(Numbers[i])
            h.appendChild(t);
            var textarea = document.createElement("textarea");
            var textareaId = "quest" + qno + ids[i];
            textarea.setAttribute("id", textareaId);
            normQuest.appendChild(h);
            normQuest.appendChild(textarea);
            qstDiv.appendChild(normQuest);
        }
        var delteBtn = document.createElement("button");
        var t = document.createTextNode("Delete")
        delteBtn.appendChild(t);
        delteBtn.setAttribute("onclick", "deleteQuest(" + qno + ");");
        var delteBtnHolder = document.createElement("div");

        delteBtnHolder.appendChild(delteBtn);
        qstDiv.appendChild(delteBtnHolder);
        document.getElementById("questions").appendChild(qstDiv);
    }

    function deleteQuest(qno) {
        $('#questions div:nth-child(' + qno + ')').remove();
    }
</script>