<?php
require"../coinapi_private/data.php";
session_destroy();
setcookie("identa", '', time()-1000);
setcookie("identa", '', time()-1000, '/');
setcookie("identb", '', time()-1000);
setcookie("identb", '', time()-1000, '/');
echo '<script type="text/javascript">
         setTimeout(function(){
            $("#pagemenu").load("ajax_menu.php");
            $("#pagebody").load("ajax_home.php");
         }, 500);
      </script>
      <center><b>You have logged out.</b></center>';
?>