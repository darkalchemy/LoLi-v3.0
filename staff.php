<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){stdhead("Команда");begin_frame(".:: Команда ::.");
global $CacheBlock, $staffBlock_Refresh, $staffsBlock_Refresh;$_cache = 'staff.cache';$_cacher = 'staffs.cache';
if(!$CacheBlock->Check($_cache, $staffBlock_Refresh?0:3600)){
$dt = gmtime() - 300;$dt = sqlesc(get_date_time($dt));
$res = sql_query("SELECT id, avatar, username, class, last_access FROM users WHERE class>=".UC_UPLOADER." AND status='confirmed' ORDER BY username" ) or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)){
if(!$arr['avatar']){$avatar=("<a href='user_$arr[id]'><img width='50' border='0' title='$arr[username]' src='pic/default_avatar.gif'/></a>");}
else{$avatar=("<a href='user_$arr[id]'><img width='50' src='$arr[avatar]' title='$arr[username]'/></a>");}
$staff_table[$arr['class']] = $staff_table[$arr['class']]."<td style=\"border:0;\"><table width='130' style=\"border:0;\">
<td class='embedded' width='80'><center>$avatar<br><a class='altlink' href=user_".$arr['id']."><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a></center>
</td><td class='embedded' width='50'><center>".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt=\"online\"/>":"
<img src='pic/button_offline.gif' border='0' alt=\"offline\"/>" )."<br><br>
<a href=\"#\" onclick=\"javascript:window.open('sendpm_".$arr['id']."', 'Отправить PM', 'width=650, height=465');return false;\" 
title=\"Отправить ЛС\"><img src='pic/pn_inbox.gif' border='0' title='PM'/></a></center></td></table></td>"." ";
++ $col[$arr['class']];if($col[$arr['class']]<=4) $staff_table[$arr['class']]=$staff_table[$arr['class']]."";
else{$staff_table[$arr['class']]=$staff_table[$arr['class']]."</tr><tr height='15'>";$col[$arr['class']]=0;}}
$content.= "<table width='100%' cellspacing='0' align='center'><tr><td class='embedded' colspan='14'><center>
<font color='RED'><b>Вопросы, на которые есть ответы в правилах или FAQ, будут оставлены без внимания.</b></font><hr>
<b>01.</b>&nbsp;Не просить звания <b><font color='red'>Модератор</font></b>, <b><font color='#339900'>Администратор</font></b>.&nbsp;
Мы сами решаем кому давать повышение.<br>
<b>02.</b>&nbsp;Хотите создавать раздачи на нашем сайте и носить звание&nbsp;<b><font color='#FF9900'>Аплоадер</font></b>,&nbsp;подавайте заявку на&nbsp;
<a href='uploader'><font color='#FF9900'><b>Релизер</b></font></a>.<br>Если вы умеете, а главное хотите создавать раздачи, мы вам не откажем.</center>
</td></tr><tr><td class='embedded' colspan='14'>&nbsp;</td></tr><br><br>
<tr><td class='embedded' colspan='14'><hr color='#4040c0' size='1'></td></tr><tr><td class='embedded' colspan='14'><center><b>.:: Администрация ::.</b>
</center></td></tr><tr><td class='embedded' colspan='14'><hr color='#4040c0' size='1'></td></tr><tr height='15'>".$staff_table[UC_VLADELEC].$staff_table[UC_SYSOP].
$staff_table[UC_ADMINISTRATOR].$staff_table[UC_MODERATOR]."</tr>
<tr><td class='embedded' colspan='14'><hr color='#4040c0' size='1'></td></tr><tr><td class='embedded' colspan='14'><center><b>.:: Аплоадеры ::.</b>
</center></td></tr><tr><td class='embedded' colspan='14'><hr color='#4040c0' size='1'></td></tr><tr height='15'>".$staff_table[UC_UPLOADER]."</tr></table>";
$CacheBlock->Write($_cache, $content);}else $content = $CacheBlock->Read($_cache);print $content;
end_frame();if(get_user_class() >= UC_MODERATOR){?><br><? begin_frame(".:: Панель Модератора<font color='#FF0000'> - Видно только Модераторам</font> ::.");?>
<table width='100%' cellspacing='10' align='center'><tr>
<td class='embedded'><center><form method='get' action='staffmess'><input type='submit' value="Масовое ПМ" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='unco'><input type='submit' value="Неподтв. юзеры" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='top'><input type='submit' value="Top 10" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='noconnect'><input type='submit' value="Юзеры за NAT" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='log'><input type='submit' value="Лог сайта" style='height:20px;width:100px'></form></center></td></tr><tr>
<td class='embedded'><center><form method='get' action='last_users'><input type='submit' value="Новички" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='baned_users'><input type='submit' value="Отключеные" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='small_raiting'><input type='submit' value="Малый Рейтинг" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='testip'><input type='submit' value="Проверка IP" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='uploaders'><input type='submit' value="Аплоадеры" style='height:20px;width:100px'></form></center></td></tr><tr>
<td class='embedded'><center><form method='get' action='users'><input type='submit' value="Список юзеров" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='tags'><input type='submit' value="Теги" style='height:20px;width:100px'></form></center></td>
<td class='embedded'><center><form method='get' action='smilies'><input type='submit' value="Смайлы" style='height:20px;width:100px'></form></center></td></tr></table><br>
<table width='100%' cellspacing='3'><tr><td class='embedded'><center><form method='get' action="users.php">Поиск:&nbsp;&nbsp;<input type='text' size='30' name='search'>&nbsp;&nbsp;
<select name='class'><option value='-'>(Выберите)</option><option value='0'>Пользователь</option><option value='1'>Опытный пользователь</option><option value='2'>VIP</option>
<option value='3'>Аплоадер</option><option value='4'>Модератор</option><option value=''>Администратор</option></select>&nbsp;&nbsp;<input type='submit' value='Искать'></form></center></td></tr>
<tr><td class='embedded'><center><a href="usersearch">Административный поиск</a></center></td></tr></table><? end_frame();}
if(!$CacheBlock->Check($_cacher, $staffsBlock_Refresh?0:3600)){
$res = sql_query("SELECT id, username, class, avatar, country, last_access, supportfor FROM users WHERE support='yes' AND status='confirmed' ORDER BY username LIMIT 10") or sqlerr(__FILE__, __LINE__);
while ($arr = mysql_fetch_assoc($res)){
if(!$arr['avatar']){$avatar=("<a href='user_$arr[id]'><img width='50' border='0' title='$arr[username]' src='pic/default_avatar.gif'/></a>");}
else{$avatar=("<a href='user_$arr[id]'><img width='50' src='$arr[avatar]' title='$arr[username]'/></a>");}
$land = sql_query("SELECT name, flagpic FROM countries WHERE id=".$arr['country']) or sqlerr(__FILE__, __LINE__);$arr2 = mysql_fetch_assoc($land);
$firstline .= "<tr height='15'><td class='embedded'><center>$avatar<br><a class='altlink' href='user_$arr[id]'><b>".get_user_class_color($arr['class'],$arr['username'])."</b></a></center></td>
<td class='embedded'><center> ".("'".$arr['last_access']."'">$dt?"<img src='pic/button_online.gif' border='0' alt=\"online\"/>":"<img src='pic/button_offline.gif' border='0' alt=\"offline\"/>" )."</center></td>
<td class='embedded'><center><a href=\"#\" onclick=\"javascript:window.open('sendpm_".$arr['id']."', 'Отправить PM', 'width=650, height=465');return false;\" title=\"Отправить ЛС\"><img src='pic/pn_inbox.gif' border='0' title='PM'/></a></center></td>
<td class='embedded'><center><img src='pic/flag/$arr2[flagpic]' title='$arr2[name]' border='0' width='19' height='12'/></center></td>
<td class='embedded'><center>".$arr['supportfor']."</center></td></tr>";}?>
<?$CacheBlock->Write($_cacher, $firstline);}else $firstline = $CacheBlock->Read($_cacher);
begin_frame(".:: Первая линия поддержки ::."); ?><table width='100%' cellspacing='0'><tr><td class='embedded' colspan='11'>
<center>Общие вопросы лучше задавать этим пользователям. Учтите что они добровольцы, тратящие свое время и силы на помощь вам. Относитесь к ним подобающе.<br><br><br></center></td></tr>
<tr><td class='embedded' width="30"><center><b>Пользователь&nbsp;</b></center></td>
<td class='embedded' width="5"><center><b>Активен&nbsp;</b></center></td><td class='embedded' width="5"><center><b>Контакт&nbsp;</b></center></td>
<td class='embedded' width="85"><center><b>Язык&nbsp;</b></center></td><td class='embedded' width="200"><center><b>Поддержка для&nbsp;</b></center></td></tr><tr>
<tr><td class='embedded' colspan='11'><hr color="#4040c0" size='1'></td></tr><center><?=$firstline?></center></tr></table><? end_frame();
stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>