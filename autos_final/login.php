<?php // Do not put any HTML above this line
session_start();

require_once "bootstrap.php";
require_once "pdo.php";

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data
$require = '@';

date_default_timezone_set('America/Chicago');
$date = date('d-M-Y H-i-s e');


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['email']);//logout current unser
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        //$failure = "Email and password are required";
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    }
    if (strpos($_POST['email'], $require) == false) {
        //$failure = "Email must have an at-sign (@)";
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to auto.php
            error_log("[".$date."] "."Login Success ".$_POST['who']."\n", 3, "E:/Programs/XAMPP/htdocs/autos_redirect/php_errors.php");
            $_SESSION['user'] = $_POST['email'];
            $_SESSION['success'] = "Logged in.";
            header("Location: view.php?name=".urlencode($_POST['email']));
            return;
        } else {
            error_log("[".$date."] "."Login fail ".$_POST['email']."$check\n", 3, "E:/Programs/XAMPP/htdocs/autos_redirect/php_errors.php");
            //$failure = "Incorrect password";
            $_SESSION['error'] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<title>Edgar D Estrada - Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
/*
if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
}*/

if ( isset($_SESSION['error']) ){
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ){
  echo('<p style="color: red;">'.htmlentities($_SESSION['success'])."</p>\n");
  unset($_SESSION['success']);
}
?>
<form method="POST">
<label for="email">User Name</label>
<input type="text" name="email" id="nam" value = "<?= htmlentities($email) ?>" /><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723" value = "<?= htmlentities($password) ?>" /><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find a password hint
in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
