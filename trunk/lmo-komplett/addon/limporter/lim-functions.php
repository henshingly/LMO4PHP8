<?PHP
//
// Limporter Functions Version 0.1
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//

function colSelection($elementName,$elementValue,&$rows,$header) {
	if (!isset($elementValue)) {$elementValue=-1;}
	echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
	echo "<option value=-1";
	if($elementValue==-1){echo " selected";}
	echo ">ignorieren</option>\n";
    for ($sp = 0;$sp < count($rows);$sp++) {
        echo "<option value=$sp";
        if($elementValue==$sp){echo " selected";}
        if ($header==1 and $rows[$sp]!=""){echo ">".($rows[$sp])."</option>\n";}
        else echo ">Spalte ".($sp+1)."</option>\n"; // f�r die Anzeige fangen wir bei 1 an.
    }
	echo "</select>\n";

}


function formatSelection($elementName,$elementValue,$formatArray) {
	if (!isset($elementValue)) {$elementValue=0;}
	$values = array_values($formatArray);
	$keys = array_keys($formatArray);
  echo "<select class=\"lmo-formular-input\" name=\"".$elementName."\">\n";
    echo "<option value=0";if($elementValue==0){echo " selected";}echo ">gesamter Zelleninhalt</option>\n";
  for ($x=1;$x<=count($keys);$x++) {
    echo "<option value=$x";if($elementValue==$x){echo " selected";}echo ">".$keys[$x-1]."</option>\n";
  }
  echo "</select>\n";
}


function getParserFiles($dirPath,$importTyp,$noSelectionString='') {
	$settingNamesArray = array();
	$dir = opendir($dirPath);
	if ($importTyp==1) $matchTyp='csv';
	else $matchTyp='html';
  while($files=readdir($dir)){
    if(strtolower(substr($files,-4))==".lim") {
    	$datei = $dirPath."/".$files;
			$ini = new IniFileReader($datei);
			if (strtolower($ini->getIniFile('LIMPORTER','IMPORTTYP','')) == $matchTyp) {
				$def = substr($files,0,35);
				$name = $ini->getIniFile('LIMPORTER','TITLE',$def);
				if (($art=$ini->getIniFile('LIMPORTER','ART',0))<>0) {
           $settingNamesArray[]=array($name,$files,1);
				}
				else {
					$settingNamesArray[]=array($files,$files,-1);
				}
			}
		}
	}
	if (count($settingNamesArray)>0) {
		$sepArray = array(array(str_repeat("-",20),' ',0));
		$settingNamesArray = array_merge(array(array($noSelectionString,null,-2)),$sepArray,$settingNamesArray);
	}
	else {
		$settingNamesArray = array(array($noSelectionString,null,-2));
	}

	foreach ($settingNamesArray as $key => $row) {
		$sort1[$key] = $row[2];
		$sort2[$key] = $row[0];
	}
	array_multisort($sort1, SORT_DESC,$sort2, SORT_ASC, $settingNamesArray);
return $settingNamesArray;
}

function necho ($myString) {
	echo $myString."<BR>\n";
}

function teamKurz($teamName) {
	return substr($teamName,0,5);
}


function treeStrukt ($liga) {
	$s = "";
 	$s .= "['".$liga->name."',null,";
  $optionen = $liga->options->keyValues;
  $s .= "['Optionen',null,";
  foreach ($optionen as $key=>$value) {
    $s .= "['".$key." = ".$value."',null],";
  }
  $s .= "],";
  $s .= "['Mannschaften',null,";
  foreach ($liga->teams as $team) {
    $s .= "['".addslashes($team->name)."',null,";
    $s .= "['Kurzbez: ".addslashes($team->kurz)."',null],";
  	foreach ($team->keyValues as $key=>$value) {
    	$s .= "['".$key.": ".addslashes($value)."',null],";
    }
    $s .= "],";
  }
  $s .= "],";
  $s .= "['Spieltage',null,";
  foreach ($liga->spieltage as $spieltag) {
    $s .= "['".$spieltag->nr.". Spieltag vom ".$spieltag->vonBisString()."','lmo.php?file=".$liga->fileName."&st=".$spieltag->nr."',";
    foreach ($spieltag->partien as $partie) {
      $s .= "['".addslashes($partie->heim->name)." vs. ".addslashes($partie->gast->name)."',null,";
      $s .= "['Datum: ".$partie->datumString()." ".$partie->zeitString()." Uhr',null],";
      if($partie->hTore > -1 ) $s .= "['Ergebnis: ".$partie->hTore." : ".$partie->gTore."',null],";
      if(isset($partie->notiz)) $s .= "['Notiz: ".addslashes($partie->notiz)."',null],";
      $s .= "],";
    }
    $s .= "],";
  }
  $s .= "],]";
	return $s;
}

