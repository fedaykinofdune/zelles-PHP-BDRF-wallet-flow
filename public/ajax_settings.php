<?php
require"../coinapi_private/data.php";
$getaction = security($_POST['action']);
if($udb_email) {
   if($getaction=="changepassword") {
      if(isset($_POST['newpassword'])) {
         $oldpassword = security($_POST['oldpassword']);
         $newpassword = security($_POST['newpassword']);
         $conpassword = security($_POST['conpassword']);
         $oldpassword = substr($oldpassword, 0, 30);
         $newpassword = substr($newpassword, 0, 30);
         $conpassword = substr($conpassword, 0, 30);
         $enc_oldpassword = md5($oldpassword);
         $enc_newpassword = md5($newpassword);
         $enc_conpassword = md5($conpassword);
         if($newpassword) {
            if($oldpassword) {
               if($enc_newpassword==$enc_conpassword) {
                  $Query = mysql_query("SELECT password FROM accounts WHERE email='$udb_email'");
                  while($Row = mysql_fetch_assoc($Query)) {
                     $account_db_password = $Row['password'];
                  }
                  if($account_db_password==$enc_oldpassword) {
                     $sql = mysql_query("UPDATE accounts SET password='$enc_newpassword' WHERE email='$udb_email'");
                     echo 'Password has been changed.';
                  } else {
                     echo 'Old password did not match your accounts.';
                  }
               } else {
                  echo 'New passwords were not repeated correctly.';
               }
            } else {
               echo 'No old password was entered.';
            }
         } else {
            echo 'No new password was entered.';
         }
      } else {
         echo 'No new password was entered.';
      }
   } else {
      if($getaction=="changehandle") {
         if(isset($_POST['newhandle'])) {
            $newhandle = security($_POST['newhandle']);
            if($newhandle) {
               $a = strtolower ($newhandle);
               if(strpos($a,'userhandle') !== false) {
                  echo 'Chat handle can not contain userhandle.';
               } else {
                  if(strpos($a,'admin') !== false) {
                     echo 'Chat handle can not contain admin.';
                  } else {
                     if(strpos($a,'support') !== false) {
                        echo 'Chat handle can not contain support.';
                     } else {
                        $strlength = strlen($newhandle);
                        if($strlength<=25) {
                           if($strlength>=3) {
                              $Query = mysql_query("SELECT handle FROM chathandle WHERE handle='$newhandle'");
                              if(mysql_num_rows($Query) == 0) {
                                 $sql = mysql_query("UPDATE chathandle SET handle='$newhandle' WHERE email='$udb_email'");
                                 echo 'New chat handle set.';
                              } else {
                                 echo 'That chat handle is already taken.';
                              }
                           } else {
                              echo 'Chat handle must be between 3 and 25 digits.';
                           }
                        } else {
                           echo 'Chat handle must be between 3 and 25 digits.';
                        }
                     }
                  }
               }
            } else {
               echo 'No chat handle was entered.';
            }
         } else {
            echo 'No chat handle was entered.';
         }
      } else {
         echo '<script type="text/javascript">
                  $("#handleform").submit(function(e) {
                     e.preventDefault();
                     BDRFHandle();
                     return;
                  });
                  $("#passwordform").submit(function(e) {
                     e.preventDefault();
                     BDRFPassword();
                     return;
                  });
                  function BDRFHandle(){
                     $.ajax({
                        beforeSend: function (request) {
                           $("#handleresponce").html(\'Changing handle... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                        },
                        type: "POST", url: "ajax_settings.php",
                        data: $("#handleform").serialize(),
                        success: function(response){
                           $("#handleresponce").html(response);
                        }
                     });
                     return false;
                  }
                  function BDRFPassword(){
                     $.ajax({
                        beforeSend: function (request) {
                           $("#passwordresponce").html(\'Changing password... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                        },
                        type: "POST", url: "ajax_settings.php",
                        data: $("#passwordform").serialize(),
                        success: function(response){
                           $("#passwordresponce").html(response);
                        }
                     });
                     return false;
                  }
               </script>
               <form action="ajax_settings.php" method="POST" id="handleform">
               <input type="hidden" name="action" value="changehandle">
               <table style="width: 100%; height: 80px; font-size: 12px;">
                  <tr>
                     <td><b>Set new chat handle:</b></td>
                  </tr><tr>
                     <td><input type="text" name="newhandle" style="width: 100%; height: 20px; border: 1px solid #d8d8d8;"></td>
                  </tr><tr>
                     <td align="right"><input type="submit" name="submit" value="Change Handle" style="padding: 2px;"></td>
                  </tr>
               </table>
               </form>
               <div id="handleresponce"></div>
               <hr>
               <form action="settings_password.php" method="POST" id="passwordform">
               <input type="hidden" name="action" value="changepassword">
               <table style="width: 100%; height: 80px; font-size: 12px;">
                  <tr>
                     <td colspan="2"><b>Set new password:</b></td>
                  </tr><tr>
                     <td style="width: 120px;">Old password:</td>
                     <td style="padding-left: 15px;"><input type="password" name="oldpassword" style="width: 100%; height: 20px; border: 1px solid #d8d8d8;"></td>
                  </tr><tr>
                     <td>New password:</td>
                     <td style="padding-left: 15px;"><input type="password" name="newpassword" style="width: 100%; height: 20px; border: 1px solid #d8d8d8;"></td>
                  </tr><tr>
                     <td>Reapeat password:</td>
                     <td style="padding-left: 15px;"><input type="password" name="conpassword" style="width: 100%; height: 20px; border: 1px solid #d8d8d8;"></td>
                  </tr><tr>
                     <td colspan="2" align="right"><input type="submit" name="submit" value="Change Password" style="padding: 2px;"></td>
                  </tr>
               </table>
               </form>
               <div id="passwordresponce"></div>';
      }
   }
} else {
   echo 'You must be logged in to view this section.';
}
?>