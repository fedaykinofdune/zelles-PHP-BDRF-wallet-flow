<?php
require"../coinapi_private/data.php";
if(!$udb_email) {
   $getaction = security($_POST['action']);
   if($getaction=="login") {
      $login_email = security($_POST['email']);
      $login_password = security($_POST['password']);
      if($login_email) {
         if($login_password) {
            $login_password = substr($login_password, 0, 30);
            $login_password = md5($login_password);
            $Query = mysql_query("SELECT email FROM accounts WHERE email='$login_email'");
            if(mysql_num_rows($Query) == 1) {
               $Query = mysql_query("SELECT email, password, status, banned, pub_key, priv_key FROM accounts WHERE email='$login_email'");
               while($Row = mysql_fetch_assoc($Query)) {
                  $login_db_email = $Row['email'];
                  $login_db_password = $Row['password'];
                  $login_db_status = $Row['status'];
                  $login_db_banned = $Row['banned'];
                  $login_db_pub_key = $Row['pub_key'];
                  $login_db_priv_key = $Row['priv_key'];
                  if($login_password==$login_db_password) {
                     if($login_db_status=="1") {
                        if($login_db_banned!="1") {
                           $_SESSION['apiidentity'] = $login_db_email;
                           setcookie("identa",$login_db_pub_key,time() + (10 * 365 * 24 * 60 * 60));
                           setcookie("identb",$login_db_priv_key,time() + (10 * 365 * 24 * 60 * 60));
                           echo '<script type="text/javascript">
                                    setTimeout(function(){
                                       $("#pagemenu").load("ajax_menu.php");
                                       $("#pagebody").load("ajax_home.php");
                                    }, 1000);
                                 </script>
                                 Logged in! Please wait one second.';
                        } else {
                           echo 'That account has been banned.';
                        }
                     } else {
                        echo 'You have not activated your account using the activation email.';
                     }
                  } else {
                     echo 'Invalid password!';
                  }
               }
            } else {
               echo 'Account does not exist!';
            }
         } else {
            echo 'No password was entered!';
         }
      } else {
         echo 'No email was entered!';
      }
   } else {
      echo '<script type="text/javascript">
               $("#loginform").submit(function(e) {
                  e.preventDefault();
                  BDRFLogin();
                  return;
               });
               function BDRFLogin(){
                  $.ajax({
                     beforeSend: function (request) {
                        $("#loginresponce").html(\'Attempting to login... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                     },
                     type: "POST", url: "ajax_login.php",
                     data: $("#loginform").serialize(),
                     success: function(response){
                        $("#loginresponce").html(response);
                     }
                  });
                  return false;
               }
            </script>
            <center>
            <form action="http:/bdrf.info" method="POST" id="loginform">
            <input type="hidden" name="action" value="login">
            <table style="width: 100%;">
               <tr>
                  <td colspan="2" align="left" style="height: 30px; font-weight: bold;">Login:</td>
               </tr><tr>
                  <td align="right" style="height: 30px; width: 60px; padding-right: 15px;" nowrap>Email</td>
                  <td align="right" style="height: 30px;"><input type="text" name="email" placeholder="Email" style="height: 20px; width: 100%;"></td>
               </tr><tr>
                  <td align="right" style="height: 30px; padding-right: 15px;" nowrap>Password</td>
                  <td align="right" style="height: 30px;"><input type="password" name="password" placeholder="Password" style="height: 20px; width: 100%;"></td>
               </tr><tr>
                  <td colspan="2" style="height: 30px;" align="right"><input type="submit" name="submit" value="Login"></td>
               </tr>
            </table>
            </form>
            <div id="loginresponce">
            </div>
            </center>';
   }
} else {
   echo 'No need to login, you are already logged in.';
}
?>