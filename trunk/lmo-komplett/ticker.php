<?PHP 
/**
 * LMO-Ticker V1.03 f�r den LMO 3.02b
 * Stand: 13.06.2003
 * Copyright (C) 2003 by Bernd Hoyer, basierend auf dem LMO3.02b von Frank Hollwitz
 * info@salzland.info.de / http://www.salzland-info.de
 * Verbesserungen, Bugs etc. bitte nur in das Forum unter www.hollwitz.net
 * Es gelten die gleichen Softwarenutzungsrechte wie beim LMO (Free Software entsprechend General Public License [GNU])
 */

// Start Einstellbereich
// ini_set("error_reporting",E_ALL);
$titelticker="Alle Ergebnisse des letzten Spieltages Liga 1, Liga 2"; //Titel des Tickers festlegen
$spieltag=" .Spieltag: "; // Wort vor der Ergebnisausgabe
$file_array=array("ligen/liga1.l98","ligen/liga2.l98", "ligen/liga3.l98"); // Auswahl der anzuzeigenden Ligen
$tickerart=1; // Tickerart: 1=Ergebnisticker, 2=Tickertext vom LMO, 3=Ergebnisse nur Favoritenteams
$tickertitel=1; // Tickertitel einblenden: 1=ja, 2=nein
$notzizanzeigen=1; // Notiz zum Spiel mit anzeigen: 1=ja, 2=nein
$text_sportgericht="-Entscheid durch Sportgericht"; // Text f�r Sportgerichtsentscheidung
$text_sportgericht2="Das Ergebnis z�hlt f�r beide Mannschaften gleicherma�en aus Sicht der Heimmannschaft."; // Text beidseitiges Ergebnis
// Ende Einstellbereich


require("lmo-langload.php");
$versionticker="LMO-Ticker 1.03 ";
$array = array("");  
$msieg=0;
$mnote="";
$dummy1="";
$dummy2="";
$dummy3="";
$dummy4="";
$link="<a href=\"http://www.salzland-info.de/\" target=\"_blank\">www.salzland.info.de </a>";
?>

<?PHP if ($tickerart==1) { ?>
<SCRIPT Language="JavaScript">
<!--
 NS4 = (document.layers);
 if (NS4) { document.write('<link rel="stylesheet" href="nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">
</noscript>

<table cellspacing="0" cellpadding="0" border="0" align="center">
<?PHP if ($tickertitel==1) { ?>
<tr>
<td class="lmomain1" align="center"><nobr><?PHP echo $titelticker ?> </nobr></td>
</tr>
<?PHP }?>
<script language="JavaScript">
<!--
var msg1="   +++";
<?PHP
if(!isset($file)){$file="";}
$file2=$file;

foreach ($file_array as $file){
require("lmo-openfile.php");
$hilf="";
$hilf1="";
if($lmtype==0){
for($i=0;$i<$anzsp;$i++){
if(($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0) ){
if($mspez[$stx-1][$i]=="&nbsp;"){
$mspezhilf="";}
else {
$mspezhilf=" ".$mspez[$stx-1][$i];}
if($msieg[$stx-1][$i]==1){$dummy1=$text_sportgericht.":".addslashes($teams[$teama[$stx-1][$i]]." ".$text[211]);}
else {$dummy1="";}
if($msieg[$stx-1][$i]==2){$dummy2=$text_sportgericht.":".addslashes($teams[$teamb[$stx-1][$i]]." ".$text[211]);}
else {$dumm2y="";}
if($msieg[$stx-1][$i]==3){$dummy3=$text_sportgericht.":".addslashes($text_sportgericht2);}
else {$dummy3="";}
if($mnote[$stx-1][$i]!="" && $notzizanzeigen==1){$dummy4=" Notiz".": ".$mnote[$stx-1][$i];}
else {$dummy4="";}
$hilf=$hilf.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i].":".$goalb[$stx-1][$i].$mspezhilf.$dummy1.$dummy2.$dummy3.$dummy4." +++ ";
}
}
}
if($lmtype!=0){
for($i=0;$i<$anzsp;$i++){
for($n=0;$n<$modus[$stx-1];$n++){
if(($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0) ){
if($mspez[$stx-1][$i][$n]=="&nbsp;"){
$mspezhilf="";}
else {
$mspezhilf=" ".$mspez[$stx-1][$i][$n];}
if($mnote[$stx-1][$i][$n]!="" && $notzizanzeigen==1){$dummy4=" Notiz".": ".$mnote[$stx-1][$i][$n];}
else {$dummy4="";}
$hilf1=$hilf1.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i][$n].":".$goalb[$stx-1][$i][$n].$mspezhilf.$dummy4." +++ ";
}
}
}
}
?>
msg1=msg1+"<?PHP echo $stx; ?>"+"<?PHP echo $spieltag; ?>"+"<?PHP echo $hilf; ?>"+"<?PHP echo $hilf1; ?>";
<?PHP
}
$file=$file2;

?>
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(60/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/10);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  document.write("<tr><td class=\"lmomain1\" colspan=\"3\" align=\"center\"><nobr><FORM NAME=\"marqueeform\"><INPUT class=\"lmotickerein\" TYPE=\"TEXT\" NAME=\"marquee\" SIZE=\"60\" readonly></FORM></nobr></td></tr>");
  document.close();
  marquee();
-->
</script>
<tr>
<td class="lmomain2" align="center"><nobr><?PHP require("lmo-openfile.php"); echo $versionticker."&copy 2003 by ".$link ?></nobr></td>
</tr>
</table>
<?PHP }?>

