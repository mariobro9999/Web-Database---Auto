<?php
session_start();

if ( ! isset($_SESSION['user']) ) {
  die('ACCESS DENIED');
}
//require_once "bootstrap.php";
require_once "pdo.php";
?>

<html>
<head>
<title>Edgar D Estrada - Autos</title>
</head>
<body style = "font-family: sans-serif;">
<h1>Automobiles</h1>

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

  //else {
    $stmt = $pdo->query("SELECT make, model, year, mileage, auto_id FROM autos");
    //
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<ul>';
        //echo '<li>'.htmlentities(implode("/", $row)).
        echo '<li>'.htmlentities($row['make'])." / ".htmlentities($row['model'])." / ".htmlentities($row['year'])." / ".htmlentities($row['mileage']).'</li>';
        echo (' <a href ="edit.php?auto_id='.$row['auto_id'].'">Edit</a> /');
        echo (' <a href ="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
        echo '</ul>';
    }
  //}

?>

<p><a href="add.php">Add New Entry</a></p>
<p><a href="logout.php">Logout</a></p>

</body>
</html>
