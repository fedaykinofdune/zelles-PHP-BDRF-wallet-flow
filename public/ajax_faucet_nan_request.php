<?php
require"../coinapi_private/data.php";

$datec = date('G');

$result = mysql_query("SELECT * FROM box WHERE datec='$datec'");
$num_rows = mysql_num_rows($result);
if($num_rows>3) {
   $onloader = 'It seams someone is trying to abuse us. Try again a later today.';
} else {
   if(isset($_POST['addr'])) { $User_Address = security(strip_tags($_POST['addr'])); }
      if(isset($_POST['addr'])) {
         if($User_Address!="") {
               $result = mysql_query("SELECT * FROM box WHERE date='$date' and address='$User_Address'");
               $num_rows = mysql_num_rows($result);
               if($num_rows==0) {
                  $result = mysql_query("SELECT * FROM box WHERE ip='$ip' and date='$date'");
                  $num_rows = mysql_num_rows($result);
                  if($num_rows==0) {
                     $result = mysql_query("SELECT * FROM box WHERE email='$udb_email' and date='$date'");
                     $num_rows = mysql_num_rows($result);
                     if($num_rows==0) {
                        $send_amount = "0.01";
                        $json_url = 'http://bdrf.info/api_nan.php?puk=jCM8kKazKMOcUDyhP80vIYYjy5DdGixnhr&prk=FsDCfGc8tUUDnoyjwezqxHQOJ9lXOiYUz8ScD&act=sendcoin&acnt=TheAdminsEmail@address.com&sid=BDRFM&to='.$User_Address.'&amount='.$send_amount;
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $json_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $json_feed = curl_exec($ch);
                        curl_close($ch);
                        $txid_array = json_decode($json_feed, true);
                        $txid = $txid_array['txid'];
                        if($txid) { $send_message = $txid; } else { $send_message = $txid_array['message']; }
                        $sql = mysql_query("INSERT INTO box (id,date,datec,ip,email,address,amount,paid) VALUES ('','$date','$datec','$ip','$udb_email','$User_Address','0.01','1')");
                        $onloader = 'Success, Nanotokens sent. '.$send_message;
                     } else {
                        $onloader = 'You already requested Nanotokens today. Try again tomorrow.';
                     }
                  } else {
                     $onloader = 'You already requested Nanotokens today. Try again tomorrow.';
                  }
               } else {
                  $onloader = 'You already requested Nanotokens today. Try again tomorrow.';
               }
         } else {
            $onloader = 'You did not enter an address. Try again!';
         }
      } else {
         $onloader = 'You did not enter an address. Try again!';
      }
}
echo $onloader;
?>