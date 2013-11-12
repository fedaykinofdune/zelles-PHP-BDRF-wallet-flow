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
         <span style="font-weight: bold;">'.$pz_coin_name.' Transactions</span>
         <table style="width: 100%;">';
   $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=listtransactions&acnt='.$udb_email.'&sid=BDRFM';
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $json_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   $json_feed = curl_exec($ch);
   curl_close($ch);
   $tx_array = json_decode($json_feed, true);
   $transactions = $tx_array['transactions'];
   function invenDescSort($item1,$item2) {
      if ($item1['time'] == $item2['time']) return 0;
      return ($item1['time'] < $item2['time']) ? 1 : -1;
   }
   usort($transactions,'invenDescSort');
   foreach($transactions as $key => $value) {
      $dtx_confirmations = $transactions[$key]['confirmations'];
      $dtx_address = $transactions[$key]['address'];
      $dtx_category = $transactions[$key]['category'];
      $dtx_amount = $transactions[$key]['amount'];
      $dtx_timestamp = $transactions[$key]['time'];
      if(!$dtx_address) { $dtx_address = '<i style="font-size: 11px; color: 888888;">(unavailable)</i>'; $dtx_confirmations = '10'; }
      if($dtx_timestamp!="") {
         $dtx_time = date("n/j/Y G:i",$dtx_timestamp);
         if($dtx_confirmations>"6") { $dtx_confirmations = "&#8730;"; }
         $dtx_type = '<img src="style/icon_other_large.png" style="width: 30px;">';
         if($dtx_category=="send") { $dtx_type = '<img src="style/icon_sent_large.png" style="width: 30px;">'; }
         if($dtx_category=="receive") { $dtx_type = '<img src="style/icon_received_large.png" style="width: 30px;">'; }
         echo '<tr>
                  <td rowspan="2" style="width: 30px; border-bottom: 1px solid #DDDDDD; padding-top: 2px; padding-bottom: 2px;">'.$dtx_type.'</td>
                  <td style="font-size: 11px; width: 100px; padding-top: 2px; padding-bottom: 2px; padding-left: 10px;">Confirmed: '.$dtx_confirmations.'</td>
                  <td align="right" style="padding-top: 2px; padding-bottom: 2px; font-size: 11px;">'.$dtx_amount.'</td>
               </tr><tr>
                  <td colspan="2" style="border-bottom: 1px solid #DDDDDD; font-size: 11px; padding-top: 2px; padding-bottom: 2px; padding-left: 10px;">'.$dtx_address.'</td>
               </tr>';
      }
   }
   echo '</table>';
} else {
   echo '<center>Login to use the wallets.</center>';
}
?>