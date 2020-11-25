<?php
include 'src/connect.php';

if(isset($_POST['answers'])){
    $answerPaper = $_POST['answers'];
    $submitData = $_POST['submit'];
    $db->createPaper("test",$submitData[1]);
    foreach ($answerPaper as $answer) {
        $qno = $answer[0];
        $ansNum = $answer[1];
        $paperId = $submitData[0]; 
        $stdId = $submitData[1]; 
        $saveAnswer = $db->submitPaper($qno,$ansNum,$paperId,$stdId);
    }
    echo "test";
}
?>