<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){parked();
if($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){if(!empty($_POST['area'])){echo format_comment(unesc($_POST['area']));echo "<br>";}else{
stderr2("Ошибка", "<center>Вы ничего не ввели</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");}}else{
stderr2("Ошибка", "<center>Вы ничего не ввели</center><html><head><meta http-equiv=refresh content='3;url=/'></head></html>");}
}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>