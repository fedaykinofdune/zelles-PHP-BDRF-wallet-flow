<?php
require"../coinapi_private/data.php";
if(!$udb_email) {
   $getaction = security($_POST['action']);
   if($getaction=="register") {
      $register_email = security($_POST['email']);
      $register_password = security($_POST['password']);
      $register_conpassword = security($_POST['conpassword']);
      if($register_email) {
         if($register_password) {
            if($register_password==$register_conpassword) {
               $register_password = substr($register_password, 0, 30);
               $register_password = md5($register_password);
               $register_pub_key = pubkeygen();
               $register_priv_key = pubkeygen();
               $Query = mysql_query("SELECT email FROM accounts WHERE email='$register_email'");
               if(mysql_num_rows($Query) == 0) {
                  $sql = mysql_query("INSERT INTO accounts (id,date,ip,email,password,status,banned,pub_key,priv_key) VALUES ('','$date','$ip','$register_email','$register_password','1','0','$register_pub_key','$register_priv_key')");
                  echo 'Account created! You can login now.';
               } else {
                  echo 'There is already an account using that email!';
               }
            } else {
               echo 'Passwords do not match!';
            }
         } else {
            echo 'No password was entered!';
         }
      } else {
         echo 'No email was entered!';
      }
   } else {
      echo '<script type="text/javascript">
               $("#registerform").submit(function(e) {
                  e.preventDefault();
                  BDRFRegister();
                  return;
               });
               function BDRFRegister(){
                  $.ajax({
                     beforeSend: function (request) {
                        $("#registerresponce").html(\'Attempting to register... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                     },
                     type: "POST", url: "ajax_register.php",
                     data: $("#registerform").serialize(),
                     success: function(response){
                        $("#registerresponce").html(response);
                     }
                  });
                  return false;
               }
            </script>
            <center>
            <form action="http://bdrf.info" method="POST" id="registerform">
            <input type="hidden" name="action" value="register">
            <table style="width: 100%;">
               <tr>
                  <td colspan="2" align="left" style="height: 30px; font-weight: bold;">Registration:</td>
               </tr><tr>
                  <td align="right" style="height: 30px; width: 60px; padding-right: 15px;" nowrap>Email</td>
                  <td align="right" style="height: 30px;"><input type="text" name="email" placeholder="Email" style="height: 20px; width: 100%;"></td>
               </tr><tr>
                  <td align="right" style="height: 30px; padding-right: 15px;" nowrap>Password</td>
                  <td align="right" style="height: 30px;"><input type="password" name="password" placeholder="Password" style="height: 20px; width: 100%;"></td>
               </tr><tr>
                  <td align="right" style="height: 30px; padding-right: 15px;" nowrap>Repeat</td>
                  <td align="right" style="height: 30px;"><input type="password" name="conpassword" placeholder="Repeat Password" style="height: 20px; width: 100%;"></td>
               </tr><tr>
                  <td colspan="2" align="right" style="height: 30px;"><input type="submit" name="submit" value="Register"></td>
               </tr>
            </table>
            </form>
            <div id="registerresponce">
            </div>
            </center>';
   }
} else {
   echo 'No need to register, you are already logged in.';
}
?>