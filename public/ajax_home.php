<?php
require"../coinapi_private/data.php";
if($udb_email) {
   echo '<script type="text/javascript">
            $("#chatter").submit(function(event) {
               event.preventDefault();
               var $form = $( this ),
               term = $form.find( \'input[name="speak"]\' ).val(),
               url = $form.attr("action");
               var posting = $.post( url, { speak: term } );
               $("#speak").val("");
               var val = this.value;
            });
            function formban(text) {
               $("#chatroom").load("ajax_chat_action.php?ban="+text);
            }
            function formdel(text) {
               $("#chatroom").load("ajax_chat_action.php?del="+text);
            }
            setTimeout(function() {
               $("#chatroom").load("ajax_chat.php");
            }, 200);
            setTimeout(function() {
               $("#chatroom").scrollTop($("#chatroom")[0].scrollHeight);
            }, 1000);
            setInterval(function () {
               $("#chatroom").load("ajax_chat.php");
               $("#chatroom").scroll(function() {
                 scrollm = $("#chatroom").offsetHeight + $("#chatroom").scrollTop == this.scrollHeight;
                 if(scrollm==true){
                    $("#chatroom").scrollTop($("#chatroom")[0].scrollHeight);
                 }
               });
            }, 1500);
         </script>
         <div id="chatroom" style="width: 100%; height: 300px; background: #FFFFFF; border: 0px none #FFFFFF; overflow-y: scroll;">
            <div style="height: 30px;"></div>
            <center><img src="style/loading.gif" border="0"></center>
         </div>
         <form action="ajax_speak.php" id="chatter">
         <input type="text" name="speak" id="speak" style="width: 100%; height: 20px; border: 1px solid #d8d8d8;">
         </form>';
} else {
   echo '<h3>Welcome</h3>
         <blockquote>
         <p>Perfect for using coins with games and services. Also featuring API connectivity for services.</p>
         <hr>
         <p>The coin client might charge a network fee. We do not charge any fees.</p>
         <hr>
         <p>Donate Bitcoin:<br>1ECBjJJ7JSDrDdWdpmCnsMz1m6eLmiRuVK</p>
         </blockquote>';
}
?>