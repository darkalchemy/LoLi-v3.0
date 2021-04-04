<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_SYSOP){
stdhead("Добавить пользователям Бонусы");if($_SERVER["REQUEST_METHOD"] == "POST"){$bonuss = (isset($_POST["bonuss"]) ? intval($_POST["bonuss"]):0);
if(!$_POST["bonuss"] || empty($_POST["bonuss"]))stderr2("Error", "Нет количества бонусов.<html><head><meta http-equiv=refresh content='4;url=bans.php'></head></html>");
sql_query("UPDATE users SET bonus = bonus + ".sqlesc($bonuss)) or sqlerr(__FILE__, __LINE__);header("Location: $DEFAULTBASEURL/topten.php?type=bonus&lim=100#bonus");die;}else{
begin_frame(".:: Добавить пользователям Бонусы ::.");?>
<table style='background:none;border:none;width:100%;cellspacing:0;cellpadding:5;'><form method="post" action="addbonus_all_users.php"><tr>
<td style='background:none;border:none;width:100%;'><center>Бонусы: <input type="uploaded" name="bonuss" size="5">
<input type="submit" value="Добавить" class="btn"></center></td></tr></form></table><?end_frame();}stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
