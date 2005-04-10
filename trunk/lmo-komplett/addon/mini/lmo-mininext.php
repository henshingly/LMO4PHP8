<?php
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
  *
  * lmo-nextgame Block for LigaManager Online
  *  Copyright (C) 2005 by Tim Schumacher/LMO-Group
  * timme@webobjekts.de / admin@liga-manager-online.de
  * 
  *  Version 1.1
  *  systemvoraussetzung: classlib ab 2.6 sp1
  *
  * History:
  * 1.0: initial Release
  * 1.1: Multilanguagef�hig, ins mini*-Addon eingef�gt, Bugfixes, Template entr�mpelt 
  *
  * Dieses Script zeigt die kommende Partie einer Mannschaft in einem kleinen 
  * Block an, der relativ einfach in jede bestehende Seite eingebunden werden 
  * kann. Als Vorlage diente die L�sung auf www.hsg-nordhorn.de (Oben rechts 
  * auf der Startseite).
  * Neben der Anzeige der kommenden Partie, wird im anzugebenen Archivordner 
  * nach bereits vorhandenen Begegnungen der Mannschaften gesucht und absteigend 
  * sortiert nach Datum angezeigt.
  * 
  * URL-Parameter:
  * 
  *   file: Dateiname der Liga
  * 
  *   folder: Archivordner, der durchsucht werden soll. Es ist sinvoll, die 
  *           alten Ligadateien nicht direkt in den Archivordner abzulegen, 
  *           sondern jeweils f�r jede Liga einen eigenen unterordner im 
  *           Archivverzeichnis anzulegen.
  *   a:      Nummer der Mannschaft A, f�r die der Block erstellt werden 
  *           soll. Dieser Parameter ist nur dann erforderlich, wenn im 
  *           LigaFile keine Lieblingsmannschaft angegeben wurde.
  *   b:      Nummer des Gegners von a: bzw der Lieblingsmannschaft. Dieser 
  *           Parameter ist f�r die Anzeige der n�chsten Partie nicht erforderlich, 
  *           da die n�chste Partie automatisch ermittelt wird. Wer aber eine 
  *           spezielle Paarung angezeigt haben m�chte kann hier b angeben.
  * 
  * 
  * Beispiel: 1.Bundesliga Fussball 2004 / 2005
  *   file = 1bundesliga2004.l98
  *      die alten Ligafiles der 1. Bundesliga befinden sich im ordner 
  *      <lmo_root>/ligen/archiv/dbl also 
  *   folder=archiv/dbl
  * 
  *   Einbindung �ber IFrame:
  *     <iframe src="<url_to_lmo>/addon/mini/lmo-mininext.php?file=1bundesliga2004.l98&folder=archiv/dbl"><url_to_lmo>/lmo-nextgame_block.php?file=1bundesliga2004.l98&folder=archiv/dbl</iframe>
  *     (die Parameter a und b bei Bedarf mit &amp;a=<integer>&amp;b=<integer> anh�ngen
  * 
  *   Einbindung �ber include:
  *     $file = "1bundesliga2004.l98";
  *     $folder = "archiv/dbl";
  *     (auch hier bei Bedarf a und/oder b angeben: $a = <integer>;$b = <integer>; )
  *     include ("<pfad_zum_lmo>/addon/mini/lmo-mininext.php");
  * 
  * Installation:
  * lmo-mininext.php ins Verzeichnis <lmo_root>/addon/mini/ kopieren.
  * mininext.tpl.php ins Verzeichnis <lmo_root>/template/mini/ kopieren
  * *lang.txt-dateien ins Verzeichnis <lmo_root>/lang/mini/ kopieren
  * 
  * 
  * Hinweis:
  * Es ist nicht gestattet den Hinweis auf den Autor zu entfernen!
  * Eigene Templates m�ssen den Hinweis auf Autor des Scripts enthalten.
  *
  * bekannte Probleme:
  * Sind die Spielzeiten der Partien nicht angegeben, erfolgt die Ausgabe der 
  * Archivpartien unsortiert.
  */

require(dirname(__FILE__).'/init.php');
require_once(PATH_TO_ADDONDIR."/classlib/ini.php");

$file = isset($_GET['file'])?$_GET['file']:isset($file)?$file:NULL;
$archivFolder = isset($_GET['folder'])?$_GET['folder']:isset($folder)?$folder:basename($ArchivDir);// Default

if (substr($archivFolder,-1) != '/') {
  $archivFolder .= '/';
}

if (strpos($archivFolder,'../')!==false) {
  exit();
}

$a = isset($_GET['a'])?$_GET['a']:null; // nr vom team a (wenn nicht angegeben wird favTeam verwendet)
$b = isset($_GET['b'])?$_GET['b']:null; // nr vom team b (wenn nicht angegeben wird n�chster Gegner von a verw.)
$unGreedy = TRUE; //inv. Gierigkeit: findet z.B. auch THW KIEL 6 wenn team_b = THW KIEL 3 ist. false/true
$barWidth = 120; // Breite des farbigen Balken

$template_folder = PATH_TO_TEMPLATEDIR;		// Templatepath
$template_file = '/mini/mininext.tpl.php';		// Templatefile

//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>lmo-nextgame</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<style type="text/css">
  html,body {margin:0;padding:0;background:#FFFFFF;}
</style>
</head>
<body><?
}

$template = new HTML_Template_IT($template_folder); // verzeichnis
$template->loadTemplatefile($template_file);
$team_a = NULL;
$team_b = NULL;
$partie = NULL;
$lastPartie = NULL;
$liga = new liga();
if ($file and $liga->loadFile(PATH_TO_LMO.'/'.$dirliga.$file) == TRUE) {
	 if (!is_null($a)) {
	   $team_a = $liga->teamForNumber($a);
	 } else {
	   $team_a = $liga->teamForNumber($liga->options->keyValues['favTeam']);
	 }
	 if (is_null($a)) {
	   echo getMessage("No teams selected",TRUE);
	   exit();
	 }
	   

   if (is_null( $team_b = $liga->teamForNumber($b)) ) {
	   // Wir ermitteln den n�chsten gegner von a wenn b nicht angegeben ist
     $sortedGames = gamesSortedForTeam ($liga,$team_a,false); // Nur nach der Zeit sortieren unabh. vom spieltag
     $now = time();
     $showLastGame = true;
     foreach ($sortedGames as $game) {
       if ( $now < $game['partie']->zeit ) { // letztes Spiel finden
         $partie = $game['partie'];
         $template->setVariable("gameTxt","N�chstes Spiel"); // Es gibt ein zuk�nftiges Spiel
     		 $template->setVariable("gameNote",$partie->notiz);
         break; // gegner gefunden
       }
       $lastPartie = $game['partie'];
     }
		 if (!isset($partie) ) { // Keine weitere Partie gefunden, daher letzte Partie anzeigen (Saison beendet)
      $partie = $lastPartie;
      unset($lastPartie);
      $showLastGame = FALSE;
      $template->setVariable("gameTxt","Letztes Saisonspiel");
		 }
		 else
      $showLastGame = TRUE;

     if($partie->heim == $team_a) {
       $team_b = $partie->gast;
     }
     else {
       $team_b = $partie->heim;
     }

   }
   else { // a und b wurden angegeben also ergebnis dieser Partie anzeigen
     $partie = $liga->partieForTeams($team_a,$team_b);
     $template->setVariable("gameTxt","Spielpaarung");
   }

	 if (isset($partie) ) {

     $template->setVariable("gameDate",$partie->datumString());
     $template->setVariable("gameTime",$partie->zeitString());
     $template->setVariable("ligaDatum","Stand: ".$liga->ligaDatumAsString("%d.%m.%Y"));
     //
     $template->setVariable("copy","[<acronym title='lmo-mininext for LMO &copy; Tim Schumacher/LMO-Group ".CLASSLIB_VERSION."'>&copy;</a>]");
     $template->setVariable("imgHomeSmall",HTML_smallTeamIcon($file,$team_a,"alt=\"\""));
     $template->setVariable("imgHomeBig",HTML_bigTeamIcon($file,$team_a,"alt=\"\""));
     $template->setVariable("imgGuestSmall",HTML_smallTeamIcon($file,$team_b,"alt=\"\""));
     $template->setVariable("imgGuestBig",HTML_bigTeamIcon($file,$team_b,"alt=\"\""));

     $template->setVariable("homeName",$team_a->name);
     $template->setVariable("guestName",$team_b->name);

     $dataArray = array();
     $archivPaarungen = array();
     $archivSortDummy = array();
     // Partien der aktuellen Liga ermitteln

      if(!is_null($spiel = $liga->partieForTeams($team_a,$team_b)) and
        ($spiel->hTore != -1 and $spiel->gTore != -1)  ) {
        $archivSortDummy[] = $spiel->zeit;
        $archivPaarungen[] = array('time'=>$spiel->zeit,
                              'where'=>'h', // homegame Flag
                              'partie'=>$spiel,
                              'match'=>NULL,
                              );
      }
      if(!is_null($spiel = $liga->partieForTeams($team_b,$team_a)) and
        ($spiel->hTore != -1 and $spiel->gTore != -1) ) {
        $archivSortDummy[] = $spiel->zeit;
        $archivPaarungen[] = array('time'=>$spiel->zeit,
                             'where'=>'a', // away Flag
                             'partie'=>$spiel,
                             'match'=>NULL,
                             );
      }

     // Archivfolder lesen

     if (readLigaDir(PATH_TO_LMO.'/'.$dirliga.$archivFolder,&$dataArray) == FALSE )
     	echo "Warning: Archivfolder not found ".PATH_TO_LMO.'/'.$dirliga.$archivFolder;

     foreach ($dataArray as $ligaFile) {
        $newLiga = new liga();
        if($newLiga->loadFile($ligaFile['path'].$ligaFile['src'] ) == TRUE) {

          $teamNames = $newLiga->teamNames();
          $newTeam_a = $newLiga->teamForName($team_a->name);
          $seachNames = $unGreedy == TRUE ? findTeamName($teamNames,$team_b->name):NULL; // ungreedy Searching
          if (isset($seachNames) and count($seachNames) == 1 ) {
            $newTeam_b = $newLiga->teamForName($seachNames[0]);// ungreedy Searching war erfolgreich
            $match = $seachNames[0];
          }
          else {
            $newTeam_b = $newLiga->teamForName($team_b->name);// Searching war zu ungenau (mehr als ein result)
            $match = NULL;
          }
          if (!is_null($newTeam_a) and !is_null($newTeam_b) ){
            $spiel = $newLiga->partieForTeams($newTeam_a,$newTeam_b);
            if ($spiel->hTore != -1 and $spiel->gTore != -1) {
              $archivSortDummy[] = $spiel->zeit;
              $archivPaarungen[] = array('time'=>$spiel->zeit,
                                    'where'=>'h',
                                    'partie'=>$spiel,
                                    'match'=>$match,
                                    ); // Heimspiel Flag
            }
            $spiel = $newLiga->partieForTeams($newTeam_b,$newTeam_a);
            if ($spiel->hTore != -1 and $spiel->gTore != -1) {
              $archivSortDummy[] = $spiel->zeit;
              $archivPaarungen[] = array('time'=>$spiel->zeit,
                                    'where'=>'a',
                                    'partie'=>$spiel,
                                    'match'=>$match,
                                    ); // Ausw�rts Flag
            }
          }
        }
        unset($newLiga);
//        if (count($archivPaarungen) > 10) break; // max Anzahl von Archivbegegnungen
     }
     array_multisort($archivSortDummy,SORT_DESC,$archivPaarungen);

     $spAnzahl = count($archivPaarungen);

     $template->setCurrentBlock("matches"); // innerer Block mit den Partien

     $lostCount = $drawCount = $winCount = 0;

     foreach ($archivPaarungen as $paarung) {
       $template->setVariable("date",$paarung['partie']->datumString());
       $template->setVariable("hTore",$paarung['partie']->hToreString());
       $template->setVariable("gTore",$paarung['partie']->gToreString());
       $template->setVariable("where",$paarung['where']);
       if (isset($paarung['match']) and strtolower($paarung['match']) != strtolower($team_b->name) ) {
       echo "<br>Vergleich: ".strtolower($paarung['match'])." = ".strtolower($team_b->name);
        $template->setVariable("matchingName","<br>(".$paarung['match'].")");
			 }
			 $valuate = $paarung['partie']->valuateGame();
			 if ( ($paarung['where']=='h' and $valuate == 1)
			 			or ($paarung['where']=='a' and $valuate == 2) ) {
         $template->setVariable("class","win");
         $winCount++;
			 }
			 elseif ( ($paarung['where']=='h' and $valuate == 2)
			 			or ($paarung['where']=='a' and $valuate == 1) ) {
         $template->setVariable("class","lost");
         $lostCount++;
			 }
       elseif ($valuate == 0) {
         $template->setVariable("class","draw");
         $drawCount++;
       }
       else {
         $template->setVariable("class","noResult");
       }
       $template->parseCurrentBlock();
     }

     $w = intval( $barWidth * $winCount / ($spAnzahl+.1) );
     $d = intval( $barWidth * $drawCount / ($spAnzahl+.1) );
     $l = intval( $barWidth * $lostCount / ($spAnzahl+.1) );

     $template->setCurrentBlock("main");
      $template->setVariable("matchesTxt","Spiele gegeneinander:");
      $template->setVariable("winCount",$winCount);
      $template->setVariable("drawCount",$drawCount);
      $template->setVariable("lostCount",$lostCount);
      $template->setVariable("matchCount",count($archivPaarungen));
      $template->setVariable("winWidth", $w );
      $template->setVariable("drawWidth", $d );
      $template->setVariable("lostWidth",$l );
      $template->setVariable("winTxt","S");
      $template->setVariable("drawTxt","U");
      $template->setVariable("lostTxt","N");
  }
	$template->show(); // koennte man doch auch zum caching speichern ? �ber ->get() o.�.

} // if file
  else echo "liga not found!";
//Falls IFRAME - komplettes HTML-Dokument
if (basename($_SERVER['PHP_SELF'])=="lmo-mininext.php") {?>
</body>
</html><?
}?>