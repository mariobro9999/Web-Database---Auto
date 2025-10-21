<?php
session_start();
require_once "pdo.php";

//isset($_POST['delete']) &&
if ( isset($_POST['delete'])) {
  if (isset($_POST['auto_id']) && is_numeric($_POST['auto_id']) && $_POST['auto_id'] > 0) {
    //$autoid = $_POST['auto_id'];//new line
    $stmt = $pdo->prepare("DELETE FROM autos WHERE auto_id = :zip");
    $stmt->execute(array(':zip' => $_POST['auto_id']) );
    //['zip' => $autoid]
    //array(':zip' => $_POST['auto_id']) *goes in execute
    if( ! $stmt->rowCount() ) {
      $_SESSION['error'] = 'Deletion failed';
      header('Location: view.php');
      return;
    }
    else
    {
      $_SESSION['success'] = 'Record deleted';
      header('Location: view.php');
      return;
    }
  }
  else
  {
    $_SESSION['success'] = 'auto_id error';
    header('Location: view.php');
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
/*    "<? $row['auto_id'] ?>"    */
?>
<html>
<head>
<title>Edgar D Estrada - Autos</title>
</head>
<body>
<p>Confirm: Deleting <?= htmlentities($row['make'])," / ",
                         htmlentities($row['model'])," / ",
                         htmlentities($row['year'])," / ",
                         htmlentities($row['mileage']) ?>
</p>

<form method = "post">
<input type = "hidden" name = "auto_id" value =  "<?php echo htmlentities($row['auto_id']); ?>" >
<input type = "submit" name = "delete" value = "delete" >
<a href = "view.php">Cancel</a>
</form>
</body>
</html>