<?PHP if ($tickerart==2) {?>
<SCRIPT Language="JavaScript">
<!--
 NS4 = (document.layers);
 if (NS4) { document.write('<link rel="stylesheet" href="nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">
</noscript>

<table cellspacing="0" cellpadding="0" border="0" align="center">
<?PHP if ($tickertitel==1) { ?>
<tr>
<td class="lmomain1" align="center"><nobr><?PHP echo $titelticker ?> </nobr></td>
</tr>
<?PHP }?>

<script language="JavaScript">
<!--
var msg1="   +++";
<?PHP
if(!isset($file)){$file="";}
$file2=$file;

foreach ($file_array as $file){
require("lmo-openfile.php");
$hilf="";
$trenner=" +++ ";

  for($i=0;$i<count($nlines);$i++){
  $hilf=$hilf.$nlines[$i].$trenner;
  
  }	?>
  msg1=msg1+"<?PHP echo $hilf; ?>";

<?PHP
}
$file=$file2;

?>
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(60/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/10);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  document.write("<tr><td class=\"lmomain1\" colspan=\"3\" align=\"center\"><nobr><FORM NAME=\"marqueeform\"><INPUT class=\"lmotickerein\" TYPE=\"TEXT\" NAME=\"marquee\" SIZE=\"60\" readonly></FORM></nobr></td></tr>");
  document.close();
  marquee();
-->
</script>


<tr>
<td class="lmomain2" align="center"><nobr><?PHP echo $versionticker."&copy 2003 by ".$link ?> </nobr></td></tr>
</table>
<?PHP } ?>

<?PHP if ($tickerart==3) { ?>
<SCRIPT Language="JavaScript">
<!--
 NS4 = (document.layers);
 if (NS4) { document.write('<link rel="stylesheet" href="nc.css" type="text/css">'); }
  else { document.write('<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">'); }
//-->
</script>
<noscript>
<link rel="stylesheet" href="lmo-tickerstyle.css" type="text/css">
</noscript>

<table cellspacing="0" cellpadding="0" border="0" align="center">
<?PHP if ($tickertitel==1) { ?>
<tr>
<td class="lmomain1" align="center"><nobr><?PHP echo $titelticker ?> </nobr></td>
</tr>
<?PHP }?>
<script language="JavaScript">
<!--
var msg1="   +++";
<?PHP
if(!isset($file)){$file="";}
$file2=$file;

foreach ($file_array as $file){
require("lmo-openfile.php");
$hilf="";
$hilf1="";

if($lmtype==0){
for($i=0;$i<$anzsp;$i++){
if(($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0)){
if($mspez[$stx-1][$i]=="&nbsp;"){
$mspezhilf="";}
else {
$mspezhilf=" ".$mspez[$stx-1][$i];}
if (($favteam==$teama[$stx-1][$i]) or ($favteam==$teamb[$stx-1][$i])) {
if($msieg[$stx-1][$i]==1){$dummy1=$text_sportgericht.":".addslashes($teams[$teama[$stx-1][$i]]." ".$text[211]);}
else {$dummy1="";}
if($msieg[$stx-1][$i]==2){$dummy2=$text_sportgericht.":".addslashes($teams[$teamb[$stx-1][$i]]." ".$text[211]);}
else {$dumm2y="";}
if($msieg[$stx-1][$i]==3){$dummy3=$text_sportgericht.":".addslashes($text_sportgericht2);}
else {$dummy3="";}
if($mnote[$stx-1][$i]!="" && $notzizanzeigen==1){$dummy4=" Notiz".": ".$mnote[$stx-1][$i];}
else {$dummy4="";}
$hilf=$hilf.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i].":".$goalb[$stx-1][$i].$mspezhilf.$dummy1.$dummy2.$dummy3.$dummy4." +++ ";
}
}
}
}
if($lmtype!=0){
for($i=0;$i<$anzsp;$i++){
for($n=0;$n<$modus[$stx-1];$n++){
if(($teama[$stx-1][$i]>0) && ($teamb[$stx-1][$i]>0) ){
if($mspez[$stx-1][$i][$n]=="&nbsp;"){
$mspezhilf="";}
else {
$mspezhilf=" ".$mspez[$stx-1][$i][$n];}
if (($favteam==$teama[$stx-1][$i]) or ($favteam==$teamb[$stx-1][$i])) {
if($mnote[$stx-1][$i][$n]!="" && $notzizanzeigen==1){$dummy4=" Notiz".": ".$mnote[$stx-1][$i][$n];}
else {$dummy4="";}
$hilf1=$hilf1.$teams[$teama[$stx-1][$i]]."-".$teams[$teamb[$stx-1][$i]]." ".$goala[$stx-1][$i][$n].":".$goalb[$stx-1][$i][$n].$mspezhilf.$dummy4." +++ ";
}
}
}
}
}
?>
msg1=msg1+"<?PHP echo $stx; ?>"+"<?PHP echo $spieltag; ?>"+"<?PHP echo $hilf; ?>"+"<?PHP echo $hilf1; ?>";
<?PHP
}
$file=$file2;

?>
  var laenge=msg1.length;
  var timerID = null;
  var timerRunning = false;
  var id,pause=0,position=0;
  function marquee(){
    var i,k,msg=msg1;
    k=(60/msg.length)+1;
    for(i=0;i<=k;i++) msg+=""+msg;
    document.marqueeform.marquee.value=msg.substring(position,position+120);
    if(position++==laenge) position=0;
    id=setTimeout("marquee()",1000/10);
    }
  function action(){
    if(!pause) {
      clearTimeout(id);
      pause=1;
      }
    else{
      marquee();
      pause=0;
    }
  }
  document.write("<tr><td class=\"lmomain1\" colspan=\"3\" align=\"center\"><nobr><FORM NAME=\"marqueeform\"><INPUT class=\"lmotickerein\" TYPE=\"TEXT\" NAME=\"marquee\" SIZE=\"60\" readonly></FORM></nobr></td></tr>");
  document.close();
  marquee();
-->
</script>
<tr>
<td class="lmomain2" align="center"><nobr><?PHP require("lmo-openfile.php"); echo $versionticker."&copy 2003 by ".$link ?></nobr></td>
</tr>
</table>
<?PHP }?>