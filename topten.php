<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER){
//////////////////////////////
function createtabs($tabs, $activetab, $title = '', $width = '100%'){	
$result = '';$count = count($tabs);$num = 0;if($count){
$width  = preg_match('/^(\d{1,4})(%|px)*$/', $width) ? ' width="'.$width.'"' : '';
$result = "\r\n\t<table class=\"tabs\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"".$width.">\r\n\t\t<tr>\r\n";
foreach($tabs as $tabname => $tabtitle){$num++;$curactivetab = ($tabname == $activetab);
if($num == 1)$result .= "\t\t\t".($curactivetab ? "<td><img src=\"pic/tabs/begin_active.gif\" border=\"0\"></td>" : "<td><img src=\"pic/tabs/begin.gif\" border=\"0\"></td>")."\r\n";
elseif($curactivetab)$result .= "\t\t\t<td><img src=\"pic/tabs/div_active_in.gif\" border=\"0\"></td>\r\n";
elseif(!$prevactive)$result .= "\t\t\t<td><img src=\"pic/tabs/div.gif\" border=\"0\"></td>\r\n";
$result .= "\t\t\t".($curactivetab ? "<td class=\"active\">&nbsp;".strip_tags($tabtitle)."&nbsp;</td>" : "<td class=\"notactive\">&nbsp;".$tabtitle."&nbsp;</td>")."\r\n";
if($num == $count)$result .= "\t\t\t".($curactivetab ? "<td><img src=\"pic/tabs/end_active.gif\" border=\"0\"></td>" : "<td><img src=\"pic/tabs/end.gif\" border=\"0\"></td>")."\r\n";
elseif($curactivetab)$result .= "\t\t\t<td><img src=\"pic/tabs/div_active_out.gif\" border=\"0\"></td>\r\n";$prevactive = $curactivetab;}
$result .= "\t\t\t<td class=\"space\">".$title."</td>\r\n\t\t</tr>\r\n\t</table>\r\n";}echo $result;}
/////////////////////////////////
function usertable($res, $hcol = '', $width = '100%'){
$width = preg_match('/^(\d{1,4})(%|px)*$/', $width) ? ' width="'.$width.'"' : '';?>
<table border="0" cellspacing="0" cellpadding="5" class="ustats"<?php echo $width; ?>><tr>
<td class="head">Место</td><td class="head" align="left">Пользователь</td><td class="head" align="right">Раздал</td><td class="head" align="right">Скорость раздачи</td>
<td class="head" align="right">Скачал</td><td class="head" align="right">Скорость закачки</td><td class="head" align="right">Рейтинг</td>
<td class="head" align="right">Бонус</td><td class="head" align="right">Комм.</td><td class="head" align="right">Сидирует</td>
<td class="head" align="right">Поблагодарили</td><td class="head" align="left">Зарегистрирован</td></tr>
<?php $num = 0;while($a = mysql_fetch_assoc($res)){
if($hcol == 'comments' && !$a['commentsnum'])continue;
++$num;$highlightrow = ($CURUSER["id"] == $a["userid"]);		
foreach(explode(':', 'uploaded:upspeed:downloaded:downspeed:ratio:bonus:comments:seeder:simpaty:none') as $col){
if($highlightrow && $hcol == $col && $hcol != 'none')$styleclass[$col] = 'hccell';
elseif(!$highlightrow && $hcol == $col && $hcol != 'none')$styleclass[$col] = 'hvcell';
elseif($highlightrow && $hcol != $col)$styleclass[$col] = 'hhcell';else $styleclass[$col] = 'cell';}
if($a["downloaded"]){$ratio = $a["uploaded"] / $a["downloaded"];$color = get_ratio_color($ratio);$ratio = number_format($ratio, 2);
if($color)$ratio = "<font color='$color'>$ratio</font>";}else $ratio = "Inf.";
if($a['userid'] == $CURUSER['id']){
$bonus = '<A href="mybonus" class="online">'.$a["bonus"].'</A>';
$comments = $a['commentsnum'] ? '<A href="usercom_'.$a['userid'].'" class="online">'.$a['commentsnum'].'</A>' : $a['commentsnum'];$seeder = $a['seeder'];$simpaty = $a['simpaty'];
}elseif(get_user_class() >= UC_MODERATOR){
$bonus = $a["bonus"];
$comments = $a['commentsnum'] ? '<A href="usercom_'.$a['userid'].'" class="online">'.$a['commentsnum'].'</A>' : $a['commentsnum'];$seeder = $a['seeder'];$simpaty = $a['simpaty'];
}else{$bonus = $a["bonus"];$comments = $a['commentsnum'];$seeder = $a['seeder'];$simpaty = $a['simpaty'];}
$username = '<a href="user_'.$a["userid"].'">'.get_user_class_color($a["class"], $a["username"]).'</a>';
echo "\t\t<tr>\r\n\t\t\t<td class=\"".$styleclass['none']."\" align='center'>$num</td>\r\n";
echo "\t\t\t<td class='".$styleclass['none']."' align='left'>".$username."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['uploaded']."' align='right'>".mksize($a["uploaded"])."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['upspeed']."' align='right'>".mksize($a["upspeed"])."/s</td>\r\n";
echo "\t\t\t<td class='".$styleclass['downloaded']."' align='right'>".mksize($a["downloaded"])."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['downspeed']."' align='right'>".mksize($a["downspeed"])."/s</td>\r\n";
echo "\t\t\t<td class='".$styleclass['ratio']."' align='right'>".$ratio."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['bonus']."' align='right'>".$bonus."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['comments']."' align='right'>".$comments."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['seeder']."' align='right'>".$seeder."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['simpaty']."' align='right'>".$simpaty."</td>\r\n";
echo "\t\t\t<td class='".$styleclass['none']."' align='left'>".date("Y-m-d",strtotime($a["added"]))." (".get_elapsed_time(sql_timestamp_to_unix_timestamp($a["added"]))." назад)</td>\r\n";
echo "\t\t</tr>\r\n";}
if(!$num)echo '<tr><td colspan="12" align="center">Нет записи.</td></tr>';
echo '<tr><td colspan="12" class="foot"><A href="#top" onclick="blur();"><DIV>&#65085;</DIV></A></td></tr></TABLE><BR />';}
////////////////////////////////////
$lim = isset($_GET["lim"]) ? (int)$_GET["lim"] : false;$type = isset($_GET["type"]) ? $_GET["type"] : false;if(!($lim == 10 || $lim == 100 || $lim == 250))$lim = 10;
if(!($type == 'uploaded' || $type == 'downloaded' || $type == 'upspeed' || $type == 'downspeed' || $type == 'bestshare' || $type == 'comments' || $type == 'bonus' || $type == 'seeder' || $type == 'simpaty')){$limit = 10;}else{$limit = $lim;}
/////////////////////////
stdhead("Top Сайта");begin_frame(".: Top Сайта ::.");
$mysql_query = "SELECT users.id as userid, users.username, users.class, users.seeder, users.simpaty, users.comreliz AS commentsnum, users.added, users.uploaded, users.downloaded, 
users.bonus, users.uploaded / (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(users.added)) AS upspeed, 
users.downloaded / (UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(users.added)) AS downspeed FROM users WHERE enabled = 'yes'";
$tops['uploaded'] = array('query' => $mysql_query.' AND uploaded > 0 GROUP BY users.id ORDER BY uploaded DESC LIMIT ', 'highlightcol' => 'uploaded', 'title_rightpart' => 'раздающих');
$tops['downloaded'] = array('query' => $mysql_query.' AND downloaded > 0 GROUP BY users.id ORDER BY downloaded DESC LIMIT ', 'highlightcol' => 'downloaded', 'title_rightpart' => 'качающих');
$tops['upspeed'] = array('query' => $mysql_query.' AND uploaded > 0 GROUP BY users.id ORDER BY upspeed DESC LIMIT ', 'highlightcol' => 'upspeed', 'title_rightpart' => 'быстрейших раздающих <font class=small>(среднее, включая период неактивности)</font>');
$tops['downspeed']  = array('query' => $mysql_query.' AND downloaded > 0 GROUP BY users.id ORDER BY downspeed DESC LIMIT ', 'highlightcol' => 'downspeed', 'title_rightpart' => 'быстрейших качающих <font class=small>(среднее, включая период неактивности)</font>');
$tops['bestshare'] = array('query' => $mysql_query.' AND downloaded > 1073741824 AND uploaded > 0 GROUP BY users.id ORDER BY uploaded / downloaded DESC, uploaded DESC LIMIT ', 'highlightcol' => 'ratio', 'title_rightpart' => 'лучших раздающих <font class=small>(минимум 1 GB скачано)</font>');
$tops['comments'] = array('query' => $mysql_query.' GROUP BY users.id ORDER BY commentsnum DESC LIMIT ', 'highlightcol' => 'comments', 'title_rightpart' => 'флудеров');
$tops['bonus'] = array('query' => $mysql_query.' AND bonus > 0 GROUP BY users.id ORDER BY bonus DESC LIMIT ', 'highlightcol' => 'bonus', 'title_rightpart' => 'бонусов');
$tops['seeder'] = array('query' => $mysql_query.' AND seeder > 0 GROUP BY users.id ORDER BY seeder DESC LIMIT ', 'highlightcol' => 'seeder', 'title_rightpart' => ' по колличеству сидируемых раздач');
$tops['simpaty'] = array('query' => $mysql_query.' AND simpaty > 0 GROUP BY users.id ORDER BY simpaty DESC LIMIT ', 'highlightcol' => 'simpaty', 'title_rightpart' => ' по благодарностям');
echo "<table border='0' cellpadding='0' cellspacing='0' width='100%'><tbody><tr><td class='bottom'>";
foreach($tops as $toptype => $top){
if($toptype != $type)$limit = 10;else $limit = $lim;$sqlresult = sql_query($top['query'].$limit) or sqlerr(__FILE__, __LINE__);
$tabs['10'] = '<A href="topten.php#'.$toptype.'">Top 10</A>';
$tabs['100'] = '<A href="topten.php?type='.$toptype.'&amp;lim=100#'.$toptype.'">Top 100</A>';
$tabs['250'] = '<A href="topten.php?type='.$toptype.'&amp;lim=250#'.$toptype.'">Top 250</A>';echo '<A name="'.$toptype.'"></A>';
createtabs($tabs, $limit, '<DIV style="padding-left: 150px; text-align: left;">Top&nbsp;'.$limit.'&nbsp;'.$top['title_rightpart'].'</DIV>');
usertable($sqlresult, $top['highlightcol']);}echo "</td></tr></tbody></table>";end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>