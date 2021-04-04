<?php require_once("include/bittorrent.php");dbconn(true);gzip();if ($CURUSER && get_user_class() >= UC_ADMINISTRATOR){
$action = ($_POST['action'] ? $_POST['action'] : ($_GET['action'] ? $_GET['action'] : 'start')); 
if($action == 'clearshout'){sql_query('TRUNCATE TABLE shoutbox2') or sqlerr(__FILE__, __LINE__);header("Refresh: 3; url=chat.php");
stderr2('<center><b>Очистка прошла успешно.</b></center>','<center><b>Таблица чата была успешно очищена. Сейчас вы будете возвращены в чат.</b></center>'); 
}elseif($action == 'start'){ 
stderr2('<center><b>Очистить таблицы</b></center>','<center>Нажмите <a href="'.$_SERVER['SCRIPT_NAME'].'?action=clearshout">сюда</a> что-бы очистить таблицы.</center>',false); 
}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