function jsLigaTree($liga) {
	$s = "[".treeStrukt($liga).",]";
  return $s;
}

function jsLigenTree($ligen,$treeName="") {
		if(!isset($treeName) or $treeName=="" )
			$treeName = "Sportligen";
    $s = "[['".$treeName."',null,";
    foreach($ligen as $liga) {
      $s .= treeStrukt($liga).",";
    }
    $s .= "],]";

return $s;
}


function extractText($content) {
// extractText($content)
// Source from PHP Manual Chapter preg_replace
//
// $document should contain an HTML document.
// This will remove HTML tags, javascript sections
// and white space. It will also convert some
// common HTML entities to their text equivalent.

    $search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                     "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                     "'([\r\n])[\s]+'",                 // Strip out white space
                     "'&(quot|#34);'i",                 // Replace html entities
                     "'&(amp|#38);'i",
                     "'&(lt|#60);'i",
                     "'&(gt|#62);'i",
                     "'&(nbsp|#160);'i",
                     "'&(iexcl|#161);'i",
                     "'&(cent|#162);'i",
                     "'&(pound|#163);'i",
                     "'&(copy|#169);'i",
                     "'&#(\d+);'e");                    // evaluate as php
// white space komplett entfernen !! "\\1"
    $replace = array ("",
                      "",
                      "",
                      "\"",
                      "&",
                      "<",
                      ">",
                      " ",
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      "chr(\\1)");
	$result = preg_replace ($search,$replace,$content);
	return $result;
}


function getFileContent($filename, $use_include_path = 0) {
  // function file_get_contents gibts erst ab PHP V. 4.3.0
  // wenns die also nicht gibt, bauen wir die selber
  if (!function_exists("file_get_contents")) {

    function file_get_contents($filename, $use_include_path = 0) {
      $data = ""; // just to be safe. Dunno, if this is really needed
      $file = @fopen($filename, "rb", $use_include_path);
      if ($file) {
        while (!feof($file)) $data .= fread($file, 1024);
        fclose($file);
      }
      return $data;
    }
  }
	return file_get_contents($filename);
}




