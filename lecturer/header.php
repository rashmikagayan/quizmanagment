<?php 
    $lectemail = $_SESSION['email'];

?>
<link rel="stylesheet" href="/lecturer/css/login.css">

<link rel="stylesheet" href="/lecturer/css/home.css">
<div class="topnav">
    <a class="active" href="index.php">Papers</a>
    <a onclick="openCreateNewPaper()">Create Paper</a>
    <a href="#contact">Contact</a>
    <a href="#about">About</a>
    <a href="index.php?logout">logout</a>
    <h3>
        <?php echo $lectemail; ?>
    </h3>
</div>
</head>

<body>


    <!-- Create new paper -->


    <div id="newPaperModel" class="modal">

        <form class="modal-content animate" action="index.php" method="GET">
            <div class="imgcontainer">
                <span onclick="document.getElementById('newPaperModel').style.display='none'" class="close" title="Close Modal">&times;</span>
                <h3>Enter Subject / Paper name to create a new paper</h3>
            </div>

            <div class="container">
                <label for="uname"><b>Paper name</b></label>
                <input type="text" placeholder="Enter Paper name" name="subjectname" required>
                <button type="submit" name="createnewpaper">Create New Paper</button>
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

        function openCreateNewPaper() {
            document.getElementById('newPaperModel').style.display = 'block'
        }
    </script>

    <!-- Create new paper -->