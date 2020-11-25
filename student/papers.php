<!DOCTYPE html>
<html>
<head>
<style>
#table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#table td, #table th {
  border: 1px solid #ddd;
  padding: 8px;
}

#table tr:nth-child(even){background-color: #f2f2f2;}

#table tr:hover {background-color: #ddd;}

#table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>

<table id="table">
  <tr>
    <th>Subject</th>
    <th>Paper Id</th>
    <th>Results</th>
    <th colspan="2">Action</th>
  </tr>
  <?php 
    $myPapers = $db->fetchPapers($studentId);
    foreach ($myPapers as $paper) {
        echo "<tr>
            <td>".$paper['subject_name']."</td>
            <td>".$paper['paper_id']."</td>
            <td>5</td>
            <td><a href='joinexam.php?get=".$paper['paper_id']."'>Start</a></td>
            <td><a href='index.php?=".$paper['paper_id']."'>Results</a></td>
        </tr>";
    }
  ?>
</table>

</body>
</html>
