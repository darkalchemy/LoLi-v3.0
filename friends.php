<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
$userid = intval($_GET['id']);$action = strval($_GET['action']);if(!$userid)$userid = $CURUSER['id'];
if(!is_valid_id($userid))stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
if($userid != $CURUSER["id"])stderr2($tracker_lang['error'], $tracker_lang['access_denied']);
$res = mysql_query("SELECT * FROM users WHERE id=$userid") or sqlerr(__FILE__, __LINE__);
$user = mysql_fetch_array($res) or stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
if ($action == 'add'){$targetid = intval($_GET['targetid']);$type = strval($_GET['type']);
if (!is_valid_id($targetid))stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
if ($type == 'friend') {$table_is = $frag = 'friends';$field_is = 'friendid';
}elseif ($type == 'block') {$table_is = $frag = 'blocks';$field_is = 'blockid';}else stderr2($tracker_lang['error'], "Unknown type.");
$r = mysql_query("SELECT id FROM $table_is WHERE userid=$userid AND $field_is=$targetid") or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($r) == 1)stderr2($tracker_lang['error'], "User ID is already in your ".htmlentities($table_is)." list.");
mysql_query("INSERT INTO $table_is VALUES (0, $userid, $targetid)") or sqlerr(__FILE__, __LINE__);
header("Location: friends");die;}
if ($action == 'delete'){$targetid = intval($_GET['targetid']);$type = htmlentities($_GET['type']);
if(!is_valid_id($targetid))stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);
if($type == 'friend'){
mysql_query("DELETE FROM friends WHERE userid=$userid AND friendid=$targetid") or sqlerr(__FILE__, __LINE__);
if (mysql_affected_rows() == 0)stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);$frag = "friends";}
elseif($type == 'block'){
mysql_query("DELETE FROM blocks WHERE userid=$userid AND blockid=$targetid") or sqlerr(__FILE__, __LINE__);
if (mysql_affected_rows() == 0)stderr2($tracker_lang['error'], $tracker_lang['invalid_id']);$frag = "blocks";
}else stderr2($tracker_lang['error'], "Unknown type.");header("Location: friends");die;}
//////////////////////////////
stdhead("Мои списки пользователей");?>
<table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: <?=$tracker_lang['friends_list']?> ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"></td></tr>
</table></td></tr></table><?
$res = sql_query("SELECT u.*, f.friendid as id, c.name AS names, c.flagpic FROM friends AS f LEFT JOIN users as u ON f.friendid = u.id 
LEFT JOIN countries AS c ON c.id = u.country WHERE userid=$userid ORDER BY name") or sqlerr(__FILE__, __LINE__);if(mysql_num_rows($res) == 0){
echo "<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>".$tracker_lang['no_friends'].".</b></font></center></td></tr></table>";
}else{?><table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><?
$num = mysql_num_rows($res);$nc=1;for($i = 0; $i < $num; ++$i){while($friend = mysql_fetch_assoc($res)){
if($nc == 1){print("<tr>");}$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
if($friend['country'] > 0){$country = "<img src=\"pic/flag/$friend[flagpic]\" alt=\"$friend[names]\" title=\"$friend[names]\">";}else{$country = "Не указанно";}
if($friend['added'] == '0000-00-00 00:00:00')$arr['added'] = '-';if($friend['last_access'] == '0000-00-00 00:00:00')$friend['last_access'] = '-';
if($friend["downloaded"] > 0){$ratio = number_format($friend["uploaded"] / $friend["downloaded"], 2);if(($friend["uploaded"] / $friend["downloaded"]) > 100)$ratio = "100+";
$ratio = "<font color=\"".get_ratio_color($ratio)."\">$ratio</font>";}elseif($friend["uploaded"] > 0) $ratio = "Inf.";else $ratio = "Inf.";
if($friend["gender"] == "1") $gender = "<img src=\"pic/male1.gif\" alt=\"Парень\" style=\"margin-left: 4pt\">";
elseif($friend["gender"] == "2") $gender = "<img src=\"pic/female1.gif\" alt=\"Девушка\" style=\"margin-left: 4pt\">";
elseif($friend["gender"] == "3") $gender = "<img src=\"pic/na.gif\" alt=\"Трансгендер\" style=\"margin-left: 4pt\">";
if(!$friend[avatar]){$avatar=("<a href='user_".$friend['id']."'><img border='0' height='80' title='".$friend['username']."' src='pic/default_avatar.gif'></a>");
}else{$avatar=("<a href='user_".$friend['id']."'><img height='80' src='".$friend['avatar']."' title='".$friend['username']."'></a>");}
print("<td style='padding:10px;width:240px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='padding:10px;width:240px;border-radius:10px;border:0;' class='a'><table style='background:none;align:center;border:0;' width='240px'>
<tr><td class='embedded' width='90' style='background:none;align:center;border:0;'><center>$avatar</center></td>
<td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='user_".$friend['id']."'><b>".get_user_class_color($friend['class'],$friend['username'])."</b></a>".($friend["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'>" : "")."&nbsp;&nbsp;$gender
<a href=\"friends.php?id=$userid&action=delete&type=friend&targetid=".$friend['id']."\"><img align='right' title='".$tracker_lang['delete']." из Друзей' alt='".$tracker_lang['delete']." из Друзей' src='themes/HDclub/images/close.png'/></a><hr width='100'>
".("'".$friend['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm_".$friend['id']."', 'Отправить PM', 'width=650, height=465');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>&nbsp;&nbsp;$country<br/><br/><img src='pic/multitracker.png' border='0' alt='Рейтинг'/>&nbsp;<b>$ratio</b></center></td></tr></table><hr width='200'>
<table style=\"background:none;border:0;\" width='240'><tr><td class='embedded' align='left' style='background:none;border:0;'>
<b>Зарегистрирован:</b>&nbsp;<font color='green'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($friend["added"]))." ".$tracker_lang['ago']."</b>
</font></td></tr><tr><td class='embedded' width='150' align='left' style='background:none;border:0;'><b>Последний визит:</b>&nbsp;<font color='blue'>
<b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($friend["last_access"]))." ".$tracker_lang['ago']."</b></font></td></tr></table></td></tr></table></td>");
++$nc;if($nc == 4){$nc=1;print("</tr>");}}}?></table><?}?>
<table style="background:none;cellspacing:0;cellpadding:0;margin-top:7px;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: <?=$tracker_lang['blocked_list']?> ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;"></td></tr>
</table></td></tr></table><?
$ress = sql_query("SELECT u.*, b.blockid AS id, c.name AS names, c.flagpic FROM blocks AS b LEFT JOIN users AS u ON b.blockid = u.id 
LEFT JOIN countries AS c ON c.id = u.country WHERE userid = $userid ORDER BY name") or sqlerr(__FILE__, __LINE__);if(mysql_num_rows($ress) == 0){
echo "<table style='background:none;border:none;cellspacing:0;cellpadding:0;margin-top:7px;width:200px;float:center;'><tr>
<td style='border-radius:5px;-webkit-border-radius:5px;-moz-border-radius:5px;-khtml-border-radius:5px;border:1px solid white;display:block;' class='a'>
<center><font style='font-family:tahoma;font-size:14px;font-weight:10;color:red;'><b>".$tracker_lang['no_blocked'].".</b></font></center></td></tr></table>";
}else{?><table style="margin-top:7px;background:none;cellspacing:0;cellpadding:0;width:100%;float:center;align:center;border:0;"><?
$nums = mysql_num_rows($ress);$ncs=1;for($is = 0; $is < $nums; ++$is){while($block = mysql_fetch_assoc($ress)){
if($ncs == 1){print("<tr>");}$dts = gmtime() - 300;$dts = sqlesc(get_date_time($dts));
if($block['country'] > 0){$country = "<img src=\"pic/flag/$block[flagpic]\" alt=\"$block[names]\" title=\"$block[names]\">";}else{$country = "Не указанно";}
if($block['added'] == '0000-00-00 00:00:00')$block['added'] = '-';if($block['last_access'] == '0000-00-00 00:00:00')$block['last_access'] = '-';
if($block["downloaded"] > 0){$ratio = number_format($block["uploaded"] / $block["downloaded"], 2);if(($block["uploaded"] / $block["downloaded"]) > 100)$ratio = "100+";
$ratio = "<font color=\"".get_ratio_color($ratio)."\">$ratio</font>";}elseif($block["uploaded"] > 0) $ratio = "Inf.";else $ratio = "Inf.";
if($block["gender"] == "1") $gender = "<img src=\"pic/male1.gif\" alt=\"Парень\" style=\"margin-left: 4pt\">";
elseif($block["gender"] == "2") $gender = "<img src=\"pic/female1.gif\" alt=\"Девушка\" style=\"margin-left: 4pt\">";
elseif($block["gender"] == "3") $gender = "<img src=\"pic/na.gif\" alt=\"Трансгендер\" style=\"margin-left: 4pt\">";
if(!$block[avatar]){$avatar=("<a href='user_".$block['id']."'><img border='0' height='80' title='".$block['username']."' src='pic/default_avatar.gif'></a>");
}else{$avatar=("<a href='user_".$block['id']."'><img height='80' src='".$block['avatar']."' title='".$block['username']."'></a>");}
print("<td style='padding:10px;width:240px;background:none;'><table style='background:none;'border='0' cellspacing='0'><tr>
<td style='padding:10px;width:240px;border-radius:10px;border:0;' class='a'><table style='background:none;align:center;border:0;' width='240px'>
<tr><td class='embedded' width='90' style='background:none;align:center;border:0;'><center>$avatar</center></td>
<td class='embedded' valign='top' align='center' style='background:none;border:0;'><center>
<a class='altlink' href='user_".$block['id']."'><b>".get_user_class_color($block['class'],$block['username'])."</b></a>".($block["donated"] > 0 ? "
<img src='pic/star.gif' border='0' alt='Donor'>" : "")."&nbsp;&nbsp;".$gender."
<a href='friends.php?id=$userid&action=delete&type=block&targetid=".$block['id']."'><img align='right' title='".$tracker_lang['delete']." из Врагов' alt='".$tracker_lang['delete']." из Врагов' src='themes/HDclub/images/close.png'/></a><hr width='100'>
".("'".$block['last_access']."'">$dts?"<img src='pic/button_online.gif' border='0' alt='online'/>":"<img src='pic/button_offline.gif' border='0' alt='offline'/>" )."&nbsp;&nbsp;
<a href='#' onclick=\"javascript:window.open('sendpm_".$block['id']."', 'Отправить PM', 'width=650, height=465');return false;\" title='Отправить ЛС'><img src='pic/pn_inbox.gif' border='0' title='PM'/></a>&nbsp;&nbsp;$country<br/><br/><img src='pic/multitracker.png' border='0' alt='Рейтинг'/>&nbsp;<b>$ratio</b></center></td></tr></table><hr width='200'>
<table style=\"background:none;border:0;\" width='240'><tr><td class='embedded' align='left' style='background:none;border:0;'>
<b>Зарегистрирован:</b>&nbsp;<font color='green'><b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($block["added"]))." ".$tracker_lang['ago']."</b>
</font></td></tr><tr><td class='embedded' width='150' align='left' style='background:none;border:0;'><b>Последний визит:</b>&nbsp;<font color='blue'>
<b>".get_elapsed_time(sql_timestamp_to_unix_timestamp($block["last_access"]))." ".$tracker_lang['ago']."</b></font></td></tr></table></td></tr></table></td>");
++$ncs;if($ncs == 5){$ncs=1;print("</tr>");}}}print("</table>");}stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>