function buildFieldArray($url,$detailsRowCheck = 0) {

  function isDetailsRow($content,$newRowCheck) {
  $debug = 0;
  $result = FALSE;
  $ergeb1 = "";
  $ergeb2 = "";

  if ($debug == 1) echo "<BR>[$content][$newRowCheck]";

  if ($content=="" or $newRowCheck=="") $result = TRUE;
  else {
    $array1 = preg_split("/[ |:]/",$content);
    $array2 = preg_split("/[ |:]/",$newRowCheck);

    if(isset($array1[0]))
      $ergeb1 = $array1[0];

    if(isset($array2[0]))
      $ergeb2 = $array2[0];

    if (count($array1)!=count($array2)) $result = TRUE;
    else if (strlen($ergeb1) != strlen($ergeb2)) $result = TRUE;
  }

  return $result;
	}

	function skipRow($rowContent) {
    $result = TRUE;
    if($rowContent=="") $result = TRUE;
    elseif(preg_match("/.*[^#]/",$rowContent)) $result = FALSE; // reihe enth�lt daten
  return $result;
	}

	$rowCount =-1;
	$newRowCheck = "";
	$rows = array();
	$urlContent = getFileContent($url);
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

    	// Ok neue Zeile gefunden, jetzt schauen ob es eine Folgezeile
    	// oder eine neue Partie ist

       if ($trEnd!=FALSE and ($detailsRowCheck == 0 or isDetailsRow($content,$newRowCheck)==FALSE or $rowCount < 1)) {
       		// Wenn die aktuelle Zeile komplett leer ist,dh nur # enth�lt,
       		// dann wird sie mit neuen Daten �berschrieben
       		if ($rowCount < 0 or skipRow($rows[$rowCount])==FALSE) {
          	$rowCount++;
          }
          $rows[$rowCount]=$content;
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
return $rows;
}


function buildCSVArray($url,$csvchar=";",$offset=0) {
	$handle = fopen ($url,"r");
	$rows = array();
	$row=0;
	while ($data = fgetcsv ($handle, 1000, $csvchar)) {
		if($row >= $offset) {
			$rows[] = $data;
		}
		$row++;
	}
	fclose ($handle);
	return $rows;
}


function extractV($value,$exPr) {

	$result = $value;
	if ($exPr!="0") { // Formatierung erforderlich
		preg_match($exPr,$value,$results);
		if (isset($results[1]))
			$result=trim($results[1]);
	}
	return $result;
}


function extractValue(&$regExp,&$array,&$cols,$colKey,$defaultValue=null) {
	$val_index = $cols[$colKey][0];
	$exp_index = $cols[$colKey][1];
	$value = $defaultValue;
	$exPr = $regExp[$exp_index];
	if($val_index > -1) { // ok Colum wurde ausgew�hlt
    if($exPr!="0") { // Formatierung erforderlich
			$value=$array[$val_index];
      preg_match($exPr,$value,$results);
    	if (isset($results[1]))
      	$value=trim($results[1]);
      else { // kein match also default verwenden
				$value = $defaultValue;
      }
		}
		elseif ($array[$val_index] != "") { // Formatierung nicht erforderlich (ganze Zelle wenn nicht leer)
			$value=$array[$val_index];
		}
	}
	else {
		$value = $defaultValue;
	}
	return $value;
}


function buildLigaFromDataArray(&$liga,&$array,$header,&$cols,&$formatArray) {
  $i=0;
  $spTagNr = 0;
  $aktSpTag = 1;
//  $fValues = "0".$fDelimiter.$fValues; // workarround
  $regExp = array_merge( array('0'),array_values($formatArray));
  setLocale (LC_TIME,"ge");
  if ($header == 1) $i=1; // Sind spaltentitel in der ersten Zeile dann diese �berspringen
  while ($i<(count($array))):
    // Heim und Gast ermitteln
    $newTeam[0] = extractValue($regExp,$array[$i],$cols,'HEIM',"TEAMNAME");
    $newTeam[1] = extractValue($regExp,$array[$i],$cols,'GAST',"TEAMNAME");

    // Jeweils f�r Heim und Gast ermitteln ob schon vorhanden
    for ($x=0; $x<=1; $x++) {
      if(!in_array($newTeam[$x],$liga->teamNames())) {
        $liga->addTeam(new team($newTeam[$x],teamKurz($newTeam[$x]),$liga->teamCount()+1));
      }
    }
    // Unix Time f�r Datum und Anpfiffzeit
    $datum = split("\.|-|\/",extractValue($regExp,$array[$i],$cols,'DATUM',"01.01.2001"));
		// Hier sollte noch die LMO Standardzeit eingetragen werden
    $zeit =split(":|,|\.|-",extractValue($regExp,$array[$i],$cols,'ZEIT',"12:00"));

		if(count($datum)!=3) $datum = array("1","1","2001");
		if(count($zeit)!=2) $zeit = array("12","0");

    $spieldatum = mktime(0,0,0,(int)$datum[1],(int)$datum[0],(int)$datum[2]);
    $spielzeit = mktime((int)$zeit[0],(int)$zeit[1],0,(int)$datum[1],(int)$datum[0],(int)$datum[2]);
    $theim = extractValue($regExp,$array[$i],$cols,'THEIM',-1);
    $tgast = extractValue($regExp,$array[$i],$cols,'TGAST',-1);
    $pheim = extractValue($regExp,$array[$i],$cols,'PHEIM');
    $pgast = extractValue($regExp,$array[$i],$cols,'PGAST');
    $nr = extractValue($regExp,$array[$i],$cols,'NR');
    $notiz = extractValue($regExp,$array[$i],$cols,'NOTIZ');
    if ($theim < 0 or $tgast < 0) {
        $theim = -1;
        $tgast = -1;
    }
    // Spielwertung f�r Ergebnis 0:0 ermitteln
    elseif($theim == 0 and $tgast == 0) {
        if($pheim > 0 and $pgast == 0) {$theim = -2;}
        if($pheim == 0 and $pgast > 0) {$tgast = -2;}
    }
    // Partien erstellen
    $partie = & new partie($nr,$spielzeit,$notiz,$liga->teamForName($newTeam[0]),$liga->teamForName($newTeam[1]),$theim,$tgast,"","");

    // Spieltage erstellen
    if(!isset($lastDate))
    	$dayDiv = 356; // Zum Start auf jeden Fall spieltaganlegen
    else {
//floor(abs(strtotime($start_date) - strtotime($end_date))/86400);
		$dayDiv = (abs($spieldatum - $lastDate)/86400); // (int)
//    	echo "<BR>".$dayDiv;
    }

    // Partien an aufeinanderfolgenden Tagen ergeben einen Spieltag
    if ($dayDiv < 2) {
    	$mySpieltag->bis = $spieldatum;
//      $mySpieltag->addPartie($partie);
		$mySpieltag->partien[]=$partie;
    }
    else { // ok Neuen Spieltag erstellen
      $spTagNr ++;
      $mySpieltag = & new spieltag($spTagNr,$spieldatum,$spieldatum);
//      $mySpieltag->addPartie($partie);
		$mySpieltag->partien[]=$partie;
      $liga->spieltage[]=&$mySpieltag;
    }

    if($theim + $tgast > -1) { // aktueller Spieltag muss min. ein Ergebnis enthalten
        $aktSpTag = $spTagNr;
    }
    $lastDate = $spieldatum;
    $i++;
  endwhile;
  $liga->aktSpTag = $aktSpTag;
return TRUE;
}

function editRounds(&$aLiga) {

    echo"<p align='center' style='font-family:Verdana,arial,helvetica;font-size:10pt'>\n";
    echo"<table border= '0' cellspacing='0' align='center'>\n";
    foreach ($aLiga->spieltage as $spTag) {
        echo"<tr><td colspan=9 style='font-size=10pt;background-color=#EEEEEE;border-top-style:solid;border-bottom-style:solid;border-width:1px;border-color:#000000';><strong>".$spTag->nr.". Spieltag - ".$spTag->vonBisString()."</strong></td></tr>\n";
        $pcount = 1;
        foreach ($spTag->partien as $partie) {
            $hTore = $partie->hTore;
            $gTore = $partie->gTore;
            if($hTore == -1 and $gTore == -1) {
      $hTore = "__";
      $gTore = "__";
            }

    echo"<tr><td style='font-size=10pt;'>".$partie->datumString()." ".$partie->zeitString()."</td><td style='font-size=10pt;'>".$partie->heim->name."</td><td>-</td>";
    echo"<td style='font-size=10pt;'>".$partie->gast->name."</td><td align='right' style='font-size=10pt;'>".$hTore."</td><td style='font-size=10pt;'>:</td>";
    echo"<td align='center' style='font-size=10pt;'>".$gTore."</td><td style='font-size=10pt;'></td>\n";

    echo "<td><select class=\"lmoadminein\" name=\"sp_".$spTag->nr."_".$pcount."\">\n";
    for ($sp = 1;$sp <= $aLiga->spieltageCount();$sp++) {
      echo "<option value=$sp";
      if($spTag->nr==$sp){echo " selected";}
      echo ">".$sp.".Spieltag</option>";
    }
    echo "</select></td>\n";
    echo"</tr>\n";
    $pcount++;
        }
    }
    echo"</table></p>\n";
}

function writeLimSettings($fileName,$settings,$message=0) {
//echo "FILE=$fileName";
  $datei = fopen($fileName,"w");
  if (!$datei) {
    echo "<font color=\"#ff0000\">Can't open File (function writeLimSettings($fileName) )</font>";
    exit;
  }else if ($datei and $message==1){
    echo "<font color=\"#008800\">Writing File $fileName (".$datei.")</font>";
  }
  flock($datei,2);
  fputs($datei,"[".$settings->name."]\n");
  foreach($settings->keyValues as $key=>$value) {
    fputs($datei,"$key=$value\n");
  }
  flock($datei,3);
  fclose($datei);
}

// Wird noch von der Function loadFile der Class Liga benoetigt
function getIniData($key,&$array,$defaultV="") {
  if(array_key_exists($key,$array))
    $result = $array[$key];
  else
    $result = $defaultV;
return $result;
}


?>