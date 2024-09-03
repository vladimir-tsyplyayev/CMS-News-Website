<?php
session_start();
set_time_limit(0);

$ajax=isset($_POST['ajax']) ? 1 : 0;

$thescript='';

for($tlen=strlen($_SERVER['SCRIPT_NAME']),$i=$tlen-1;$i>=0;$i--)
{
  if($_SERVER['SCRIPT_NAME']{$i}=='/') break;
  $thescript=$_SERVER['SCRIPT_NAME']{$i}.$thescript;
}

if(!function_exists('socket_connect'))
  die("The function socket_connect does not exist! You cannot use this script.");

$ver='1.2';
if(!$ajax)
{
print <<<HERE
<html><head>
<title>SMS Mail.ru Messenger by DX $ver</title>
<style>
td
{
border-width:1px 1px 1px 1px;
border-style:solid;
border-color:black;
}
INPUT
{
BORDER-RIGHT: rgb(50,50,50) 1px outset;
BORDER-TOP: rgb(50,50,50) 1px outset;
FONT-SIZE: 11px;
font-family:Arial;
BORDER-LEFT: rgb(50,50,50) 1px outset;
BORDER-BOTTOM: rgb(50,50,50) 1px outset;
}
button
{
BORDER-RIGHT: rgb(50,50,50) 1px outset;
BORDER-TOP: rgb(50,50,50) 1px outset;
FONT-SIZE: 10px;
BORDER-LEFT: rgb(50,50,50) 1px outset;
BORDER-BOTTOM: rgb(50,50,50) 1px outset;
width:50px;
}
textarea
{
BORDER-RIGHT: rgb(50,50,50) 1px outset;
BORDER-TOP: rgb(50,50,50) 1px outset;
BORDER-LEFT: rgb(50,50,50) 1px outset;
BORDER-BOTTOM: rgb(50,50,50) 1px outset;
FONT-SIZE: 13px;
font-family:Arial;
}
select
{
FONT-SIZE: 10px;
background-color:#f4f4ff;
}
a,a:active,a:visited
{
background: transparent;
color: #34498B;
text-decoration: none;
font-weight:700;
font-size:10;
font-family:Arial;
background-color:wheat;
}
a:hover
{
background: transparent;
color: blue;
font-weight:700;
font-family:Arial;
font-size:10;
text-decoration: none;
background-color:yellow;
}
</style>
</head>
<body>
<table style="border-width:1px 1px 1px 1px; border-style:solid; border-collapse:collapse; border-color:black; width:100%; height:100%">
<tr><td colspan=2 align=center style="font-size:18;height:10">SMS Mail.ru Messenger By DX $ver</td></tr>
<tr valign=top><td><span id="name1">Аккаунты, с которых производить рассылку</span><hr><textarea style="width:500px;height:350px" id="accs"></textarea>
<div id="stats" style="display:none;padding:4px;width:500px;height:350;overflow:auto;border-width:1px 1px 1px 1px;border-color:black;border-style:solid;"></div>
<br><div id="scrl2" style="display:none;""><input type="checkbox" checked id="scrl"> Авто-скролл логов
<br><span id="addstats"></span></div>
<br><span id="name2">Впишите аккаунты в таком виде:<br><tt>mail:pass</tt><br>по одному аккаунту в каждой строке.</span></td><td style="width:290">Опции рассылки<hr>
<div id="opts">
<a href="#" onclick="chtab(1);return false;">Инфо</a> <a href="#" onclick="chtab(2);return false;">Рассылка</a>
  <a href="#" onclick="chtab(3);return false;">Сообщение</a>  <a href="#" onclick="chtab(4);return false;">Прокси</a>
<hr>
<div id="tab1">
Данный скрипт позволяет рассылать смс-сообщения по списку номеров, или какое-то число сообщений на конкретный номер.
HERE;
print '<br'.'><tt'.'>&co'.'py;D'.'X 2'.'008'.'</tt>';
print <<<HERE
</div>
<div id="tab2" style="display:none">
Задержка со стороны клиента: <input type="text" id="wt" value="0" style="width:50"> ms<br>
Задержка со стороны сервера: <input type="text" id="swt" value="2000" style="width:50"> ms<br><br>
Тип рассылки:<br>
<input type="radio" name="stype" value="1" checked> На номер<br>
Номер: <input type="text" id="telnum" value="7xxxxxxxxxx" style="width:90"><br>
Отправить <input type="text" id="mnum" value="1" style="width:50"> сообщений<br>
<br>
<input type="radio" name="stype" value="2"> На список номеров:<br>
<textarea style="width:99%" id='telnums' rows=15>7xxxxxxxxxx</textarea>
</div>
<div id="tab3" style="display:none">
Сообщение:<br>
<textarea rows=20 cols=37 id="txtmsg"></textarea>
<br><input type="button" onclick="setmes();return false;" value="Установить" id="sbtn"><br>
Введите сообщение и нажмите кнопку &quot;Установить&quot;.<br>
Текущее сообщение:<br>
<textarea id="currmsg" rows=5 cols=37 readonly></textarea>
<br><input type="checkbox" id="mrnd">Рандомизировать сообщение
</div>
<div id="tab4" style="display:none">
Список прокси (не обязательно):<br><textarea rows=20 cols=30 id="proxy"></textarea>
<br>Прокси-серверы будут циклически меняться для каждого последующего аккаунта.
</div>
</div>

<div id="msproc" style="display:none">Идёт рассылка...</div>
</td></tr>



<tr><td colspan=2 align=center style="height:20"><input type="button" onclick="startmess()" value="Начать рассылку" id="st"></td></tr>
</table>
<script language='JavaScript'>
var accarr=new Array();
var passarr=new Array();
var ismes=false;
var totalaccs;
var curracc=0;
var k=0;
var maxp;
var stype;
var waittime=1;
var servwaittime=1;
var nregex=/^\d+$/g;
var mmrnd=0;
var currid=0;
var succmess=0;
var nnum=0;
var messet=0;
var tmpmes="";
var telnum=0;
var telnums=Array();
var mnum=0;
var numtels=0;
var sent=0;
var prox=new Array();
var pport=new Array();
var useproxy=false;
var k=0;
var maxp;

function setmes()
{
  messet=0;
  tmpmes=document.getElementById("txtmsg").value;
  sendRequest("act=10&msg="+rpl(escape(tmpmes)));
  document.getElementById("sbtn").disabled=true;
}

function mes_ok(mlen)
{
  messet=mlen;
  document.getElementById("sbtn").disabled=false;
  document.getElementById("currmsg").value=tmpmes;
}


function chtab(num)
{
  hideTabs();
  showTab(num);
}

function hideTabs()
{
  for(var i=1;i<=4;i++)
  {
    document.getElementById("tab"+i).style.display="none";
  }
}

function showTab(num)
{
  document.getElementById("tab"+num).style.display="block";
}


function startmess()
{
  if(ismes)
  {
    if(!sent && !window.confirm("Вы действительно желаете остановить рассылку?"))
    {
      sent=1;
      return;
    }


    ismes=false;
    document.getElementById("accs").style.display="block";
    document.getElementById("st").value="Начать рассылку";
    document.getElementById("stats").style.display="none";
    document.getElementById("name1").innerHTML="Аккаунты, с которых производить рассылку";
    document.getElementById("name2").innerHTML="Впишите аккаунты в таком виде:<br><tt>mail:pass</tt><br>по одному аккаунту в каждой строке.";
    document.getElementById("msproc").style.display="none";
    document.getElementById("opts").style.display="block";
    document.getElementById("scrl2").style.display="none";

    return;
  }

  document.getElementById("accs").value=document.getElementById("accs").value.replace(/^\s\s*/, '').replace(/\s\s*$/, '');


  sent=0;
  curracc=0;
  accarr=new Array();
  passarr=new Array();
  waittime=1;
  currid=0;
  succmess=0;
  sloggingin=0;
  nnum=0;
  telnum=0;
  totalaccs=0;
  numtels=0;
  prox=new Array();
  pport=new Array();
  useproxy=false;
  k=0;

  mmrnd=document.getElementById("mrnd").checked==true ? 1 : 0;

  var tmp;
  var tmp2,cnt2;

  useproxy=false;

  stype=getCheckedValue(document.all.stype);

  if(stype!=1 && stype!=2)
  {
    alert("Выберите тип рассылки.");
    chtab(2);
    return false;
  }

  if(stype==1)
  {
    telnum=document.getElementById("telnum").value;

    if(telnum.search(nregex)==-1 || telnum.length!=11)
    {
      alert("Введите правильный номер телефона.");
      chtab(2);
      return false;
    }

    mnum=document.getElementById("mnum").value;

    if(mnum.search(nregex)==-1 || mnum<1)
    {
      alert("Введите правильное число сообщений для флуда.");
      chtab(2);
      return false;
    }
  }




  tmp=document.getElementById("wt").value;
  if(tmp.search(nregex)==-1)
  {
    alert("Введите правильную величину задержки отправки со стороны клиента.");
    chtab(2);
    return false;
  }

  waittime=Number(tmp)+1;

  tmp=document.getElementById("swt").value;
  if(tmp.search(nregex)==-1)
  {
    alert("Введите правильную величину задержки отправки со стороны сервера.");
    chtab(2);
    return false;
  }

  servwaittime=tmp;

  if(!messet)
  {
    alert("Установите сообщение для рассылки.");
    chtab(3);
    return false;
  }


  if(document.getElementById("accs").value.length==0)
  {
    alert("Введите аккаунты для рассылки/проверки.");
    return false;
  }

  tmp=document.getElementById("accs").value.replace(/\\r/g,"").split("\\n");

  var cnt=tmp.length;

  if(cnt==0)
  {
    alert("Аккаунты введены в неверном формате.");
    return false;
  }

  for(var i=0;i<cnt;i++)
  {
    tmp2=tmp[i].split(":");
    cnt2=tmp2.length;
    if(cnt2<2)
    {
      alert("Аккаунты введены в неверном формате.");
      return false;
    }

    for(var t=2;t<cnt2;t++)
    {
      tmp2[1]+=":"+tmp2[t];
    }

    if(tmp2[0].length==0 || tmp2[1].length==0)
    {
      alert("Аккаунты введены в неверном формате.");
      return false;
    }

    accarr[i]=tmp2[0];
    passarr[i]=tmp2[1];
  }

  totalaccs=cnt;




  if(stype==2)
  {
    tmp=document.getElementById("telnums").value;

    var cnt=tmp.length;

    if(cnt==0)
    {
      alert("Номера введены в неверном формате.");
      return false;
    }

    tmp=tmp.replace(/\\r/g,"").split("\\n");

    var cnt=tmp.length;

    mnum=cnt;

    for(var i=0;i<cnt;i++)
    {
      if(tmp[i].search(nregex)==-1 || tmp[i].length!=11)
      {
        alert("Номера введены в неверном формате.");
        return false;
      }

      telnums[i]=tmp[i];
    }
  }




  if(document.getElementById("proxy").value.length>0)
  {
    tmp=document.getElementById("proxy").value.replace(/\\r/g,"").split("\\n");

    var cnt=tmp.length;

    if(cnt==0)
    {
      alert("Прокси-серверы введены в неверном формате. Используйте ip:port.");
      chtab(4);
      return false;
    }

    for(var i=0;i<cnt;i++)
    {
      tmp2=tmp[i].split(":");
      cnt2=tmp2.length;
      if(cnt2!=2)
      {
        alert("Прокси-серверы введены в неверном формате. Используйте ip:port.");
        chtab(4);
        return false;
      }

      if(tmp2[0].length==0 || tmp2[1].length==0)
      {
        alert("Прокси-серверы введены в неверном формате. Используйте ip:port.");
        chtab(4);
        return false;
      }

      prox[i]=tmp2[0];
      pport[i]=tmp2[1];
    }

    useproxy=true;
    maxp=cnt;
  }






  ismes=true;
  document.getElementById("accs").style.display="none";
  document.getElementById("stats").style.display="block";
  document.getElementById("stats").innerHTML="";
  document.getElementById("name1").innerHTML="Статус рассылки";
  document.getElementById("name2").innerHTML="";
  document.getElementById("st").value="Остановить рассылку";
  document.getElementById("opts").style.display="none";
  document.getElementById("msproc").style.display="block";
  document.getElementById("scrl2").style.display="block";

  document.getElementById("stats").innerHTML="<font color='red'><b>Старт рассылки сообщений...</b></font><br>";

  setStats(0,mnum);
  setTimeout("goMes()",waittime);
}


function setStats(curr,total)
{
  var mleft=total-curr;
  document.getElementById("addstats").innerHTML="Отправлено: "+curr+"; осталось отправить: "+mleft;
}

function goMes()
{
  if(sent) return;

  if(stype==2)
    tnum=telnums[currid];
  else
    tnum=telnum;

  sendRequest("act=1&rd="+mmrnd+"&telnum="+tnum+"&wt="+servwaittime+"&login="+accarr[curracc]+"&pass="+passarr[curracc],1);
  changeProxy();
}



function nextMes(suc)
{
  if(sent) return;
  if(suc)
  {
    nnum++;
    currid++
    addMes("<font color=green>Успешно отправлено сообщение #"+nnum+"</font><br>");
    setStats(nnum,mnum);
  }

  curracc++;
  if(curracc>=totalaccs)
    curracc=0;

  if(nnum>=mnum)
  {
    finishMes();
    return;
  }


  setTimeout("goMes()",waittime);
}


function finishMes()
{
  if(sent) return;
  addMes("<font color=blue>Всё! Отправлено сообщений: "+nnum+".</font><br>");
  sent=1;
}




function getCheckedValue(radioObj)
{
  if(!radioObj)
    return "";

  var radioLength=radioObj.length;
  if(radioLength==undefined)
    if(radioObj.checked)
      return radioObj.value;
    else
     return "";

    for(var i=0;i<radioLength;i++)
    {
      if(radioObj[i].checked)
        return radioObj[i].value;
    }

  return "";
}


function changeProxy()
{
  k++;
  if(k>=maxp) k=0;
}




var lognum=0;


function addMes(msg)
{
  lognum++;
  if(lognum>200)
  {
    lognum=0;
    document.getElementById("stats").innerHTML="";
  }

  document.getElementById("stats").innerHTML=document.getElementById("stats").innerHTML+msg;
  if(document.getElementById("scrl").checked==true) document.getElementById("stats").scrollTop=100000;
}



function createHttpRequest()
{
  var uagent=navigator.userAgent.toLowerCase();
  var is_win=((uagent.indexOf("win")!=-1) || (uagent.indexOf("16bit")!=-1));
  var is_opera=(uagent.indexOf('opera')!=-1);
  var is_webtv=(uagent.indexOf('webtv')!=-1);
  var is_safari=((uagent.indexOf('safari')!=-1) || (navigator.vendor=="Apple Computer, Inc."));
  var is_ie=((uagent.indexOf('msie')!=-1) && (!is_opera) && (!is_safari) && (!is_webtv));

  if(is_ie)
    httpRequest=new ActiveXObject("Microsoft.XMLHTTP");
  else
    httpRequest=new XMLHttpRequest();

  return httpRequest;
}





function sendRequest(params,showprox)
{
  if(sent) return;

  if(useproxy)
  {
    if(params) params=params+"&pr="+prox[k]+"&pp="+pport[k]; else params="pr="+prox[k]+"&pp="+pport[k];
    if(showprox) params=params+"&shp=1";
  }

  if(params) params=params+"&ajax=1"; else params="ajax=1";

  httpRequest.open('POST',"$thescript",true);
  httpRequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  httpRequest.setRequestHeader("Content-length",params.length);
  httpRequest.setRequestHeader("Connection","close");
  httpRequest.onreadystatechange=getRequestx;
  httpRequest.send(params);
}

function getRequestx()
{
  if(httpRequest.readyState==4)
    eval(httpRequest.responseText);
}

var httpRequest=createHttpRequest();

function rpl(st)
{
st=st.replace(/%u0430/g,"%E0");
st=st.replace(/%u0431/g,"%E1");
st=st.replace(/%u0432/g,"%E2");
st=st.replace(/%u0433/g,"%E3");
st=st.replace(/%u0434/g,"%E4");
st=st.replace(/%u0435/g,"%E5");
st=st.replace(/%u0436/g,"%E6");
st=st.replace(/%u0437/g,"%E7");
st=st.replace(/%u0438/g,"%E8");
st=st.replace(/%u0439/g,"%E9");
st=st.replace(/%u043A/g,"%EA");
st=st.replace(/%u043B/g,"%EB");
st=st.replace(/%u043C/g,"%EC");
st=st.replace(/%u043D/g,"%ED");
st=st.replace(/%u043E/g,"%EE");
st=st.replace(/%u043F/g,"%EF");
st=st.replace(/%u0440/g,"%F0");
st=st.replace(/%u0441/g,"%F1");
st=st.replace(/%u0442/g,"%F2");
st=st.replace(/%u0443/g,"%F3");
st=st.replace(/%u0444/g,"%F4");
st=st.replace(/%u0445/g,"%F5");
st=st.replace(/%u0446/g,"%F6");
st=st.replace(/%u0447/g,"%F7");
st=st.replace(/%u0448/g,"%F8");
st=st.replace(/%u0449/g,"%F9");
st=st.replace(/%u044A/g,"%FA");
st=st.replace(/%u044B/g,"%FB");
st=st.replace(/%u044C/g,"%FC");
st=st.replace(/%u044D/g,"%FD");
st=st.replace(/%u044E/g,"%FE");
st=st.replace(/%u044F/g,"%FF");
st=st.replace(/%u0410/g,"%C0");
st=st.replace(/%u0411/g,"%C1");
st=st.replace(/%u0412/g,"%C2");
st=st.replace(/%u0413/g,"%C3");
st=st.replace(/%u0414/g,"%C4");
st=st.replace(/%u0415/g,"%C5");
st=st.replace(/%u0416/g,"%C6");
st=st.replace(/%u0417/g,"%C7");
st=st.replace(/%u0418/g,"%C8");
st=st.replace(/%u0419/g,"%C9");
st=st.replace(/%u041A/g,"%CA");
st=st.replace(/%u041B/g,"%CB");
st=st.replace(/%u041C/g,"%CC");
st=st.replace(/%u041D/g,"%CD");
st=st.replace(/%u041E/g,"%CE");
st=st.replace(/%u041F/g,"%CF");
st=st.replace(/%u0420/g,"%D0");
st=st.replace(/%u0421/g,"%D1");
st=st.replace(/%u0422/g,"%D2");
st=st.replace(/%u0423/g,"%D3");
st=st.replace(/%u0424/g,"%D4");
st=st.replace(/%u0425/g,"%D5");
st=st.replace(/%u0426/g,"%D6");
st=st.replace(/%u0427/g,"%D7");
st=st.replace(/%u0428/g,"%D8");
st=st.replace(/%u0429/g,"%D9");
st=st.replace(/%u042A/g,"%DA");
st=st.replace(/%u042B/g,"%DB");
st=st.replace(/%u042C/g,"%DC");
st=st.replace(/%u042D/g,"%DD");
st=st.replace(/%u042E/g,"%DE");
st=st.replace(/%u042F/g,"%DF");
st=st.replace(/%u0401/g,"%A8");
st=st.replace(/%u0451/g,"%B8");
st=st.replace(/%u2116/g,"%B9");
st=st.replace(/%u201C/g,"\"");
st=st.replace(/%u201D/g,"\"");
st=st.replace(/%u2013/g,":");
st=st.replace(/%u2019/g,"'");
st=st.replace(/\+/g,"%2B");

return st;
}

function errMsg(num)
{
  switch(num)
  {
    case 1:
      addMes("<font color=red>Ошибка работы с сокетами</font><br>");
    break;
    case 2:
      addMes("<font color=red>Ошибка при отправке sms</font><br>");
    break;
    case 3:
      addMes("<font color=red>Неправильно задан логин или пароль</font><br>");
    break;
    case 4:
      addMes("<font color=red>Не удалось залогиниться</font><br>");
    break;
    case 5:
      addMes("<font color=red>Некорректный номер телефона или неправильная задержка</font><br>");
    break;
    case 6:
      addMes("<font color=red>Ошибка авторизации в агенте</font><br>");
    break;
    case 7:
      addMes("<font color=red>Неверно задан адрес прокси</font><br>");
    break;
    case 8:
      addMes("<font color=red>Неверно задан порт прокси</font><br>");
    break;
  }
}
</script>
</body></html>
HERE;
}
else
{
  header("Content-type: text/html; charset=windows-1251");

  $browser="Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14";

  $act=isset($_POST['act']) ? $_POST['act'] : 0;

  $pr=isset($_POST['pr']) ? $_POST['pr'] : '';
  $pp=isset($_POST['pp']) ? $_POST['pp'] : '';


  if($pr)
  {
    if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/",$pr))
    {
      $pr='';
      print("errMsg(7);");
    }

    if(!preg_match("/^(\d)+$/",$pp))
    {
      $pp='';
      print("errMsg(8);");
    }

    if(isset($_POST['shp']))
    {
      print "addMes('<font color=blue>Текущий прокси: $pr:$pp</font><br>');";
      ob_flush();
      flush();
    }
  }

  switch($act)
  {
    case '1':
      $mrnd=isset($_POST['rd']) ? $_POST['rd'] : 0;

      $msg=isset($_SESSION['msgx']) ? $_SESSION['msgx'] : '';

      $telnum=isset($_POST['telnum']) ? $_POST['telnum'] : 0;
      if(!preg_match("/^(\d){11}$/",$telnum))
        die("errMsg(5);nextMes();");

      $wt=isset($_POST['wt']) ? $_POST['wt'] : 0;
      if(!preg_match("/^(\d)+$/",$wt))
        die("errMsg(5);nextMes();");

      if($mrnd) $msg.="   ".mt_rand();

      $cookies=Array();
      $xtmp=isset($_POST['login']) ? $_POST['login'] : '';
      $xtmp=explode('@',$xtmp);
      $pass=isset($_POST['pass']) ? $_POST['pass'] : '';

      $login=$xtmp[0];
      $domain=$xtmp[1];

      if(strlen($login)<1 || strlen($pass)<1 || strlen($domain)<1)
        die("errMsg(3);nextMes();");

      $res=socket_do('win.mail.ru','/cgi-bin/loginagent','','GET','','',0,0,$pr,$pp);
      preg_match_all('/Set-Cookie: (.+);/iUs',$res,$cook);
      foreach($cook[1] as $ck)
      {
        $cookies[]=$ck;
      }



      $tmpcookie=implode('; ',array_unique($cookies));

      $res=socket_do('koi.mail.ru','/cgi-bin/auth',"page=http%3A%2F%2Fmrim8.mail.ru%2Fwin%2Fcontactlist.html&FailPage=http%3A%2F%2Fwin.mail.ru%2Fcgi-bin%2Floginagent&post=&login_from=&Login=$login&Domain=$domain&Password=$pass&level=1&x=11&y=12",'POST',$tmpcookie,'http://win.mail.ru/cgi-bin/loginagent',0,0,$pr,$pp);

      preg_match_all('/Set-Cookie: (.+);/iUs',$res,$cook);
      foreach($cook[1] as $ck)
      {
        $cookies[]=$ck;
      }

      $cookies=implode('; ',array_unique($cookies));



      preg_match("/Location: http:\/\/koi\.mail\.ru\/cgi\-bin\/checkcookie\?(.+)\r\n/iUs",$res,$m);

      if(!isset($m[1]))
        die("errMsg(4);nextMes();");


      $res=socket_do('koi.mail.ru','/cgi-bin/checkcookie?'.$m[1],'','GET',$cookies,'http://win.mail.ru/cgi-bin/loginagent',0,0,$pr,$pp);
      preg_match("/Location: (.+)\r\n/iUs",$res,$m);

      if(!isset($m[1]))
        die("errMsg(4);nextMes();");

      $tmp=explode('/',$m[1],4);

      $res=socket_do('mrim8.mail.ru','/'.$tmp[3],'','GET',$cookies,'http://win.mail.ru/cgi-bin/loginagent',0,0,$pr,$pp);

      $sock=@socket_create(AF_INET,SOCK_STREAM,SOL_TCP);

      if(!$sock)
        die("errMsg(1);nextMes();");



      if($pr)
      {
        @socket_connect($sock,$pr,$pp) or die("errMsg(1);nextMes();");
        $request = "POST http://mrim8.mail.ru/connect HTTP/1.0\r\n";
      }
      else
      {
        @socket_connect($sock,"194.67.57.121","80") or die("errMsg(1);nextMes();");
        $request = "POST /connect HTTP/1.0\r\n";
      }


      @socket_set_nonblock($sock) or die("errMsg(1);nextMes();");
      if(@socket_select($r = null, $w = array($sock), $f = null, 5)!=1)
        die("errMsg(1);nextMes();");



      $request.= "Host: mrim8.mail.ru\r\n";
      $request.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
      $request.= "Referer: {$m[1]}\r\n";
      $request.= "Content-Type: application/xml\r\n";
      $request.= "Content-Length: ".strlen('status=1')."\r\n";
      $request.= "Connection: keep-alive\r\n";
      $request.= "Keep-alive: 300\r\n";
      $request.= "Cookie: $cookies\r\n";
      $request.= "\r\n";

      @socket_write($sock,$request.'status=1') or die("errMsg(1);nextMes();");


      if(@socket_select($r = array($sock), $w = null, $f = null, 5)!=1)
        die("errMsg(1);nextMes();");


      $ret=@socket_read($sock,1000) or die("errMsg(1);nextMes();");

      if(strpos($ret,"MRIM_CS_LOGIN_REJ, {reason:\"Invalid session\"}")!==false)
      {
        @socket_close($sock);
        die("errMsg(6);nextMes();");
      }

      usleep($wt*1000);

      $res=socket_do('mrim8.mail.ru','/sms','seq=1&flags=0&phone=%2B'.$telnum.'&message='.urlencode($msg),'POST',$cookies,'http://mrim8.mail.ru/win/contactlist.html?post=&x=0&y=0&login_from=',0,1,$pr,$pp);


      if(strpos($res,"HTTP/1.0 200 OK")===0 || strpos($res,"HTTP/1.1 200 OK")===0)
      {
        //$ret=@socket_read($sock,1000) or die("errMsg(1);nextMes();");

        //if(strpos($ret,"MRIM_CS_SMS_ACK")===false)
        //  die("errMsg(2);nextMes();");

        @socket_close($sock);


        die("nextMes(1);");
      }
      else
      {
        @socket_close($sock);
        die("errMsg(2);nextMes();");
      }

    break;

    case '10':
      $msg=isset($_POST['msg']) ? trim($_POST['msg']) : '';

      $_SESSION['msgx']=$msg;

      die("mes_ok(".strlen($msg).");");
    break;



    default:
      die();
  }
}

