<?php 
    $studentid = $_SESSION['email'];

?>
<link rel="stylesheet" href="/student/css/login.css">

<link rel="stylesheet" href="/student/css/home.css">
<div class="topnav">
    <a class="active" href="index.php">Papers</a>
    <a onclick="joinPaper()">Join Exam</a>
    <a href="index.php?logout">logout</a>
    <h3>
        <?php echo $studentid; ?>
    </h3>
</div>
</head>

<body>
  <!-- Create new paper -->


  <div id="newPaperModel" class="modal">

<form class="modal-content animate" action="index.php" method="GET">
    <div class="imgcontainer">
        <span onclick="document.getElementById('newPaperModel').style.display='none'" class="close" title="Close Modal">&times;</span>
        <h3>Enter Paper Code to join exam</h3>
    </div>

    <div class="container">
        <label for="uname"><b>Paper Code</b></label>
        <input type="text" placeholder="Enter Paper Code" name="subjcetCode" required>
        <button type="submit" name="joinPaper">Join Paper</button>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('newPaperModel').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
</form>
</div>

<script>
// Get the modal
var modal = document.getElementById('newPaperModel');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function joinPaper() {
    document.getElementById('newPaperModel').style.display = 'block'
}
</script>

<!-- Create new paper -->

    