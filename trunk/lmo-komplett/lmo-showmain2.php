<?
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
flush();
$addm=$_SERVER['PHP_SELF']."?file=".$file."&amp;action=";
if($file!=""){
  require_once(PATH_TO_LMO."/lmo-openfile.php");
  if(!isset($endtab)){
    $endtab=$anzst;
    $ste=$st;
    $tabdat="";
  }else{
    $tabdat=$endtab.". ".$text[2];
    $ste=$endtab;
  }
  if (!isset($_REQUEST['action']) || $_REQUEST['action']=="") {
    if(!isset($onrun) || $onrun==0 || $tabelle==0){
      $action="results";
    }elseif ($tabelle!=0){
      $action="table";
    }
  }
}

//Alle Teile f�r die Startansicht
$output_titel="";
$output_sprachauswahl="";
$output_kalender="";
$output_ergebnisse="";
$output_tabelle="";
$output_spielplan="";
$output_kreuztabelle="";
$output_fieberkurve="";
$output_ligastatistik="";
$output_spielerstatistik="";
$output_info="";
$output_hauptteil="";
$output_archiv="";
$output_ligenuebersicht="";
$output_savehtml="";
$output_letzteauswertung="";
$output_berechnungszeit="";
$output_stylesheet="";
$p1="";

if (!defined("LMO_TEMPLATE")) define("LMO_TEMPLATE","lmo-standard.tpl.php");

//Wenn ein Template der Form [liganame].tpl.php existiert, wird dieses benutzt. Das erm�glicht 
// die Nutzung verschiedener Templates f�r unterschiedliche Ligen 
if (file_exists(PATH_TO_TEMPLATEDIR.'/'.basename($file).".tpl.php")){  
  $template = new LBTemplate(basename($file).".tpl.php"); 
}else{
  $template = new LBTemplate(LMO_TEMPLATE); 
}

