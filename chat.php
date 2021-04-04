<?php require_once("include/bittorrent.php");dbconn(true);gzip();if($CURUSER && get_user_class() >= UC_UPLOADER){stdhead('Приват-ЧАТ');
if (get_user_class() >= UC_ADMINISTRATOR){$clenchat = ":: <a class=altlink href='clear1.php?action=clearshout'><b>Oчистить чат</b></a>";}
?><table style="background:none;cellspacing:0;cellpadding:0;width:100%;float:center;"><tr>
<td style="border-radius:15px;border:none;" class='a'><table style="background:none;width:100%;float:center;border:0;"><tr>
<td class="zaliwka" style="color:#FFFFFF;colspan:14;height:20px;font-family:cursive;font-weight:bold;font-size:14px;text-align:center;border:0;border-radius:5px;">
.:: Приват-ЧАТ <?=$clenchat?> ::.</td></tr><tr><td align="center" style="background:none;width:100%;float:center;border:0;">
<table style='background:none;border:0;' cellspacing="0" cellpadding="5" width="100%"><script>
function SmileIT(e,n,o){window.document.forms[n].elements[o].value=window.document.forms[n].elements[o].value+" "+e+" ",window.document.forms[n].elements[o].focus()}</script>
<form action="shoutbox.php" style='background:none;border:0;' method="post" name="shoutform" onsubmit="return sendShout(this);">
<table cellspacing="0" style='background:none;border:0;' cellpadding="5" width="100%">
<tr><td style='background:none;border:0;'><div id="shoutbox" style='overflow:auto;height:300px;width:100%;padding-top:0cm'>Загрузка...</div></td>
<td style="white-space:nowrap;background:none;border:0;" valign="top" width="12%"><font color="darkgreen"><b>Online:</b></font><hr width="100%"><div>
<?$result = sql_query("SELECT uid, username, class FROM sessions GROUP BY username ORDER BY class DESC");
while(list($uid, $uname, $class) = mysql_fetch_row($result)){if(!empty($uname)){
$contentd .= "<span onclick=\"parent.document.shoutform.shout.focus();parent.document.shoutform.shout.value='privat($uname) '+parent.document.shoutform.shout.value;return false;\" style=\"cursor: pointer; color: red; font-weight: bold;\">P</span> <a class=user href=\"user_".$uid."\" onClick=\"parent.document.shoutform.shout.focus();parent.document.shoutform.shout.value='[b]".$uname."[/b]: '+parent.document.shoutform.shout.value;return false;\"><b>".get_user_class_color($class, $uname)."</b></a><br>";}}
print($contentd."</div>");?><br></td></tr><tr><td style='background:none;border:0;white-space:nowrap' colspan="2" width="100%">
<input type="text" name="shout" style="width:70%" MAXLENGTH="300"><input type="submit" value="Отправить"><input type="button" value="Все смайлы" onClick="javascript:winop()"></td>
</tr><tr><td style='background:none;border:0;' colspan="2" align="left">
<a href="javascript: SmileIT(':ah:','shoutform','shout')"><img border='0' src='pic/smilies/ah.gif' height="40"></a>
<a href="javascript: SmileIT(':angry2:','shoutform','shout')"><img border='0' src='pic/smilies/angry2.gif' height="40"/></a>
<a href="javascript: SmileIT(':bah:','shoutform','shout')"><img border='0' src='pic/smilies/bah.gif' height="40"/></a>
<a href="javascript: SmileIT(':bye:','shoutform','shout')"><img src='pic/smilies/bye.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':cool2:','shoutform','shout')"><img border='0' src='pic/smilies/cool.gif' height="40"/></a>
<a href="javascript: SmileIT(':cry:','shoutform','shout')"><img border='0' src='pic/smilies/cry1.gif' height="40"/></a>
<a href="javascript: SmileIT(':cry2:','shoutform','shout')"><img border='0' src='pic/smilies/cry2.gif' height="40"/></a>
<a href="javascript: SmileIT(':cry3:','shoutform','shout')"><img src='pic/smilies/cry3.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':good:','shoutform','shout')"><img src='pic/smilies/good.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':haha:','shoutform','shout')"><img src='pic/smilies/haha.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':happy:','shoutform','shout')"><img src='pic/smilies/happy.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':hehe:','shoutform','shout')"><img src='pic/smilies/hehe.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':hi2:','shoutform','shout')"><img src='pic/smilies/hi.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':hm:','shoutform','shout')"><img src='pic/smilies/hmm.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':huh2:','shoutform','shout')"><img src='pic/smilies/huh.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':dead:','shoutform','shout')"><img src='pic/smilies/imdead.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':khekhe:','shoutform','shout')"><img src='pic/smilies/khekhe.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':roar:','shoutform','shout')"><img src='pic/smilies/roar.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':stfu:','shoutform','shout')"><img src='pic/smilies/stfu.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':tired:','shoutform','shout')"><img src='pic/smilies/tired1.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':uhuh:','shoutform','shout')"><img src='pic/smilies/uhuh.gif' height="40" border='0'/></a>
<a href="javascript: SmileIT(':wat:','shoutform','shout')"><img src='pic/smilies/wat1.gif' height="40" border='0'/></a></td></tr></table></form>
<div id="loading-layer" style="display:none;font-family:Lucida Sans Unicode;font-size:11px;width:200px;height:50px;background:#EDFCEF;padding:10px;text-align:center;border:1px solid #778899">
</div><script>
function winop(){windop=window.open("moresmiless.php?form=shoutform&text=shout","mywin","height=400,width=500,resizable=no,scrollbars=yes")}function sendShout(e){if(Shout=e.shout.value,""==Shout.replace(/ /g,""))return alert("Вы должны вести сообщение!"),!1;sb_Clear();var t=new tbdev_ajax;t.onShow("");return t.requestFile="shoutbox.php",t.setVar("do","shout"),t.setVar("shout",encodeURIComponent(Shout)),t.method="GET",t.element="shoutbox",t.sendAJAX(""),!1}function getShouts(){var e=new tbdev_ajax;e.onShow=function(){};return e.requestFile="shoutbox.php",e.method="GET",e.element="shoutbox",e.sendAJAX(""),setTimeout("getShouts();",1e4),!1}function sb_Clear(){return!(document.forms.shoutform.shout.value="")}function deleteShout(e){if(confirm("Вы точно хотите удалить это сообщение?")){var t=new tbdev_ajax;t.onShow=function(){};t.requestFile="shoutbox.php",t.setVar("do","delete"),t.setVar("id",e),t.method="GET",t.element="shoutbox",t.sendAJAX("")}return!1}getShouts();
</script></table><?end_frame();stdfoot();}else{?><html><head><meta http-equiv='refresh' content='0;url=/'></head>
<body style="background:#2F4F4F no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;"></body></html><?}?>