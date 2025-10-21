<!DOCTYPE html>
<html>
<head>
<title>Edgar D Estrada - Autos Database</title>
<?php require_once "bootstrap.php";
      require_once "pdo.php";?>
</head>
<body>
<div class="container">
<h1>Welcome to Autos Database</h1>

<p>
<a href="login.php">Please log in</a>
</p>
<p>
Attempt to go to
<a href="view.php">view.php</a> without logging in - it should fail with an error message.
</p>
<p>
Attempt to go to
<a href="add.php">add.php</a> without logging in - it should fail with an error message.
</p>

<?php
  $stmt = $pdo->query("SELECT * FROM autos");
  $row = $stmt->fetch();
    if ( !$row ) {
      echo ("No rows found");
    }
  if ( isset($_SESSION['error']) ){
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ){
    echo('<p style="color:green">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
  }

  else {
    $stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<ul>';
        //echo '<li>'.htmlentities(implode("/", $row)).
        echo '<li>'.htmlentities($row['make'])." / ".htmlentities($row['model'])." / ".htmlentities($row['year'])." / ".htmlentities($row['mileage']).'</li>';
        echo '</ul>';
    }
  }
?>

</div>
</body>
