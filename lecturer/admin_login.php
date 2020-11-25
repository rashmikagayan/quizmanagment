<?php 
include 'src/connect.php';

if(isset($_POST['lecturer_login'])){
    $email = $_POST['lect_email'];
    $pass = $_POST['lect_psw'];
    $account = $db->lectLogin($email,$account);
}
if(isset($_SESSION['id'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/lecturer/css/login.css">
</head>
<body>

<h2>Lecturer Login</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="admin_login.php"  method="post">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="lect_email" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="lect_psw" required>
        
      <button type="submit" name="lecturer_login">Login</button>
      
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
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
