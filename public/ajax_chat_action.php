<?php
require"../coinapi_private/data.php"; 
set_time_limit(0);
$getaction = security($_POST['action']);
if(!isset($_SESSION['apiidentity'])) {
   header("Location: index.php");
}
if(isset($_SESSION['apiidentity'])) {
   $EMAIL_INDENT = security($_SESSION['apiidentity']);
   $Query = mysql_query("SELECT email FROM accounts WHERE email='$EMAIL_INDENT'");
   if(mysql_num_rows($Query) == 0) {
      header("Location: index.php");
   }
}
if($udb_email!=="TheAdminsEmail@address.com") {
   header("Location: index.php");
   die('access denied.');
   exit;
}
if($EMAIL_INDENT!=="TheAdminsEmail@address.com") {
   header("Location: index.php");
   die('access denied.');
   exit;
}
if(isset($_GET['del'])) {
   $del = security($_GET['del']);
   $sql = mysql_query("UPDATE chat SET status='hide' WHERE id='$del'");
   echo $del.' was hidden.';
}
if(isset($_GET['ban'])) {
   $ban = security($_GET['ban']);
   $sql = mysql_query("UPDATE accounts SET banned='1' WHERE email='$ban'");
   echo $ban.' was banned.';
}
?>