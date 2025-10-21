<?php
require_once "pdo.php";
require_once "bootstrap.php";
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
   die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}
$failure = false;
$success = false;

$make = isset($_POST['make']) ? $_POST['make'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$mileage = isset($_POST['mileage']) ? $_POST['mileage'] : " ";

if ( isset($_POST['make']) && isset($_POST['mileage']) && isset($_POST['year'])) {
     if (strlen($_POST['make']) < 1) {
          $failure = "Make is required";
     }
     else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
          $failure = "Mileage and year must be numeric";
     }
      else {
         $stmt = $pdo->prepare('INSERT INTO autos(make, year, mileage) VALUES ( :mk, :yr, :mi)');
         $stmt->execute(array(
              ':mk' => $_POST['make'],
              ':yr' => $_POST['year'],
              ':mi' => $_POST['mileage']));
         $success = "Record Inserted";
      }
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Edgar D Estrada - Autos</title>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo htmlentities($_GET['name']) ?></h1>

<?php

if ( $failure !== false ) {
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}
if ( $success !== false) {
    echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
  }
?>

<form method = "POST">
<p>Make:
<input type = "text" name = "make" value = "<?= htmlentities($make) ?>" /> </p>
<p>Year:
<input type = "text" name = "year" value = "<?= htmlentities($year) ?>" /></p>
<p>Mileage:
<input type = "text" name = "mileage" value = "<?= htmlentities($mileage) ?>" /></p>

<p><input type="submit" value="Add"></p>
<input type="submit" name="logout" value="Logout">
</form>

<h1>Automobiles</h1>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<ul>';
    echo '<li>'.htmlentities(implode(" ", $row)).'</li>';
    echo '</ul>';

}

?>
</body>
</html>
