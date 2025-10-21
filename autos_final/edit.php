<?php
session_start();
//require_once "bootstrap.php";
require_once "pdo.php";

if ( ! isset($_SESSION['user']) ) {
  die('ACCESS DENIED');
}

if ( isset($_POST['cancel'] ) ) {
    header("Location: view.php");
    return;
}

//$make = isset($_POST['make']) ? $_POST['make'] : '';
//$model = isset($_POST['model']) ? $_POST['model'] : '';
//$year = isset($_POST['year']) ? $_POST['year'] : '';
//$mileage = isset($_POST['mileage']) ? $_POST['mileage'] : " ";

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['mileage']) && isset($_POST['year']) && isset($_POST['auto_id']) ) {
     if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
       //$failure = "Make is required";
       $_SESSION['error'] = "All fields are required";
       header("Location: edit.php?auto_id=".$_REQUEST['id']);
       return;
     } /*
     else if (strlen($_POST['model']) < 1) {
       //$failure = "Make is required";
       $_SESSION['error'] = "Model is required";
       header("Location: add.php");
       return;
     } */
     else if (!is_numeric($_POST['year'])) {
          //$failure = "Mileage and year must be numeric";
          $_SESSION['error'] = "Year must be an integer";
          header("Location: edit.php?auto_id=".$_REQUEST['id']);
          return;
     }
     else if (!is_numeric($_POST['mileage'])) {
          //$failure = "Mileage and year must be numeric";
          $_SESSION['error'] = "Mileage must be an integer";
          header("Location: edit.php?auto_id=".$_REQUEST['id']);
          return;
     }
    else {
         $sql = "UPDATE autos SET
                    make = :mk,
                    model = :mo,
                    year = :yr,
                    mileage = :mi
                 WHERE auto_id = :auto_id";
         $stmt = $pdo->prepare($sql);
         $stmt->execute(array(
              ':mk' => $_POST['make'],
              ':mo' => $_POST['model'],
              ':yr' => $_POST['year'],
              ':mi' => $_POST['mileage'],
              ':auto_id' => $_POST['auto_id']) );
         //$success = "Record Inserted";
         $_SESSION['success'] = "Record edited";
         header("Location: view.php");
         return;
    }
}

$stmt = $pdo->prepare("SELECT * FROM autos WHERE auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']) );
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row === false) {
  $_SESSION['error'] = 'Bad value for auto_id';
  header('Location: view.php');
  return;
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
$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
?>

<form method = "POST">
<p>Make:
<input type = "text" name = "make" value = "<?= $make ?>" /> </p>
<p>Model:
<input type = "text" name = "model" value = "<?= $model ?>" /> </p>
<p>Year:
<input type = "text" name = "year" value = "<?= $year ?>" /></p>
<p>Mileage:
<input type = "text" name = "mileage" value = "<?= $mileage ?>" /></p>
<input type = "hidden" name = "auto_id" id = "id" value = "<?php echo htmlentities($row['auto_id']) ?>" >
<p><input type="submit" value="Save">
<!-- <input type="submit" name="logout" value="Logout"> -->
<input type="submit" name="cancel" value="Cancel"></p>
</form>

</body>
</html>
