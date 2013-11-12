<?php
require"../coinapi_private/data.php";

echo '<script type="text/javascript">
         $("#fundraiserform").submit(function(e) {
            e.preventDefault();
            BDRFFundraiser();
            return;
         });
         function BDRFFundraiser(){
            $.ajax({
               beforeSend: function (request) {
                  $("#fundraiserresponce").html(\'Searching available fundraisers... Please wait patiently.<div style="height: 10px;"></div><img src="/style/loading.gif" />\');
               },
               type: "POST", url: "ajax_fundraiser_request.php",
               data: $("#fundraiserform").serialize(),
               success: function(response){
                  $("#fundraiserresponce").html(response);
               }
            });
            return false;
         }
      </script>
      <form method="POST" action="http://bdrf.info" id="fundraiserform">
         <input type="text" name="term">
         <input type="submit" name="submit" value="Search">
      </form>
      <div id="fundraiserresponce"></div>';
?>