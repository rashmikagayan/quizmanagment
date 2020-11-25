<?php 
include 'src/connect.php';

if(isset($_POST['student_join'])){
    $studentid = $_POST['studentid'];
    $password = $_POST['password'];
    $account = $db->joinExam($studentid,$password);
}
if(isset($_SESSION['id'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/student/css/login.css">
</head>
<body>

<h2>Student Login</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Enter Exam</button>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="student_login.php"  method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <h3>Enter Student Id and Exam Code to join the exam</h3>
    </div>

    <div class="container">
      <label for="uname"><b>Student Id</b></label>
      <input type="text" placeholder="Enter Student ID" name="studentid" required>

      <label for="psw"><b>Password</b></label>
      <input type="text" placeholder="Enter password" name="password" required>
        
      <button type="submit" name="student_join">Login</button>
      
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
