<?php
require"../coinapi_private/data.php";
if($udb_email) {
   $wallet_type = security($_POST['wallet']);
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

   if(isset($_POST['send'])) {
      $sendamount = security($_POST['sendamount']);
      $sendto = security($_POST['sendto']);
      $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=sendcoin&acnt='.$udb_email.'&sid=BDRFM&to='.$sendto.'&amount='.$sendamount;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $json_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $json_feed = curl_exec($ch);
      curl_close($ch);
      $txid_array = json_decode($json_feed, true);
      $txid = $txid_array['txid'];
      $txidmessage = $txid_array['message'];
      if($txid) {
         echo $sendamount.' '.$pz_coin_name.'s have been sent successfully.<p>Txid: '.$txid;
      } else {
         echo 'Error: '.$txidmessage;
      }
   }
} else {
   echo 'Login to use the wallets.';
}
?>