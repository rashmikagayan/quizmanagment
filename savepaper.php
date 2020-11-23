<?php
include 'src/connect.php';

if(isset($_POST['questions'])){
    $questionPaperarr = $_POST['questions'];
    $deleteAllOldQuestions = $db->deleteAllQuestions($questionPaperarr[0][0]);
    foreach ($questionPaperarr as $question) {
        $saveQuestion = $db->saveEditedPaper($question);
    }
    
}
?>