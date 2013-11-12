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

   if(isset($_POST['newaddress'])) {
      $json_url = 'http://bdrf.info/api_'.$pz_coin_initl.'.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=getnewaddress&acnt='.$udb_email.'&sid=BDRFM';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $json_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $json_feed = curl_exec($ch);
      curl_close($ch);
      $address_array = json_decode($json_feed, true);
      $address = $address_array['address'];
      $onloader = 'Created a new '.$pz_coin_name.' address successfully.<p>'.$address.'</p>';
   }
   echo $onloader;
} else {
   echo 'Login to use the wallets.';
}
?>