<?php
require"../coinapi_private/data.php";
$getaction = security($_POST['action']);
if(!isset($_SESSION['apiidentity'])) {
   die("n/a");
}
if(isset($_SESSION['apiidentity'])) {
   $EMAIL_INDENT = security($_SESSION['apiidentity']);
   $Query = mysql_query("SELECT email FROM accounts WHERE email='$EMAIL_INDENT'");
   if(mysql_num_rows($Query) == 0) {
      die("n/a");
   }
}
if(isset($_POST['speak'])) {
   $speak = security($_POST['speak']);
   if($speak!="") {
      if($udb_chathandle) {
         $sql = mysql_query("INSERT INTO chat (id,date,ip,email,username,message,status) VALUES ('','$date','$ip','$udb_email','$udb_chathandle','$speak','viewable')");
      }
   }
}
?>