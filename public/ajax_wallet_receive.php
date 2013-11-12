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

   echo '<script type="text/javascript">
            $("#receiveform").submit(function(e) {
               e.preventDefault();
               BDRFNANWalletReceive();
               return;
            });
            function BDRFNANWalletReceive(){
               $.ajax({
                  beforeSend: function (request) {
                     $("#receiveresponce").html(\'Generating a new '.$pz_coin_name.' address... Please wait patiently.<div style="height: 10px;"></div><img src="style/loading.gif" />\');
                  },
                  type: "POST", url: "ajax_wallet_receive_request.php",
                  data: $("#receiveform").serialize(),
                  success: function(response){
                     $("#receiveresponce").html(response);
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
         <span style="font-weight: bold;">'.$pz_coin_name.' Receiving Addresses</span><p></p>';
            $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getaccountaddresses&acnt='.$udb_email.'&sid=BDRFM';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $json_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json_feed = curl_exec($ch);
            curl_close($ch);
            $addressbook_array = json_decode($json_feed, true);
            $addresses = $addressbook_array['addresses'];
            if($addresses=="") {
               $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getnewaddress&acnt='.$udb_email.'&sid=BDRFM';
               $ch = curl_init();
               curl_setopt($ch, CURLOPT_URL, $json_url);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
               $json_feed = curl_exec($ch);
               $addressbook_array = json_decode($json_feed, true);
               $address = $addressbook_array['address'];
               curl_close($ch);
               echo '<p style="font-size: 11px;">'.$address.'</p>';
            } else {
               foreach($addresses as $address) {
                  echo '<p style="font-size: 11px;">'.$address.'</p>';
               }
            }
   echo '<form action="ajax_wallet_receive_request.php" method="POST" id="receiveform" style="margin-top: 10px;">
         <input type="hidden" name="wallet" value="'.$pz_coin_initl.'">
         <input type="hidden" name="newaddress" value="go">
         <input type="submit" name="buttonnewaddress" value="" style="height: 22px; width: 89px; background: url(\'http://bdrf.info/style/button_new_address.png\'); border: 0px solid #FFFFFF;">
         </form>
         <div id="receiveresponce"></div>';
} else {
   echo '<center>Login to use the wallets.</center>';
}
?>