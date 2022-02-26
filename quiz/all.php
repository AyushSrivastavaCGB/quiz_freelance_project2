<?php

require_once dirname(__DIR__ ).'/classes/DB.php';

$db = DB::getInstance();
$data = $db->getAllExercise();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>All Excercise</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Exercises</h2>
 
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th>Exercise no.</th>
        <th>Heading</th>
        <th>Exercise</th>
      </tr>
    </thead>
    <tbody>

    <?php foreach($data as $exercise){ ?>
      <tr>
        <td><?php echo $exercise->id; ?></td>
        <td><?php echo $exercise->heading; ?></td>
        <td><?php echo $exercise->exercise; ?></td>
      </tr>
    <?php } ?>
     
    </tbody>
  </table>
</div>

</body>
</html>
