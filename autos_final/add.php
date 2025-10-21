<?php
session_start();

require_once "pdo.php";
require_once "bootstrap.php";

if ( ! isset($_SESSION['user']) ) {
  die('ACCESS DENIED');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: view.php");
    return;
}

$make = isset($_POST['make']) ? $_POST['make'] : '';
$model = isset($_POST['model']) ? $_POST['model'] : '';
$year = isset($_POST['year']) ? $_POST['year'] : '';
$mileage = isset($_POST['mileage']) ? $_POST['mileage'] : " ";

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['mileage']) && isset($_POST['year'])) {
     if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
       //$failure = "Make is required";
       $_SESSION['error'] = "All fields are required";
       header("Location: add.php");
       return;
     }
     /*
     else if (strlen($_POST['model']) < 1) {
       //$failure = "Make is required";
       $_SESSION['error'] = "All fields are required";
       header("Location: add.php");
       return;
     }*/
     else if (!is_numeric($_POST['year'])) {
          //$failure = "Mileage and year must be numeric";
          $_SESSION['error'] = "Year must be an integer";
          header("Location: add.php");
          return;
     }
     else if (!is_numeric($_POST['mileage'])) {
          //$failure = "Mileage and year must be numeric";
          $_SESSION['error'] = "Mileage must be an integer";
          header("Location: add.php");
          return;
     }
     else {
         $stmt = $pdo->prepare('INSERT INTO autos(make, model, year, mileage) VALUES ( :mk, :mo, :yr, :mi)');
         $stmt->execute(array(
              ':mk' => $_POST['make'],
              ':mo' => $_POST['model'],
              ':yr' => $_POST['year'],
              ':mi' => $_POST['mileage']));
         //$success = "Record Inserted";
         $_SESSION['success'] = "added";
         header("Location: view.php");
         return;
     }
}

?>
<html>
<head>
<title>Edgar D Estrada - Autos</title>
</head>
<body style = "font-family: sans-serif;">
<h1>Tracking Autos for <?php echo htmlentities($_SESSION['user']) ?></h1>

<?php
if ( isset($_SESSION['error']) ){
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ){
  echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
  unset($_SESSION['success']);
}
?>

<form method = "POST">
<p>Make:
<input type = "text" name = "make" value = "<?= htmlentities($make) ?>" /> </p>
<p>Model:
<input type = "text" name = "model" value = "<?= htmlentities($model) ?>" /> </p>
<p>Year:
<input type = "text" name = "year" value = "<?= htmlentities($year) ?>" /></p>
<p>Mileage:
<input type = "text" name = "mileage" value = "<?= htmlentities($mileage) ?>" /></p>

<p><input type="submit" value="Add"></p>
<!-- <input type="submit" name="logout" value="Logout"> -->
<input type="submit" name="cancel" value="Cancel">
</form>

</body>
</html>
