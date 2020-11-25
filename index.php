<!DOCTYPE html>
<html>
<head>
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

</style>
</head>
<body>

<h2>Welcome to Quiz!</h2>
<h3>Tell us who you are and continue..</h3>
<h4>I am a</h4>
<button class="button" onclick="redirect('student/')" >Student</button>
<button class="button" onclick="redirect('lecturer/')" >Lecturer</button>

</body>
</html>
<script>
    function redirect(loc){
        window.location.href = loc;
    }
</script>