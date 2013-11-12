<?php
require"../coinapi_private/data.php";
$timestamp_now = strtotime('now');
$timestamp_tomorrow = strtotime('tomorrow');
$day_today_day = date('l',$timestamp_now);
$date_today_date = date('dS',$timestamp_now);
$day_today_time = date('g:i a',$timestamp_now);
$day_today = $day_today_time.' on '.$day_today_day.', the '.$date_today_date;
$date_tomorrow_date = date('dS',$timestamp_tomorrow);
$day_tomorrow_day = date('l',$timestamp_tomorrow);
$day_tomorrow = $day_tomorrow_day.', on the '.$date_tomorrow_date;

echo '<script type="text/javascript">
         $("#coina").everyTime(10, function(){
            $("#coina").animate({left:"80%"}, 5000).animate({left:"10"}, 5000);
         });
         $("#coinb").everyTime(10, function(){
            $("#coinb").animate({left:"80%"}, 4000).animate({left:"10"}, 4000);
         });
         $("#coinc").everyTime(10, function(){
            $("#coinc").animate({left:"80%"}, 3000).animate({left:"10"}, 3000);
         });
         $("#faucetform").submit(function(e) {
            e.preventDefault();
            BDRFNANFaucet();
            return;
         });
         function BDRFNANFaucet(){
            $.ajax({
               beforeSend: function (request) {
                  $("#faucetresponce").html(\'The faucet is processing... Please wait patiently.<div style="height: 10px;"></div><img src="/style/loading.gif" />\');
               },
               type: "POST", url: "ajax_faucet_nan_request.php",
               data: $("#faucetform").serialize(),
               success: function(response){
                  $("#faucetresponce").html(response);
               }
            });
            return false;
         }
      </script>
      <table style="width: 100%; height: 100px;">
         <tr>
            <td align="center" style="height: 50px;">
               <table style="width: 100%;">
                  <tr>
                     <td style="width: 160px;">Nanotoken Address:</td>
                     <td><input type="text" name="setaddr" id="setaddr" placeholder="Ma4cSuXrSnL1gU8YjTrtsotBVK4kNQxixk" onclick="setaddr()" onkeyup="setaddr()" onkeydown="setaddr()" onchange="setaddr()" style="width: 100%; height: 20px;"></td>
                  </tr>
               </table>
            </td>
         </tr><tr>
            <td align="center" style="height: 50px;">
               <div id="faucetresponce"></div>
            </td>
         </tr>
      </table>
      <form method="POST" action="ajax_faucet_nan_request.php" id="faucetform">
      <input type="hidden" id="addr" name="addr" value="">
      <div style="width: 100%; border-top: 4px solid #828790; height: 125px;">
         <div style="width: 100%; height: 0px; margin: 0px;">
            <div id="coina" style="width: 88px; height: 105px; position: relative; top: -5px; left: 10px;">
               <input type="submit" name="submit" value="" style="width: 88px; height: 105px; background: url(\'http://bdrf.info/style/target_nan.png\'); border: 0px solid #FFFFFF;">
            </div>
         </div>
         <div style="width: 100%; height: 0px; margin: 0px;">
            <div id="coinb" style="width: 88px; height: 105px; position: relative; top: -5px; left: 10px;">
               <input type="submit" name="submit" value="" style="width: 88px; height: 105px; background: url(\'http://bdrf.info/style/target_nan.png\'); border: 0px solid #FFFFFF;">
            </div>
         </div>
         <div style="width: 100%; height: 0px; margin: 0px;">
            <div id="coinc" style="width: 88px; height: 105px; position: relative; top: -5px; left: 10px;">
               <input type="submit" name="submit" value="" style="width: 88px; height: 105px; background: url(\'http://bdrf.info/style/target_nan.png\'); border: 0px solid #FFFFFF;">
            </div>
         </div>
      </div>
      </form>
      <center><p>It is <b>'.$day_today.'</b>. Request again <b>'.$day_tomorrow.'</b></p></center>';
?>