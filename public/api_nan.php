<?php
require"../coinapi_private/data.php";

// This would connect to a secondary server/api which would be running the actual coin client
// This api can be switched to connect directly to the coin client on this server if running from one server

$json_array['message'] = 'access denied';
$json_array['error'] = 'true';
$additional = '';
if(isset($_GET['puk'])) {
   $pub_key = security($_GET['puk']);
} else {
   $json_feed = json_encode($json_array);
   die($json_feed);
   exit;
}
if(isset($_GET['prk'])) {
   $priv_key = security($_GET['prk']);
} else {
   $json_feed = json_encode($json_array);
   die($json_feed);
   exit;
}
$Query = mysql_query("SELECT priv_key FROM accounts WHERE pub_key='$pub_key' and priv_key='$priv_key'");
if(mysql_num_rows($Query) == 0) {
   $json_array['message'] = 'invalid account';
   $json_feed = json_encode($json_array);
   die($json_feed);
   exit;
}
if(isset($_GET['act'])) {
   $action = security($_GET['act']);
} else {
   $json_array['message'] = 'invalid action';
   $json_feed = json_encode($json_array);
   die($json_feed);
   exit;
}
if(($action!="getinfo")&&($action!=="getbalance")&&($action!=="getaccountaddress")&&($action!=="getaccountaddresses")&&($action!=="getnewaddress")&&($action!=="sendcoin")&&($action!=="listtransactions")&&($action!=="move")){
   $json_array['message'] = 'invalid action';
   $json_feed = json_encode($json_array);
   die($json_feed);
   exit;
}
if(isset($_GET['acnt'])) {
   $account = security($_GET['acnt']);
   $additional .= '&account='.$account;
}
if(isset($_GET['sid'])) {
   $sid = security($_GET['sid']);
   $sid = substr($sid, 0, 5);
   $additional .= '&sid='.$sid;
}
if(isset($_GET['to'])) {
   $to = $_GET['to'];
   $additional .= '&to='.$to;
}
if(isset($_GET['amount'])) {
   $amount = security($_GET['amount']);
   $additional .= '&amount='.$amount;
}
if(isset($_GET['cnt'])) {
   $cnt = security($_GET['cnt']);
   $additional .= '&cnt='.$cnt;
}
$kick_url = 'http://realapiurladdres.com/api_nan.php?action='.$action.'&pub_key='.$pub_key.'&priv_key='.$priv_key.$additional;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $kick_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
echo $output;
curl_close($ch);
?>