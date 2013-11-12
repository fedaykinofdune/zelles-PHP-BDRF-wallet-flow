<html>
<head>
   <title>BDRF.info</title>
   <meta name="viewport" content="width=device-width, initial-scale">
   <link rel="icon" type="image/png" href="style/favicon.png">
   <link rel="stylesheet" type="text/css" href="style/styler.css">
   <script type="text/javascript" src="style/jquery-1.9.1.js"></script>
   <script type="text/javascript" src="style/jquery.timers-1.1.2.js"></script>         
   <script type="text/javascript">
      function page_home() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_home.php');
      }
      function page_login() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_login.php');
      }
      function page_register() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_register.php');
      }
      function page_faucetnan() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_faucet_nan.php');
      }
      function page_fundraiser() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_fundraiser.php');
      }
      function page_walletbtc() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_overview.php?wallet=btc');
      }
      function page_walletltc() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_overview.php?wallet=ltc');
      }
      function page_walletmec() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_overview.php?wallet=mec');
      }
      function page_walletnan() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_wallet_overview.php?wallet=nan');
      }
      function page_settings() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_settings.php');
      }
      function page_logout() {
         $('#pagebody').html('<center><img src="style/loading.gif" /></center>');
         $('#pagebody').load('ajax_logout.php');
      }
      setTimeout(function () {
         $("#pagemenu").load("ajax_menu.php");
         $("#pagebody").load("ajax_home.php");
      }, 100);
   </script>
   <script type="text/javascript">
      function setaddr() {
         document.getElementById('addr').value = document.getElementById('setaddr').value;
      }
   </script>
</head>
<body>
   <div id="pagehead">
      <div class="pagehead-cell">
         <a href="http://bdrf.info" class="pagehead-link">BDRF.info</a>
      </div>
   </div>
   <div id="pagemenu">
      <center><img src="style/loading.gif" /></center>
   </div>
   <div id="pagebody">
      <center><img src="style/loading.gif" /></center>
   </div>
   <center style="margin-top: 10px; margin-bottom: 10px;">BDRF.info - Mobile Optimized</center>
</body>
</html>