<?php
function buildFieldArrayDFB($url,$detailsRowCheck = 0) {
 
  function skipRow($rowContent) {
    $result = TRUE;
    if($rowContent=="") $result = TRUE;
    elseif(preg_match("/^\d\d\d/",$rowContent)) $result = FALSE; // reihe enth�lt spielpaarung
    return $result;
  }
   
  function buildFieldArrayRekursion($url, $rowCount, $newRowCheck, $rows, &$mannschaften) {

    $urlContent = getFileContent($url);
   
    //Spieltags-Nr. suchen, bei Spieltagen mit nur verlegten Spielen gibt es keine
    if (preg_match("/<OPTION SELECTED VALUE.{40,65}\d+\. Spieltag/",$urlContent,$ergebnis)) {
       preg_match("/\d{1,3}\. Spieltag/", $ergebnis[0], $ergebnis);
       preg_match("/\d{1,3}/", $ergebnis[0], $ergebnis);
       $spieltagsnr = $ergebnis[0];
    } else $spieltagsnr = "?&?!";   
   
    //Link auf den n�chsten Spieltag suchen
    if (preg_match("/dbc.{60,100}n.chster/", $urlContent, $ergebnis)) {
      preg_match("/dbc.+,1/", $ergebnis[0], $neue_url_temp);
      $temp = explode('/', $neue_url_temp[0]);
      $temp2 = explode(',', $temp[10]);
      if ($temp2[0] == $temp2[1]) $neue_url=''; //letzter Spieltag erreicht
      else $neue_url="http://fussball.sport1.de/".$neue_url_temp[0];
    } else {
       echo "<font color=\"red\"><b>Fehler</b>: Konnte Link zum n�chsten Spieltag nicht finden. Korrekte URL angegeben?</font>";
       exit;
    }
     
    $arr = preg_split("/<\/t[d|h]/si",$urlContent);
 
    for ($i=0; $i<count($arr); $i++){
      $content = stristr($arr[$i],"<td");
      $trEnd = stristr($arr[$i],"<tr");
 
      if ($content==FALSE) {
        $content = stristr($arr[$i],"<th");
      }
      // colspan finden
      preg_match("/.*<t[d|h].*colspan=.?(\d+).*>/i",$content,$colspan);
      if (isset($colspan[1])) {
        $colspanCount = $colspan[1];
      }
      else {
        $colspanCount = 0;
      }
 
      if ($content!="") {
         $pos=0;
         for ($x=0;$x<strlen($content);$x++)
              if ((!$pos)&&(substr($content,$x,1)==">")) $pos=$x;
         if ($pos) $content=substr($content,$pos+1);
         $content = trim(extractText($content));
 
        if (preg_match("/\d\d\.\d\d\.\d\d\d\d/",$content,$ergebnis)) $spieldatum  = $ergebnis[0]; //sucht das spieldatum
       
        if (preg_match("/\d+:\d+/",$content,$ergebnis)) $content  = $ergebnis[0]; //l�scht das * hinter dem ergebnis
       
             
        // Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
        // oder eine neue Partie ist
 
         if ($trEnd!=FALSE and ($detailsRowCheck == 0 or isDetailsRow($content,$newRowCheck)==FALSE or $rowCount < 1)) {
             // Wenn die aktuelle Zeile komplett leer ist,dh nur # enth�lt,
             // dann wird sie mit neuen Daten �berschrieben
             if ($rowCount < 0 or skipRow($rows[$rowCount])==FALSE) {
             //Mannschaften z�hlen
             $zeile = split('#', $rows[$rowCount]);
             if (!in_array($zeile[3], $mannschaften)) //wenn mannschaftsname noch nicht vorgekommen ist
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[3];
               else array_push($mannschaften, $zeile[3]);
             if (!in_array($zeile[4], $mannschaften)) //Ausw�rts muss auch �berpr�ft werden. "Spielfrei" ist z.B. eine reine Ausw�rtsmannschaft
               if ($mannschaften[0]=='') $mannschaften[0]=$zeile[4];
               else array_push($mannschaften, $zeile[4]);
             $rowCount++;
            }
            $rows[$rowCount]=$content."#$spieldatum#$spieltagsnr";
            if ($content != "")
              $newRowCheck = $content;

         }
         else {
              $rows[$rowCount].="#".$content;
         }
         
         
         
        //entsprechend des gefundenen colspan zus�tzliche zellen einf�gen
          for ($z=1;$z<$colspanCount;$z++) {
            if ($content!="" and $rowCount == 0 ) $rows[$rowCount].="#".$content.$z; // Nur in der erste Zeile
            else $rows[$rowCount].="#";
          }
      }
    }
   
    if ($neue_url != "") { //solange letzter Spieltag noch nicht erreicht
      $rows = buildFieldArrayRekursion($neue_url, $rowCount, $newRowCheck, $rows, $mannschaften); //n�chsten Spieltag aufrufen
    }
 
    return $rows;
  }
 
  $mannschaften = array();
  $rows=buildFieldArrayRekursion($url, -1, "", array(), $mannschaften);
  //print_r($rows);
  array_pop($rows); //Aus einem mir nicht ganz klaren Grund enth�lt der letzte Key des Arrays "Datenm�ll". Der wird hiermit gel�scht.
 
  //Jetzt werden den verlegten Spielen die richtigen Spieltagsnummer zugewiesen. Wird �ber Spielnr. gemacht.
 
  $anz_mannschaften = count($mannschaften);
  if ($anz_mannschaften % 2 != 0) echo "<font color=\"red\">Fehler! Ungerade Anzahl von Mannschaften. Spieltagszuordnung kann durcheinander geraten.</font><br>\n";
 
  //Welche Spielnummern geh�ren zu welchem Spieltag?
  //print_r($rows);
  //Die bekannten Spielnummern dem Spieltag zuordnen
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //f�hrende Spieltags-Nullen entfernen
    if ($zeile[2]!='?&?!') {
      $spielnr = $zeile[0];
      //echo $zeile[0].$spielnr."\n";
      $spieltagnr = $zeile[2];
      //echo $spieltagnr."\n";
      $spieltage[$spielnr] = $spieltagnr;
      //Spielnr./Tag-Zuordnung f�r die vorhergehenden Spielnr. ebenfalls eintragen
      for ($k=$spielnr-1; (($k>$spielnr-($anz_mannschaften/2)) and ($k>=0)); $k--) {
         //echo "k: $k\n"; echo "spielnr: $spielnr\n"; echo ($k / ($anz_mannschaften / 2))."\n"; echo ($spielnr / ($anz_mannschaften / 2))."\n\n";
         if (ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) {
            $spieltage[$k] = $spieltage[$spielnr];
         }
      }
      //F�r die nachfolgenden Spiele ebenfalls
      for ($k=$spielnr+1; (($k < $spielnr+($anz_mannschaften/2)) and ($k<=count($rows))); $k++) {
         //echo "k: $k\n"; echo "spielnr: $spielnr\n"; echo ceil($k / ($anz_mannschaften / 2))."\n"; echo ceil(($spielnr / ($anz_mannschaften / 2)))."\n\n";
         if (ceil($k / ($anz_mannschaften / 2)) == ceil($spielnr / ($anz_mannschaften / 2))) {
            $spieltage[$k] = $spieltage[$spielnr];
         }
      }
    } 
  }

  //Den unbekannten Spielen die Spieltagnr zuweisen und neuen Array erstellen
  $rows_bereinigt = array();
  for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    $zeile[0] = preg_replace("/^0{1,2}/",'',$zeile[0]);  //f�hrende Spieltags-Nullen entfernen
    if (($zeile[2]=='?&?!') && ($zeile[6]=='')) { //zeile[6]!='', wenn Spiel ein Verlegungsdatum eingetragen hat
       $zeile[2]=$spieltage[$zeile[0]];
       //Stellt den Spieltag an den Anfang
       $temp = $zeile[0];
       $zeile[0] = $zeile[2];
       $zeile[2] = $temp;
       $neue_zeile = implode('#',$zeile);
       array_push($rows_bereinigt, $neue_zeile);
    } else if ($zeile[6]=='') { //bei Spielen ohne Verlegungsdatum
       //Stellt den Spieltag an den Anfang
       $temp = $zeile[0];
       $zeile[0] = $zeile[2];
       $zeile[2] = $temp;
       $neue_zeile = implode('#',$zeile);
       array_push($rows_bereinigt, $neue_zeile);
    } 
  } 
 
  //Sortierung des Arrays nach dem Spieltag. Ist n�tig, weil der Limporter ansonsten nicht richtig importiert
  natsort($rows_bereinigt);
       
 
  //Die unbekannten Spiele einem Spieltag zuordnen
  /*for ($i=0; $i<count($rows); $i++) {
    $zeile = split('#', $rows[$i]);
    if ($zeile[1]=='?&?!') {
      $spielnr = $zeile[0];
      if (ceil(($spielnr-1) / $anz_mannschaften / 2) == ceil(($spielnr) / $anz_mannschaften / 2)) {
         $zeile2 = split('#', $rows[$i-1]);
        $spieltage[$spielnr] = $zeile2[1];
      } else
 
    $max_spieltage = ($anz_mannschaften - 1)*2;
    for (
}  */
 
  //print_r($spieltage);
  //print_r($rows_bereinigt);
  //print_r($mannschaften);
  //print  $anzahl_mannschaften;
  //Jetzt m�ssen die verlegten Spiele korrigiert werden
  /*$verlegungen = array();
  $rows_bereinigt = array();
  //Suche daf�r alle Spiele, die ein Verlegungsdatum haben
  for ($i=0; $i<count($rows); $i++) {
    if (preg_match("/[^#]#$/", $rows[$i], $ergebnis)) { //verlegte Spiele haben genau ein # am Ende des Datensatzes
      //extrahiere Spiel-Nr. und Spieltags-Nr.
      $ergebnis = split('#', $rows[$i]);
      $verlegungen[$ergebnis[0]] = $ergebnis[2]; //verlegungen[i]=k: i: Spiel-Nr, k: Spieltags-Nr.
    } else array_push($rows_bereinigt, $rows[$i]);
  }
  //Nun m�ssen den verlegten Spielen die urspr�nglichen Spieltags-Nr. wieder hinzugef�gt werden
    $spiele_ohne_datum = 0;  //<- noch nicht ver�.
  for ($i=0; $i<count($rows_bereinigt); $i++) {
    if (strpos($rows_bereinigt[$i], '?&?!')) {
      $ergebnis = split('#', $rows_bereinigt[$i]);
      //**noch nicht ver�ffentlichte �nderung start
      if ($verlegungen[$ergebnis[0]] == '') {
        $ergebnis[2] = 1;
        $spiele_ohne_datum++;
      } else
        $ergebnis[2] = $verlegungen[$ergebnis[0]];
      //**noch nicht ver�ffentlichte �nderung ende
      $rows_bereinigt[$i] = implode('#', $ergebnis);
    }
  }
  if ($spiele_ohne_datum > 0) echo "Zu $spiele_ohne_datum Spiel(en) konnte kein Spieltag gefunden werden.<br>Die Spiele wurden dem 1. Spieltag zugewiesen (au�er Sie haben \"Aktualisieren\" gew�hlt).<br>Bitte manuell korrigieren."; //<- noch nicht ver�.*/
 
  return $rows_bereinigt;
}

?>