//if ($action!="tipp") {

  //Titel
  if ($file!="") {
    $output_titel.=$titel;
  } else {
    $output_titel.=$action=="tipp"?$text['tipp'][0]:$text[53];
  }
  
  
  //Stylesheet
  $output_stylesheet.="
  <link type='text/css' rel='stylesheet' href='".URL_TO_LMO."/lmo-style-nc.php'>
  <style type='text/css'>@import url('".URL_TO_LMO."/lmo-style.php');</style>";
  
  //Sprachauswahl
  
  if ($einsprachwahl==1 && $sprachauswahl==1){
    $handle=opendir (PATH_TO_LANGDIR);
    while (false!==($f=readdir($handle))) {
      if (preg_match("/^lang-?(.*)?\.txt$/",$f,$lang)>0) {
        if ($lang[1]=="") $lang[1]=$text[505];
        if ($lang[1]!=$lmouserlang) {
          $imgfile=URL_TO_IMGDIR.'/'.$lang[1].".gif";
          $output_sprachauswahl.="<a href='{$_SERVER['PHP_SELF']}?".htmlentities($_SERVER['QUERY_STRING'])."&amp;lmouserlang={$lang[1]}' title='{$lang[1]}'><img src='{$imgfile}' border='1' title='{$lang[1]}' alt='{$lang[1]}'></a> ";
        }
      } 
    }
    closedir($handle);
  }

  ob_start();
  if ($file!="") {

    //F�r normale Ligen
    if($lmtype==0){
  
      //Kalenderlink
      if($datc==1){
        $output_kalender.=$action!='cal'?         "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>":   $text[140];
        $output_kalender.='&nbsp;&nbsp;';
      }
      //Ergebnis/Tabelle
      if($tabonres==0){
        if($ergebnis==1){
          $output_ergebnisse.=$action!='results'? "<a href='{$addm}results&amp;st={$ste}' title='{$text[11]}'>{$text[10]}</a>": $text[10];
          $output_ergebnisse.="&nbsp;&nbsp;";
        }
        if($tabelle==1){
          $output_tabelle.=$action!='table'?      "<a href='{$addm}table' title='{$text[17]}'>{$text[16]}</a>":                 $text[16];
          $output_tabelle.="&nbsp;&nbsp;";
        }
      //Kombinierte Ansicht
      }else{
        if($ergebnis==1){
          $output_ergebnisse.=$action!='results' && $action!='table'? "<a href='{$addm}results' title='{$text[104]}'>{$text[10]}/{$text[16]}</a>":  $text[10].'/'.$text[16];
          $output_ergebnisse.="&nbsp;&nbsp;";
        }
      }
      
      //Kreuztabelle
      if($kreuz==1){
        $output_kreuztabelle.=$action!="cross"?   "<a href='{$addm}cross' title='{$text[15]}'>{$text[14]}</a>":                 $text[14];
        $output_kreuztabelle.="&nbsp;&nbsp;";
      }
      //Spielplan
      if($plan==1){
        $output_spielplan.=$action!="program"?    "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>":               $text[12];
        $output_spielplan.="&nbsp;&nbsp;";
      }
      //Fieberkurve
      if($kurve==1){
        $output_fieberkurve.=$action!="graph"?    "<a href='{$addm}graph&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[134]}'>{$text[133]}</a>": $text[133];
        $output_fieberkurve.="&nbsp;&nbsp;";
      }
      //Ligastatistiken
      if($ligastats==1){
        $output_ligastatistik.=$action!="stats"?  "<a href='{$addm}stats&amp;stat1={$stat1}&amp;stat2={$stat2}' title='{$text[19]}'>{$text[18]}</a>":   $text[18];
        $output_ligastatistik.="&nbsp;&nbsp;";
      }
    // Pokalligen
    }else{
      //Kalenderlink
      if($datc==1){
        $output_kalender.=$action!='cal'?         "<a href='{$addm}cal&amp;st={$st}' title='{$text[141]}'>{$text[140]}</a>":     $text[140];
        $output_kalender.='&nbsp;&nbsp;';
      }
      //Ergebnisse
      if($ergebnis==1){
        $output_ergebnisse.=$action!='results'?   "<a href='{$addm}results&amp;st={$ste}' title='{$text[11]}'>{$text[10]}</a>":  $text[10];
        $output_ergebnisse.="&nbsp;&nbsp;";
      }
      //Spielplan
      if($plan==1){
        $output_spielplan.=$action!="program"?    "<a href='{$addm}program' title='{$text[13]}'>{$text[12]}</a>":                $text[12];
        $output_spielplan.="&nbsp;&nbsp;";
      }
    }
    $output_info.=$action!="info"?              "<a href='{$addm}info' title='{$text[21]}'>{$text[20]}</a>":                   $text[20];
    
    $druck=0;

    if ($action!="tipp") {
      if($lmtype==0){
        //Normal
        switch($action) {
          case "cal":      if($datc==1)                     {require(PATH_TO_LMO."/lmo-cal.php");}break;
          case "results":  if ($ergebnis==1)                {$druck=1;require(PATH_TO_LMO."/lmo-showrestab.php");}break;
          case "table":    if ($tabelle==1)                 {$druck=1;require(PATH_TO_LMO."/lmo-showrestab.php");}break;
          case "cross":    if ($kreuz==1)                   {require(PATH_TO_LMO."/lmo-showcross.php");}break;
          case "program":  if ($plan==1)                    {require(PATH_TO_LMO."/lmo-showprogram.php");}break;
          case "graph":    if ($kurve==1)                   {require(PATH_TO_LMO."/lmo-showgraph.php");}break;
          case "stats":    if ($ligastats==1)               {require(PATH_TO_LMO."/lmo-showstats.php");}break;
          case "":         /*Auswahlseite*/break;
        }
      //Pokal
      }else{
        switch($action) {
          case "cal":      if ($datc==1)                    {require(PATH_TO_LMO."/lmo-kocal.php");}break;
          case "results":  if ($ergebnis==1)                {require(PATH_TO_LMO."/lmo-showkoresults.php");}break;
          case "program":  if ($plan==1)                    {require(PATH_TO_LMO."/lmo-showkoprogram.php");}break;
        }
    	}
      //Spieler-Addon
      if($action=="spieler"){if ($mittore==1)               {require(PATH_TO_ADDONDIR."/spieler/lmo-statshow.php");}}
      //Spieler-Addon
    }    
  	if($action=="info")                                     {require(PATH_TO_LMO."/lmo-showinfo.php");}
    $p0="p1";$$p0=c(1).$addm.c(0);
  }elseif ($backlink==1 && $action!="tipp")                 {require(PATH_TO_LMO."/lmo-showdir.php");}

  if($action=="tipp" && $eintippspiel==1) {require(PATH_TO_ADDONDIR."/tipp/lmo-tippstart.php");}
  $output_hauptteil.=ob_get_contents();ob_end_clean();

  if ($file!="") { 
    //Letzte Auswertung
    $output_letzteauswertung.=$text[406].':&nbsp;'.$stand;
 
    //SaveHTML
    if ($einsavehtml==1) {
      ob_start();?>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr><? 
      /*if($lmtype==0 || $druck==1){include(PATH_TO_LMO."/lmo-savehtml.php");}*/?> 
           <td align="center"><? 
      if($lmtype==0 && $druck==1){echo "<a href='".URL_TO_LMO.'/'.$diroutput.basename($file)."-st.html' target='_blank' title='{$text[477]}'>{$text[478]}</a>&nbsp;";}?>
            </td>  
            <td align="center"><? 
      if($lmtype==0 && $druck==1){echo "<a href='".URL_TO_LMO.'/'.$diroutput.basename($file)."-sp.html' target='_blank' title='{$text[479]}'>{$text[480]}</a>&nbsp;";}?>
            </td>
          </tr>
        </table><? 
      $output_savehtml.=ob_get_contents();ob_end_clean();
    }
  } else {
    if($archivlink==1){
      if (isset($archiv) && $archiv!=""){
        $output_archiv.="<a href=\"".$_SERVER["PHP_SELF"]."\">{$text[391]}</a><br>";
      }
      if (!isset($archiv) || $archiv!="dir"){
        $output_archiv.="<a href=\"".$_SERVER["PHP_SELF"]."?archiv=dir\">{$text[508]}</a><br>";
      }
      
    }
  }
  
  //Ligen�bersicht
  if($backlink==1 && ($file!="" || $action=="tipp")){
    $output_ligenuebersicht.="<a href='{$_SERVER['PHP_SELF']}' title='{$text[392]}'>{$text[391]}</a>&nbsp;&nbsp;&nbsp;";
  }
  
  //Berechnungszeit
  if($calctime==1){
     $output_berechnungszeit.=$text[471].": ".number_format((getmicrotime()-$startzeit),4,".",",")." sek.<br>";
  }


  //Spieler-Addon
   if ($file!="" && $einspieler==1 && $mittore==1) {
    include(PATH_TO_ADDONDIR."/spieler/lmo-statloadconfig.php");
   $output_spielerstatistik.=$action!="spieler"?"<a href='{$addm}spieler' title='{$text['spieler'][12]}'>{$spieler_ligalink}</a>":           $spieler_ligalink;
    $output_spielerstatistik.="&nbsp;&nbsp;";
  }
  //Spieler-Addon
  
  //Ticker-Addon
  $output_newsticker="";
  if($file!="" && $nticker==1){ 
    ob_start();
    $tickerligen=basename($file);
    include(PATH_TO_ADDONDIR."/ticker/ticker.php");    
    $output_newsticker.=ob_get_contents();ob_end_clean();
  }
  //Ticker-Addon
  //Tippspiel-Addon
  $output_tippspiel="";
  if ($eintippspiel==1) {
    if(($tipp_immeralle==1 || strpos($tipp_ligenzutippen, substr($file,strrpos($file,"//")+1,-4))>-1)){
      $output_tippspiel.=$action!="tipp"?       "<a href='{$addm}tipp' title='{$text['tipp'][0]}'>{$text['tipp'][0]}</a>&nbsp;&nbsp;":$text['tipp'][0]."&nbsp;&nbsp;";
    }
  }
  d($template->toString());
  //Tippspiel-Addon
  
  //Template ausgeben
  $template->replace("Ligenuebersicht", $output_ligenuebersicht);  
  $template->replace("Berechnungszeit", $output_berechnungszeit);  
  $template->replace("LetzteAuswertung", $output_letzteauswertung);  
  $template->replace("Archiv", $output_archiv);  
  $template->replace("Savehtml", $output_savehtml); 
  $template->replace("Hauptteil", $output_hauptteil);  
  $template->replace("Tabelle", $output_tabelle); 
  $template->replace("Kreuztabelle", $output_kreuztabelle); 
  $template->replace("Fieberkurve", $output_fieberkurve); 
  $template->replace("Spielerstatistik", $output_spielerstatistik); 
  $template->replace("Ligastatistik", $output_ligastatistik); 
  $template->replace("Kalender", $output_kalender); 
  $template->replace("Ergebnisse", $output_ergebnisse); 
  $template->replace("Spielplan", $output_spielplan); 
  $template->replace("Info", $output_info); 
  $template->replace("Infolink", $p1); 
  $template->replace("Sprachauswahl", $output_sprachauswahl); 
  $template->replace("Titel", $output_titel); 
  $template->replace("Stylesheet", $output_stylesheet); 
  //Ticker-Addon
  $template->replace("Newsticker", $output_newsticker);  
  //Ticker-Addon
  //Tippspiel-Addon
  $template->replace("Tippspiel", $output_tippspiel);  
  //Tippspiel-Addon
  $template->show();

    
  //}else {require(PATH_TO_ADDONDIR."/tipp/lmo-tippstart.php");d($template->toString());}
?>