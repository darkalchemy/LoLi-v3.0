<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){$action = $_GET["action"];$usernames = iconv('cp1251', 'UTF-8', $CURUSER["username"]);
stdhead("Личный кабинет $usernames", false);begin_frame(".:: Личный кабинет $usernames ::.", false);
print("<table style=\"border:0;\" align='center'><tr><td width='100%' valign='top' style=\"border:0;\"><table style=\"border:0;\" align='center'>");
if($_GET["edited"]){print("<tr><td height='25' style=\"border:0;\"><center><b>Профиль обновлён!</b></center></td></tr>");}
elseif($_GET["mailsent"]){print("<tr><td height='25' style=\"border:0;\"><center><h2>Потверждение было выслано</h2></center></td></tr>");}
elseif($_GET["emailch"]){print("<tr><td height='25' style=\"border:0;\"><center><b>Email адрес изменён!</b></center></td></tr>");}
print("</table><table width='100%' style=\"border:0;\">");
if ($action == "avatar"){?><form method="post" enctype='multipart/form-data' action="takeeditusercp.php?action=avatar"><?
print("<tr><td class=\"zaliwka\" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;\">.:: Настройки аватара ::.</td></tr>");
///////////////////
print("<tr><td style=\"border:0;\" align='center'>");
if($CURUSER['avatar']){?><img width='150px' src="<?=$CURUSER["avatar"];?>"><?}else{?><img width='150px' src='pic/default_avatar.gif'><?}
print("</td><td colspan=\"2\" align=\"left\" style=\"border:0;\">
<input type='radio' name='avatar_act' value='keep' checked>Оставить аватар&nbsp&nbsp<input type='radio' name='avatar_act' value='delete'>Удалить аватар
&nbsp&nbsp<input type='radio' name='avatar_act' value='update'>Обновить аватар<br/><br/>&nbsp&nbsp&nbsp&nbsp");
if($CURUSER["stops"]=="no"){print("<input type='file' name='avatar' size='60'>");}else{print("<input type='file' name='avatar' size='60' disabled >");}
print("&nbsp&nbsp<b><font color='red'><u>ВАЖНО:</u></font>&nbsp".sprintf($tracker_lang['max_avatar_size'], $avatar_max_width, $avatar_max_height)."</b>
<br><br><hr width='98%'><br>&nbsp&nbsp&nbsp&nbsp<b>Показывать аватар?</b>&nbsp&nbsp<input type='checkbox' name=avatars".($CURUSER["avatars"] == "yes" ? " checked" : "")."> 
(Пользователи с маленькими каналами могут отключить эту опцию)</td></tr>");
if($CURUSER["stops"]=="no"){?><tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;"></td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn">
<?}else{?><tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
Вам ЗАПРЕЩЕНО редактирование Аватара</td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn" disabled >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn" disabled >
<?}?></td></tr></form>
<?}elseif($action == "signature"){?><form method="post" action="takeeditusercp.php?action=signature"><?
print("<tr><td class=\"zaliwka\" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;\">.:: Настройки информации (подписи) на вашей страничке ::.</td></tr>");
?><tr><td align="center" style="background:none;width:100%;float:center;border:0;"><textarea name='info' cols='100' rows='4'><?=htmlspecialchars_uni($CURUSER["info"])?></textarea>
<br>Displayed on your public page. May contain <a href=tags target=_new>BB codes</a></td></tr><?
if($CURUSER["stops"]=="no"){?><tr><td class="zaliwka" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;"></td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn">
<?}else{?><tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">Вам ЗАПРЕЩЕНО редактирование информации (подписи)</td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn" disabled >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn" disabled >
<?}?></td></tr></form><?}elseif($action == "security"){?>
<form method="post" action="takeeditusercp.php?action=security"><?
print("<tr><td class=\"zaliwka\" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;\">.:: Настройки зашиты ::.</center></td></tr>");
print("<tr><td colspan=2></td></tr>");
//////////// PARKED MOD //////////////
tr($tracker_lang['my_parked'],
"<input type=\"radio\" name=\"parked\" ".($CURUSER["parked"] == "yes" ? " checked" : "")." value=\"yes\">".$tracker_lang['yes']."<input type=\"radio\" name=\"parked\"" . ($CURUSER["parked"] == "no" ? " checked" : "") . " value=\"no\">".$tracker_lang['no']."<br /><font class=\"small_text\">".$tracker_lang['my_you_can_park'].".</font>",1);
////////////////////////////////////////
tr("Скрыть профиль",
"<input type='radio' name='hide' ".($CURUSER["hide"] == "yes" ? " checked" : "")." value='yes'>".$tracker_lang['yes']."<input type='radio' name='hide' ".($CURUSER["hide"] == "no" ? " checked" : "")." value='no'>".$tracker_lang['no']."<br /><font class='small_text'>Скрыть просмотр профиля от других пользователей.</font>",1);
//////////// SECURE LOGIN MOD //////////////
tr("Скрыть раздачи", "<input type=checkbox name='hide_seeder' ".($CURUSER['hides'] == 'yes' ? ' checked' : '')."> Скрыть имя пользователя в списке пиров (в Профиле и Деталях релизов)", 1);
//////////////////////////////////
tr("Скрыть скачанные", "<input type=checkbox name='hide_leeching' ".($CURUSER['hiders'] == 'yes' ? ' checked' : '')."> Скрыть список скачанных релизов (в Профиле и Деталях релизов)", 1);
//////////////////////////////
tr("Скрыть релизы", "<input type=checkbox name='hide_reliz' ".($CURUSER['hider'] == 'yes' ? ' checked' : '')."> Скрыть список МОИХ залитых релизов (в Профиле и Деталях релизов НИК)", 1);
/////////////////////////
tr("Скрыть приглашенных", "<input type=checkbox name='hide_invayted' ".($CURUSER['invayted'] == 'yes' ? ' checked' : '') ."> Скрыть в профиле список приглашенных пользователей", 1);
//////////////////////////////
tr("Скрыть кто пригласил", "<input type=checkbox name='hide_invayt' ".($CURUSER['invayt'] == 'yes' ? ' checked' : '') ."> Скрыть в профиле пригласившего на сайт", 1);
//////////////////////////////
tr("Запрет на перевод бонусов", "<input type=checkbox name='hide_bonusss' ".($CURUSER['bonusss'] == 'yes' ? ' checked' : '')."> Запретить переводить мне бонусы через *Подарить бонусы*", 1);
//////////////////////////////
tr("Мультитреккер Удалять?", "<input type=checkbox name='multikoff' ".($CURUSER['multik'] == 'yes' ? ' checked' : '')."> Удалять при скачке торрент-файла анонсы других сайтов?<br> Эта опция удаляет все анонсы кроме основного (ЭТОГО) сайта, тем самым, вы качаете только с этого сайта и отдаете статистику на этот сайт.", 1);
//////////////////////////////
//////////////////////////////////////// PASSKEY MOD //////////////////
if($CURUSER["stops"]=="no"){
tr("Сменить пасскей  ","<input type=checkbox name=resetpasskey value=1> Ваш пасскей <b> $CURUSER[passkey] </b> <br><font class=small>(Вы должны перекачать все активные торренты после смены пасскея)</font>", 1); 
///////////////////////////////////
tr("Привязать IP к пасскею", "<input type=checkbox name=passkey_ip" . ($CURUSER["passkey_ip"] != "" ? " checked" : "") . "> Включив эту опцию вы можете защитить себя от неавторизованной закачки по вашему пасскею привязав его к IP.<br> Если ваш IP динамический - не включайте эту опцию.<br>На данный момент ваш IP: <b>".getip()."</b>", 1);
////////////// PASSKEY MOD //////////////////
tr("Email адрес  ", "<input type=\"text\" name=\"email\" size=50 value=\"".htmlspecialchars_uni($CURUSER["email"])."\"><br>
Если вы смените ваш Email адрес, то вам придет запрос о подтверждении на ваш новый Email-адрес. Если вы не подтвердите письмо, то Email адрес не будет изменен.", 1);
tr("Старый пароль", "<input type=\"password\" name=\"oldpassword\" size=\"50\">", 1);
tr("Сменить пароль", "<input type=\"password\" name=\"chpassword\" size=\"50\">", 1);
tr("Пароль еще раз", "<input type=\"password\" name=\"passagain\" size=\"50\">", 1);
?><tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;"></td></tr><?}else{
tr("Сменить пасскей  ","<input type=checkbox name=resetpasskey value=1 disabled> Ваш пасскей <b> $CURUSER[passkey] </b> <br><font class=small>(Вы должны перекачать все активные торренты после смены пасскея)</font>", 1); 
///////////////////////////////////
tr("Привязать IP к пасскею", "<input type=checkbox name='passkey_ip' ".($CURUSER["passkey_ip"] != "" ? " checked" : "")." disabled> Включив эту опцию вы можете защитить себя от неавторизованной закачки по вашему пасскею привязав его к IP.<br> Если ваш IP динамический - не включайте эту опцию.<br>На данный момент ваш IP: <b>".getip()."</b>", 1);
////////////// PASSKEY MOD //////////////////
tr("Email адрес  ", "<input type=\"text\" name=\"email\" size=50 value=\"".htmlspecialchars_uni($CURUSER["email"])."\" disabled><br>
Если вы смените ваш Email адрес, то вам придет запрос о подтверждении на ваш новый Email-адрес. Если вы не подтвердите письмо, то Email адрес не будет изменен.", 1);
tr("Старый пароль", "<input type=\"password\" name=\"oldpassword\" size=\"50\" disabled>", 1);
tr("Сменить пароль", "<input type=\"password\" name=\"chpassword\" size=\"50\" disabled>", 1);
tr("Пароль еще раз", "<input type=\"password\" name=\"passagain\" size=\"50\" disabled>", 1);?>
<tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">Вам ЗАПРЕЩЕНО редактирование: Email, пароль, пасскей, привязка IP к пасскею</td></tr><?}?>
<tr><td colspan="2" style="border:0;" height="30" align="center"><br><input type="submit" value="Обновить профиль" class="btn">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn"></td></tr>
</form><?}elseif($action == "pm"){?><form method="post" action="takeeditusercp.php?action=pm"><?
print("<tr><td class=\"zaliwka\" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;\">.:: Настройки сообщений ::.</td></tr>");
print("<tr><td colspan=2> </td></tr>");
tr("Разрешить ЛС от ","<input type='radio' name='acceptpms' ".($CURUSER["acceptpms"] == "yes" ? " checked" : "")." value='yes'>Все (исключая блокированных)<br><input type='radio' name='acceptpms' ".($CURUSER["acceptpms"] == "friends" ? " checked" : "")." value='friends'>Только друзей<br><input type='radio' name='acceptpms' ".($CURUSER["acceptpms"] == "no" ? " checked" : "")." value='no'>Только администрации",1);
tr("Удалять ЛС при ответе  ", "<input type='checkbox' name='deletepms' ".($CURUSER["deletepms"] == "yes" ? " checked" : "").">",1);
tr("Сохранять отправленные ЛС ", "<input type='checkbox' name='savepms' ".($CURUSER["savepms"] == "yes" ? " checked" : "").">",1); ?>
<tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;"></td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn"></td></tr>
</form><?}else{?>
<form method="post" action="takeeditusercp.php?action=personal"><?
print("<tr><td class=\"zaliwka\" colspan='2' height='18' style=\"color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;\">.:: Настройки аккаунта ::.</td></tr>");
print("<tr><td colspan=2> </td></tr>");
$themes = theme_selector($CURUSER["theme"]);
$countries = "<option value=0>---- Не выбрано ----</option>\n";
$ct_r = mysql_query("SELECT id,name FROM countries ORDER BY name") or die;
while ($ct_a = mysql_fetch_array($ct_r))
$countries .= "<option value=$ct_a[id]".($CURUSER["country"] == $ct_a['id'] ? " selected" : "").">$ct_a[name]</option>";
tr($tracker_lang['my_gender'],"<input type=radio name=gender".($CURUSER["gender"] == "1" ? " checked" : "")." value=1>
".$tracker_lang['my_gender_male']."<input type=radio name=gender".($CURUSER["gender"] == "2" ? " checked" : "")." value=2>
".$tracker_lang['my_gender_female']."<input type=radio name=gender".($CURUSER["gender"] == "3" ? " checked" : "")." value=3> Трансгендер",1);
///////////////// BIRTHDAY MOD /////////////////////
$birthday = $CURUSER['birthday'];$birthday = date('Y-m-d', strtotime($birthday));
list($year1, $month1, $day1) = explode('-', $birthday);
if($CURUSER['birthday'] == '0000-00-00'){
$year .= "<select name=year><option value=\"0000\">".$tracker_lang['my_year']."</option>";$i = "1950";
while($i <= (date('Y',time())-13)){$year .= "<option value=" .$i. ">".$i."</option>";$i++;}
$year .= "</select>";
$birthmonths = array(
        "01" => $tracker_lang['my_months_january'],
        "02" => $tracker_lang['my_months_february'],
        "03" => $tracker_lang['my_months_march'],
        "04" => $tracker_lang['my_months_april'],
        "05" => $tracker_lang['my_months_may'],
        "06" => $tracker_lang['my_months_june'],
        "07" => $tracker_lang['my_months_jule'],
        "08" => $tracker_lang['my_months_august'],
        "09" => $tracker_lang['my_months_september'],
        "10" => $tracker_lang['my_months_october'],
        "11" => $tracker_lang['my_months_november'],
        "12" => $tracker_lang['my_months_december'], );
        $month = "<select name=\"month\"><option value=\"00\">".$tracker_lang['my_month']."</option>";
foreach ($birthmonths as $month_no => $show_month){$month .= "<option value=$month_no>$show_month</option>";}
$month .= "</select>";
$day .= "<select name=day><option value=\"00\">".$tracker_lang['my_day']."</option>";$i = 1;
while ($i <= 31){if($i < 10){$day .= "<option value=0".$i. ">0".$i."</option>";}else{$day .= "<option value=".$i.">".$i."</option>";}$i++;}
$day .="</select>";
tr($tracker_lang['my_birthdate'], $year . $month . $day ,1);}
if($CURUSER['birthday'] != "0000-00-00"){
tr($tracker_lang['my_birthdate'],"<b><input type=hidden name=year value=$year1>$year1<input type=hidden name=month value=$month1>.$month1<input type=hidden name=day value=$day1>.$day1</b>",1);}
///////////////// BIRTHDAY MOD /////////////////////
if($CURUSER["stops"]=="no"){
tr("Связь", "<table cellspacing=\"3\" cellpadding=\"0\" width=\"100%\" border=\"0\">
<tr><td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\" colspan=2>
".$tracker_lang['my_contact_descr']."</td></tr>
<tr><td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\">
Telegram<br><img alt src='pic/tlgr.png'><input maxLength=\"30\" size=\"25\" name=\"telgr\" value=\"".htmlspecialchars_uni($CURUSER["telgr"])."\" ></td>
<td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\">
".$tracker_lang['my_contact_skype']."<br><img alt src=pic/contact/skype.gif width=\"17px\" height=\"17\">
<input maxLength=\"32\" size=\"25\" name=\"skype\" value=\"".htmlspecialchars_uni($CURUSER["skype"])."\" ></td></tr></table>",1);
tr( $tracker_lang ['my_website'], "<input type=\"text\" name=\"website\" size=50 value=\"".htmlspecialchars_uni($CURUSER["website"])."\"> ", 1);
}else{
///////////
tr("Связь", "<table cellspacing=\"3\" cellpadding=\"0\" width=\"100%\" border=\"0\">
<tr><td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\" colspan=2>
".$tracker_lang['my_contact_descr']."</td></tr>
<tr><td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\">
Telegram<br><img alt src='pic/tlgr.png'><input maxLength=\"30\" size=\"25\" name=\"telgr\" value=\"".htmlspecialchars_uni($CURUSER["telgr"])."\" disabled ></td>
<td style=\"font-size: 11px; font-style: normal; font-variant: normal; font-weight: normal; font-family: verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif\">
".$tracker_lang['my_contact_skype']."<br><img alt src=pic/contact/skype.gif width=\"17px\" height=\"17\">
<input maxLength=\"32\" size=\"25\" name=\"skype\" value=\"".htmlspecialchars_uni($CURUSER["skype"])."\" disabled ></td></tr></table>",1);
tr( $tracker_lang ['my_website'], "<input type=\"text\" name=\"website\" size=50 value=\"".htmlspecialchars_uni($CURUSER["website"])."\" disabled> ", 1);}
tr("Вид интерфейса", "$themes",1);
tr("Страна", "<select name=country>$countries</select>",1);
tr("Торрентов на страницу", "<input type=text size=10 name=torrentsperpage value=$CURUSER[torrentsperpage]> (0=установки по умолчанию)",1);
tr("Тем на страницу", "<input type=text size=10 name=topicsperpage value=$CURUSER[topicsperpage]> (0=установки по умолчанию)",1);
tr("Сообщений на страницу", "<input type=text size=10 name=postsperpage value=$CURUSER[postsperpage]> (0=установки по умолчанию)",1);
?><tr><td class="zaliwka" colspan='2' height='18' style="color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;"></td></tr><tr><td colspan="2" style="border:0;" height="30" align="center"><br>
<input type="submit" value="Обновить профиль" class="btn">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="reset" value="Сбросить настройки" class="btn"></td></tr>
</form><?}?></table></td><td valign="top" width="50px" style="border:0;"></td><td width='150px' valign='top' style="border:0;"><table style="border:0;">
<tr><td class="zaliwka" colspan='2' height='18' style="width:150px;color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">Ваш аватар</td></tr>
<?if($CURUSER[avatar]){?><tr><td style="border:0;"><img width='150px' src="<?=$CURUSER["avatar"];?>"></td></tr><?}else{?>
<tr><td style="border:0;"><img width='150px' src='pic/default_avatar.gif'></td></tr><?}?>
<tr><td class="zaliwka" colspan='2' height='18' style="width:150px;color:#FFFFFF;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">.:: Ваше меню ::.</td></tr>
<tr><td style="border:0;" height='18'><center><a href='usercp_avatar'>Настройки Аватара</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='usercp_signature'>Настройки подписи</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='usercp_pm'>Настройки сообщений</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='usercp_security'>Настройки защиты</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='usercp_personal'>Настройки аккаунта</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='rqst'>Вопрос/Ответ</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='invite'>Мои приглашения</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='myrelease'>Мои Релизы</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='bookmarks'>Мои закладки</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='friends'>Мои друзья</a></center></td></tr>
<tr><td style="border:0;" height='18'><center><a href='mybonus'>Мои бонусы</a></center></td></tr>
</table></td></tr></table><?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>