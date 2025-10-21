<?php
try{
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc', 'pma', '#passwrd');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //$stmt = $pdo->prepare("SELECT * FROM autos WHERE auto_id = :alias");
  //$stmt->execute(array(":alias" => $_GET['auto_id']));
} catch (PDOException $ex){
    $error_message = $ex->getMessage();
    echo $error_message;
    exit();
    //error_log("php_errors.php, SQL error=".$ex->getMessage());
}
//$row = $stmt->fetch(PDO::FETCH_ASSOC);