function socket_do($page,$suri,$data,$method,$cook,$ref,$close=0,$sms=0,$pr='',$pp=0)
{
  if($pr)
  {
    $request="$method http://$page$suri HTTP/1.0\r\n";
    $fp=fsockopen("tcp://".$pr,$pp,$errno,$errstr,30);
  }
  else
  {
    $request = "$method $suri HTTP/1.0\r\n";
    $fp=fsockopen('tcp://'.$page,80,$errorNumber,$errorString,30);
  }


  if(!$fp) die("errMsg(1);nextMes();");

  @stream_set_timeout($fp,30);


  $request.= "Host: $page\r\n";
  $request.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
  if($ref) $request.= "Referer: $ref\r\n";

  if($method=='POST')
  {
    $request.= $sms ? "Content-Type: application/xml\r\n" : "Content-Type: application/x-www-form-urlencoded\r\n";
    $request.= "Content-Length: ".strlen($data)."\r\n";
  }

  $request.= "Connection: close\r\n";

  if($cook)
    $request.="Cookie: $cook\r\n";

  $request.="\r\n";

  $request.=$data;


  fputs($fp,$request);
	
  $res="";

  while(!feof($fp))
  {
    $res.=fgets($fp,128);
    if($close) break;
  }

  fclose($fp);

  return $res;
}

?>