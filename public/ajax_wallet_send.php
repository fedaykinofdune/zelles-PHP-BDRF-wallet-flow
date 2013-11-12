<?php
require"../coinapi_private/data.php";
if($udb_email) {
   $wallet_type = security($_GET['wallet']);
   if(($wallet_type!="btc")&&($wallet_type!="ltc")&&($wallet_type!="mec")&&($wallet_type!="nan")) {
      die('<div style="height: 30px;"></div><center>Invalid wallet.</center>');
      exit;
   }
   if($wallet_type=="btc") {
      $pz_coin_name = 'Bitcoin';
      $pz_coin_initl = 'btc';
      $pz_coin_initu = 'BTC';
   }
   if($wallet_type=="ltc") {
      $pz_coin_name = 'Litecoin';
      $pz_coin_initl = 'ltc';
      $pz_coin_initu = 'LTC';
   }
   if($wallet_type=="mec") {
      $pz_coin_name = 'Megacoin';
      $pz_coin_initl = 'mec';
      $pz_coin_initu = 'MEC';
   }
   if($wallet_type=="nan") {
      $pz_coin_name = 'Nanotoken';
      $pz_coin_initl = 'nan';
      $pz_coin_initu = 'NAN';
   }

   $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getbalance&acnt='.$udb_email.'&sid=BDRFM';
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $json_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $json_feed = curl_exec($ch);
   curl_close($ch);
   $balance_array = json_decode($json_feed, true);
   $balance = $balance_array['balance'];

   echo '<script type="text/javascript">
            $("#sendform").submit(function(e) {
               e.preventDefault();
               BDRFNANWalletSend();
               return;
            });
            function BDRFNANWalletSend(){
               $.ajax({
                  beforeSend: function (request) {
                     $("#sendresponce").html(\'Securely sending '.$pz_coin_name.'s... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                  },
                  type: "POST", url: "ajax_wallet_send_request.php",
                  data: $("#sendform").serialize(),
                  success: function(response){
                     $("#sendresponce").html(response);
                  }
               });
               return false;
            }
            function page_wallet'.$pz_coin_initl.'_overview() {
               $("#pagebody").html(\'<center><img src="style/loading.gif" /></center>\');
               $("#pagebody").load("ajax_wallet_overview.php?wallet='.$pz_coin_initl.'");
            }
            function page_wallet'.$pz_coin_initl.'_send() {
               $("#pagebody").html(\'<center><img src="style/loading.gif" /></center>\');
               $("#pagebody").load("ajax_wallet_send.php?wallet='.$pz_coin_initl.'");
            }
            function page_wallet'.$pz_coin_initl.'_receive() {
               $("#pagebody").html(\'<center><img src="style/loading.gif" /></center>\');
               $("#pagebody").load("ajax_wallet_receive.php?wallet='.$pz_coin_initl.'");
            }
            function page_wallet'.$pz_coin_initl.'_transactions() {
               $("#pagebody").html(\'<center><img src="style/loading.gif" /></center>\');
               $("#pagebody").load("ajax_wallet_transactions.php?wallet='.$pz_coin_initl.'");
            }
         </script>
         <table>
            <tr>
               <td><a onclick="page_wallet'.$pz_coin_initl.'_overview();return false;">Overview</a></td>
               <td style="padding-left: 20px;"><a onclick="page_wallet'.$pz_coin_initl.'_send();return false;">Send</a></td>
               <td style="padding-left: 20px;"><a onclick="page_wallet'.$pz_coin_initl.'_receive();return false;">Receive</a></td>
               <td style="padding-left: 20px;"><a onclick="page_wallet'.$pz_coin_initl.'_transactions();return false;">Transactions</a></td>
            </tr>
         </table>
         <hr>
         <span style="font-size: 15px; font-weight: bold;">Send '.$pz_coin_name.'s</span>
         <form action="ajax_wallet_send_request.php" method="POST" id="sendform">
         <input type="hidden" name="wallet" value="'.$pz_coin_initl.'">
         <table style="width: 100%;">
            <tr>
               <td style="height: 34px; width: 60px; padding: 10px;" nowrap>Pay To:</td>
               <td style="height: 34px; padding: 10px;" nowrap><input type="text" name="sendto" placeholder="Enter a '.$pz_coin_name.' address" style="width: 100%; height: 22px;"></td>
            </tr><tr>
               <td style="height: 34px; padding: 10px;" nowrap>Amount:</td>
               <td style="height: 34px; padding: 10px;" nowrap><input type="text" name="sendamount" style="width: 100%; height: 22px;"></td>
            </tr>
         </table>
         <table style="width: 100%; margin-top: 10px;">
            <tr>
               <td>Balance: '.$balance.' '.$pz_coin_initu.'</td>
               <td align="right" style="width: 148px;">
                  <input type="hidden" name="send" value="go">
                  <input type="submit" name="submit" value="" style="height: 22px; width: 148px; background: url(\'http://bdrf.info/style/button_send.png\'); border: 0px solid #FFFFFF;">
               </td>
            </tr>
         </table>
         </form>
         <div id="sendresponce"></div>';
} else {
   echo '<center>Login to use the wallets.</center>';
}
?>