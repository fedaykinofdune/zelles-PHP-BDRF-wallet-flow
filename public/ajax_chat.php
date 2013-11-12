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
$Query = mysql_query("SELECT id, email, username, message FROM chat WHERE status='viewable' ORDER BY id DESC LIMIT 100");
while($Row = mysql_fetch_assoc($Query)) {
   $db_chat_id = $Row['id'];
   $db_chat_email = $Row['email'];
   $db_chat_username = $Row['username'];
   $db_chat_message = $Row['message'];
   if($udb_chathandle==$db_chat_username){ $char_color = '0489B1'; } else { $char_color = '0B3861'; }
   $db_chat_message = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" target='_blank'>\\0</a>", $db_chat_message);
   preg_match_all('/(http|https):\/\/[^ ]+(\.gif|\.jpg|\.jpeg|\.png)/',$db_chat_message, $matches);
   if($udb_email=="TheAdminsEmail@address.com") {
      $newcomment = '<tr>
                        <td valign="top" align="right" style="color: #'.$char_color.'; font-size: 12px; font-weight: bold; padding: 3px;"><a onclick="formban('.$db_chat_email.');return false;" style="text-decoration: none; color: #000000; font-size: 12px;">[BAN]</a><a onclick="formdel('.$db_chat_id.');return false;" style="text-decoration: none; color: #000000; font-size: 12px;">[X]</a>'.$db_chat_username.': </td>
                        <td valign="top" style="width: 100%; font-size: 12px; padding: 3px;">'.$db_chat_message.'</td>
                     </tr>';
   } else {
      $newcomment = '<tr>
                        <td valign="top" align="right" style="color: #'.$char_color.'; font-size: 12px; font-weight: bold; padding: 3px;">'.$db_chat_username.': </td>
                        <td valign="top" style="width: 100%; font-size: 12px; padding: 3px;">'.$db_chat_message.'</td>
                     </tr>';
   }
   if(isset($matches[0][0])) {
      if($matches[0][0]!="") {
         $newcomment .= '<tr>
                            <td valign="top" style="padding: 3px; "></td>
                            <td valign="top" style="padding: 3px; "><a href="'.$matches[0][0].'" target="_blank"><img src="'.$matches[0][0].'" border="0" style="height: 70px;"></a></td>
                         <tr>';
      }
   }
   $compilecomments = $newcomment.$compilecomments;
}
echo '<table style="width: 100%;">';
echo $compilecomments;
echo '</table>';
/*
if($udb_email=="TheAdminsEmail@address.com") {
   $Query = mysql_query("SELECT message FROM chat WHERE id='241'");
   while($Row = mysql_fetch_assoc($Query)) {
      echo '<div style="height: 50px;"></div>'.$Row['message'];
   }
}
*/
?>