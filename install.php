
<p><b>Basic Installation</b></p>
<p>Open data.php and enter your database connection credentials</p>
<p>Comb the files and replace TheAdminsEmail@address.com with whatever email address the admin account is using</p>
<p>Create the following database tables</p>
<ul>
   <li>accounts (id,date,ip,email,password,status,banned,pub_key,priv_key)</li>
   <li>chathandle (id,email,handle)</li>
   <li>online (id,ip,email,username,user,guest)</li>
   <li>chat (id,date,ip,email,username,message,status)</li>
   <li>chatroom (id,date,ip,email,username,room,allowed,status)</li>
   <li>privatechat (id,date,ip,email,username,room,message,status)</li>
   <li>trade (id,date,ip,buyer,seller,want,offer,amount,rate,total,status)</li>
   <li>box (id,date,datec,ip,email,address,amount,paid)</li>
   <li>box2 (id,date,datec,ip,email,address,amount,paid)</li>
</ul>
<p>All database tables needed "shoud" be listed above.</p>