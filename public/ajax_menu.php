<?php
require"../coinapi_private/data.php";
if($udb_email) {
   echo '<span><a onclick="page_home();return false;">Home</a></span>
         <span style="padding-left: 20px;"><a onclick="page_walletbtc();return false;">Bitcoin</a></span>
         <span style="padding-left: 20px;"><a onclick="page_walletltc();return false;">Litecoin</a></span>
         <span style="padding-left: 20px;"><a onclick="page_walletmec();return false;">Megacoin</a></span>
         <span style="padding-left: 20px;"><a onclick="page_walletnan();return false;">Nanotoken</a></span>
         <span style="padding-left: 20px;"><a onclick="page_faucetnan();return false;">Faucet</a></span>
         <span style="padding-left: 20px;"><a onclick="page_settings();return false;">Settings</a></span>
         <span style="padding-left: 20px; padding-right: 20px;"><a onclick="page_logout();return false;">Logout</a></span>';
} else {
   echo '<span><a onclick="page_home();return false;">Home</a></span>
         <span style="padding-left: 20px;"><a onclick="page_faucetnan();return false;">Faucet</a></span>
         <span style="padding-left: 20px;"><a onclick="page_register();return false;">Register</a></span>
         <span style="padding-left: 20px; padding-right: 20px;"><a onclick="page_login();return false;">Login</a></span>';
}
?>