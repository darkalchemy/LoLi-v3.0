<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
function bark($msg){stderr("<center><b>Произошла ошибка</b></center>", $msg);}
$action = $_GET["action"];$updateset = array();if(!$_GET["action"]){header('Location: '.$DEFAULTBASEURL);exit();}else{if($action == "avatar"){
function uploadavatar(){global $CURUSER, $tracker_lang, $avatar_max_width, $avatar_max_height, $rootpath, $CacheBlock;$maxavatarsize = 1024000; // 100kb 
$userid = $CURUSER["id"];$avatarname = $CURUSER["avatar"]; 
$allowed_types = array("image/gif" => "gif", "image/pjpeg" => "jpg", "image/jpeg" => "jpg", "image/jpg" => "jpg", "image/png" => "png"); 
if(!($_FILES['avatar']['name'] == "")){$uploaddir = "pic/avatar/";$ifile = $_FILES['avatar']['tmp_name']; 
$ifilename = "avatar_".$userid.substr($_FILES['avatar']['name'], strlen($_FILES['avatar']['name'])-4, 4); 
if(!array_key_exists($_FILES['avatar']['type'], $allowed_types)) bark("<center><b>Неверный тип файла для аватара!</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_avatar'></head></html>"); 
if(!preg_match('/^(.+)\.(jpg|jpeg|png|gif)$/si', $_FILES['avatar']['name'])) bark("<center><b>Неверное имя файла (не картинка).</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_avatar'></head></html>"); 
list($width, $height) = getimagesize($ifile); 
if($width > $avatar_max_width || $height > $avatar_max_height) bark(sprintf($tracker_lang['avatar_is_too_big'], $avatar_max_width, $avatar_max_height)); 
if($_FILES['avatar']['size'] > $maxavatarsize) bark("<center><b>Аватар весит больше 1mb</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_avatar'></head></html>"); 
if($avatarname != ""){$img = $avatarname;$del = unlink($img);}$copy = copy($ifile, $uploaddir.$ifilename); 
if (!$copy) bark("<center><b>Аватар не загружена</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_avatar'></head></html>"); 
return $uploaddir.$ifilename;}}
$_GLOBALS["avatar_act"] = $_POST["avatar_act"]; 
$res = sql_query("SELECT avatar FROM users WHERE id=".$CURUSER['id']) or sqlerr(__FILE__, __LINE__);$arr = mysql_fetch_array($res); 
if($_GLOBALS["avatar_act"] == "keep"){bark("<center><b>И чё ты хочешь сделать? Оставить аватар или обновить? Выбери правильно что те надо, даун!</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_avatar'></head></html>");}
if($_GLOBALS["avatar_act"] == "update") $updateset[] = "avatar = ".sqlesc(uploadavatar()); 
if($_GLOBALS["avatar_act"] == "delete"){if($arr["avatar"]){$del = unlink($arr["avatar"]);$updateset[] = "avatar = ''";}}$action = "usercp_avatar";}
elseif($action == "signature"){$info = unesc($_POST["info"]);$updateset[] = "info = ".sqlesc($info);$action = "usercp_signature";}
elseif($action == "security"){
if(!mkglobal("email:oldpassword:chpassword:passagain")) bark("<center><b>Missing form data</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
$updateset = array();$changedemail = 0;function validpassword($chpassword){if($chpassword == "") return false;
$allowedchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&><^*-|_";
for ($i = 0; $i < strlen($chpassword); ++$i)if(strpos($allowedchars, $chpassword[$i]) === false) return false;return true;}
if($chpassword != ""){
if(!validpassword($chpassword)) bark("<center><b>Only English letters and numbers are allowed!</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
if (strlen($chpassword) > 40) bark("<center><b>Извините, ваш пароль слишком длинный (максимум 40 символов)</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
if ($chpassword != $passagain) bark("<center><b>Пароли не совпадают. Попробуйте еще раз.</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
if ($CURUSER["passhash"] != md5($CURUSER["secret"] . $oldpassword . $CURUSER["secret"])) bark("<center><b>Вы ввели неправильный старый пароль.</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
$sec = mksecret();$passhash = md5($sec . $chpassword . $sec);$updateset[] = "secret = " . sqlesc($sec);
$updateset[] = "passhash = " . sqlesc($passhash);logincookie($CURUSER["id"], $passhash);}
if($email != $CURUSER["email"]){if(!validemail($email))
bark("<center><b>Это не похоже на настоящий E-Mail.</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
$r = mysql_query("SELECT id FROM users WHERE email=".sqlesc($email)) or sqlerr(__FILE__, __LINE__);
if (mysql_num_rows($r) > 0)
bark("<center>Этот e-mail адрес уже используется одним из пользователей трекера. (<b>$email</b>)</center><html><head><meta http-equiv=refresh content='5;url=usercp_security'></head></html>");
$changedemail = 1;}
////////////////////
$parked = $_POST["parked"];$updateset[] = "parked = ".sqlesc($parked);
/////////////////////
$hide = $_POST["hide"];$updateset[] = "hide = ".sqlesc($hide);
////////////////////
$hide_seeder = ($_POST["hide_seeder"] != "" ? "yes" : "no");$updateset[] = "hides = '$hide_seeder'";
///////////////////
$hide_leeching = ($_POST["hide_leeching"] != "" ? "yes" : "no");$updateset[] = "hiders = '$hide_leeching'";
///////////////////////
$hide_reliz = ($_POST["hide_reliz"] != "" ? "yes" : "no");$updateset[] = "hider = '$hide_reliz'";
///////////////////////
$hide_invayted = ($_POST["hide_invayted"] != "" ? "yes" : "no");$updateset[] = "invayted = '$hide_invayted'";
///////////////////////
$hide_invayt = ($_POST["hide_invayt"] != "" ? "yes" : "no");$updateset[] = "invayt = '$hide_invayt'";
//////////////////////////////////
$hide_bonusss = ($_POST["hide_bonusss"] != "" ? "yes" : "no");$updateset[] = "bonusss = '$hide_bonusss'";
////////////////////////////////////
$multikoff = ($_POST["multikoff"] != "" ? "yes" : "no");$updateset[] = "multik = '$multikoff'";
////////////// PASSKEY MOD //////////////////
if ($_POST['resetpasskey']) $updateset[] = "passkey=''";
$updateset[] = "passkey_ip = ".($_POST["passkey_ip"] != "" ? sqlesc(getip()) : "''");$urladd = "";$action = "usercp_security";}
elseif($action == "personal"){$year = $_POST["year"];$month = $_POST["month"];$day = $_POST["day"];
if($year == '0000' || $month == '00' || $day == '00') stderr("Error", "<center>It looks like you entered an incorrect date of birth</center><html><head><meta http-equiv=refresh content='5;url=/'></head></html>");
$birthday = date("$year.$month.$day");$updateset[] = "birthday = '$birthday'";$theme = $_POST["theme"];$country = $_POST["country"];
$gender = $_POST["gender"];$updateset[] = "gender =  " . sqlesc($gender);$telgr = unesc($_POST["telgr"]);
if (strlen($telgr) > 40) bark("<center><b>Жаль, Ваш Telegram слишком длинный  (Макс - 40)</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_personal'></head></html>");
$updateset[] = "telgr = " . sqlesc($telgr);$skype = unesc($_POST["skype"]);
if (strlen($skype) > 40) bark("<center><b>Жаль, Ваш Skype слишком длинный  (Макс - 40)</b></center><html><head><meta http-equiv=refresh content='5;url=usercp_personal'></head></html>");
$updateset[] = "skype = " . sqlesc($skype);$website = unesc($_POST["website"]);$updateset[] = "website = " . sqlesc($website);
$updateset[] = "torrentsperpage = " . min(100, 0 + $_POST["torrentsperpage"]);
$updateset[] = "topicsperpage = " . min(100, 0 + $_POST["topicsperpage"]);
$updateset[] = "postsperpage = " . min(100, 0 + $_POST["postsperpage"]);
if(is_theme($theme)) $updateset[] = "theme = ".sqlesc($theme);
if(is_valid_id($country)) $updateset[] = "country = $country";$action = "usercp_personal";}elseif($action == "pm"){$acceptpms = $_POST["acceptpms"];
$deletepms = ($_POST["deletepms"] != "" ? "yes" : "no");$savepms = ($_POST["savepms"] != "" ? "yes" : "no");
$r = mysql_query("SELECT id FROM categories") or sqlerr(__FILE__, __LINE__);$rows = mysql_num_rows($r);
$updateset[] = "acceptpms = " . sqlesc($acceptpms);
$updateset[] = "deletepms = '$deletepms'";$updateset[] = "savepms = '$savepms'";$action = "usercp_pm";}
if($changedemail){	
$sec = mksecret();$hash = md5($sec . $email . $sec);$obemail = urlencode($email);$updateset[] = "editsecret = " . sqlesc($sec);
$thisdomain = preg_replace('/^www\./is', "", $DEFAULTBASEURL);
$body = <<<EOD

You have requested that your user profile (username {$CURUSER["username"]})
on $thisdomain should be updated with this email address ($email) as
user contact.
If you did not do this, please ignore this email. The person who entered your
email address had the IP address {$_SERVER["REMOTE_ADDR"]}. Please do not reply.
To complete the update of your user profile, please follow this link:

$DEFAULTBASEURL/confirmemail.php?id={$CURUSER["id"]}&confirmcode=$hash&email=$obemail

Your new email address will appear in your profile after you do this. Otherwise
your profile will remain unchanged.

EOD;
if(!sent_mail($email, "$thisdomain profile change confirmation", $body, false)){
write_log("Проблема с отправкой письма на адрес $email", "FF0000", "error");$action = "usercp_security&mailsent=1";}else{$action = "usercp_security&mailsent=1";}}
mysql_query("UPDATE users SET ".implode(",", $updateset)." WHERE id = ".$CURUSER["id"]) or sqlerr(__FILE__,__LINE__);
////////////////////////
$flist = $rootpath."include/user_cache/user_".$CURUSER["id"].".cache";if(file_exists($flist)){unlink($rootpath."include/user_cache/user_".$CURUSER["id"].".cache");}
header("Location: $action");}}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>
