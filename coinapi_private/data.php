<?php
session_start();
error_reporting(0);
function kryptkey($word) {
   $salt = sha1(md5('SuperRandomSalt'.$word.'DifferentRandomSalt'));
   $encrypy_word = md5(sha1(md5($word.$salt)).$salt);
   return $encrypy_word;
}
function security($value) {
   if(is_array($value)) {
      $value = array_map('security', $value);
   } else {
      if(!get_magic_quotes_gpc()) {
         $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
      } else {
         $value = htmlspecialchars(stripslashes($value), ENT_QUOTES, 'UTF-8');
      }
      $value = str_replace("\\", "\\\\", $value);
   }
   return $value;
}
function satoshisize($satoshitize) {
   return rtrim(rtrim(sprintf("%.8f", $satoshitize), "0"), ".");
}
function pubkeygen() {
   $keycode_length = rand(33,52);
   $keycode_charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
   $register_keycode = '';
   $keycode_count = strlen($keycode_charset);
   while ($keycode_length--) {
      $register_keycode .= $keycode_charset[mt_rand(0, $keycode_count-1)];
   }
   return $register_keycode;
}

$date = date("n/j/Y");;
$ip = $_SERVER['REMOTE_ADDR'];

// START banned IPs due to attempted theft abuse
if($ip=="72.190.53.101") { die('<b style="font-size: 20px; color: #FF0000;">Abuse is frowned upon! You are not allowed to access this server, doing so is illegal.</b>'); exit; }
$cut_ip = substr($ip, 0, 9);
if($cut_ip=="220.255.1") { die('<b style="font-size: 20px; color: #FF0000;">Abuse is frowned upon! You are not allowed to access this server, doing so is illegal.</b>'); exit; }
$cut_ip = substr($ip, 0, 9);
if($cut_ip=="220.255.2") { die('<b style="font-size: 20px; color: #FF0000;">Abuse is frowned upon! You are not allowed to access this server, doing so is illegal.</b>'); exit; }
// END banned IPs due to attempted theft abuse

$current_page_uri = $_SERVER["REQUEST_URI"];


$datab_host = "localhost";
$datab_user = "username";
$datab_pass = "password";
$datab_name = "database_name";


$dbconn = mysql_connect($datab_host,$datab_user,$datab_pass);
if(!$dbconn) { die("Server Connection Error"); }
$dbc = mysql_select_db($datab_name);
if(!$dbc) { die("Server Connection Error"); }

if(isset($_SESSION['apiidentity'])) {
   $EMAIL_INDENT = security($_SESSION['apiidentity']);
   $Query = mysql_query("SELECT email FROM accounts WHERE email='$EMAIL_INDENT'");
   if(mysql_num_rows($Query) != 0) {
      $Query = mysql_query("SELECT id, email, banned, pub_key, priv_key FROM accounts WHERE email='$EMAIL_INDENT'");
      while($Row = mysql_fetch_assoc($Query)) {
         $udb_id = $Row['id'];
         $udb_email = $Row['email'];
         $udb_banned = $Row['banned'];
         $udb_pub_key = $Row['pub_key'];
         $udb_priv_key = $Row['priv_key'];
      }
      $Query = mysql_query("SELECT handle FROM chathandle WHERE email='$udb_email'");
      if(mysql_num_rows($Query)!=0) {
         $Query = mysql_query("SELECT handle FROM chathandle WHERE email='$udb_email'");
         while($Row = mysql_fetch_assoc($Query)) {
            $udb_chathandle = $Row['handle'];
         }
      } else {
         $create_handle = 'UserHandle'.$udb_id;
         $sql = mysql_query("INSERT INTO chathandle (id,email,handle) VALUES ('','$udb_email','$create_handle')");
         header("Location: index.php");
      }
      if($udb_banned=="1") {
         session_destroy();
         setcookie("identa", '', time()-1000);
         setcookie("identa", '', time()-1000, '/');
         setcookie("identb", '', time()-1000);
         setcookie("identb", '', time()-1000, '/');
         header("Location: index.php");
      }
   } else {
      session_destroy();
      setcookie("identa", '', time()-1000);
      setcookie("identa", '', time()-1000, '/');
      setcookie("identb", '', time()-1000);
      setcookie("identb", '', time()-1000, '/');
      header("Location: index.php");
   }
} else {
   if(isset($_COOKIE["identa"])) {
      if(isset($_COOKIE["identb"])) {
         $updatec_identa = security($_COOKIE["identa"]);
         $updatec_identb = security($_COOKIE["identb"]);
         $Query = mysql_query("SELECT email FROM accounts WHERE pub_key='$updatec_identa' and priv_key='$updatec_identb'");
         if(mysql_num_rows($Query) != 0) {
            $Query = mysql_query("SELECT email FROM accounts WHERE pub_key='$updatec_identa' and priv_key='$updatec_identb'");
            while($Row = mysql_fetch_assoc($Query)) {
               $updatec_email = $Row['email'];
               $_SESSION['apiidentity'] = $updatec_email;
               header("Location: $current_page_uri");
            }
         }
      }
   }
}
?>